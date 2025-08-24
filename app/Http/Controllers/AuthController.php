<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        $users = User::where('is_active', true)
                     ->select('nip', 'name')
                     ->orderBy('name')
                     ->get();
        
        return view('auth.login', compact('users'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('nip', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'nip' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ]);
            }

            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $user->name);
                case 'approval':
                    return redirect()->route('approval.dashboard')->with('success', 'Selamat datang, ' . $user->name);
                case 'pegawai':
                    return redirect()->route('pegawai.dashboard')->with('success', 'Selamat datang, ' . $user->name);
                default:
                    return redirect()->route('login');
            }
        }

        return back()->withErrors([
            'nip' => 'NIP atau password yang Anda masukkan salah.',
        ])->withInput($request->only('nip'));
    }

    public function logout(Request $request)
    {
        $userName = Auth::user()->name;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout. Terima kasih, ' . $userName);
    }
}
