<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('departmentRef');

        // Apply filters
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        // Get filter data
        $roles = ['admin', 'approval', 'pegawai'];
        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles', 'departments'));
    }

    public function create()
    {
        $roles = ['admin', 'approval', 'pegawai'];
        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('admin.users.create', compact('roles', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|unique:users,nip|max:20',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string|max:15|unique:users,no_hp',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,approval,pegawai',
            'department_id' => 'required|exists:departments,id',
            'position' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'no_hp.unique' => 'No. HP sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'department_id.required' => 'Department wajib dipilih.',
            'department_id.exists' => 'Department tidak valid.',
        ]);

        User::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department_id' => $request->department_id,
            'position' => $request->position,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load(['createdTickets', 'departmentRef']);

        $ticketStats = [
            'created' => $user->createdTickets()->count(),
        ];

        return view('admin.users.show', compact('user', 'ticketStats'));
    }

    public function edit(User $user)
    {
        $roles = ['admin', 'approval', 'pegawai'];
        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nip' => 'required|string|max:20|unique:users,nip,' . $user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:15|unique:users,no_hp,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,approval,pegawai',
            'department_id' => 'required|exists:departments,id',
            'position' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'no_hp.unique' => 'No. HP sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'department_id.required' => 'Department wajib dipilih.',
            'department_id.exists' => 'Department tidak valid.',
        ]);

        $updateData = [
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
            'department_id' => $request->department_id,
            'position' => $request->position,
            'is_active' => $request->is_active,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting current user
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // Check if user has tickets
        $ticketCount = $user->createdTickets()->count();
        if ($ticketCount > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User tidak dapat dihapus karena memiliki ' . $ticketCount . ' tiket.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User ' . $userName . ' berhasil dihapus.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.users.index')
            ->with('success', 'User ' . $user->name . ' berhasil ' . $status . '.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'password123';

        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Password user ' . $user->name . ' berhasil direset ke: ' . $newPassword);
    }
}
