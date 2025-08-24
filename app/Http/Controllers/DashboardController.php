<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\ServiceType;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalTickets = Ticket::count();
        $pengajuanTickets = Ticket::where('status', 'pengajuan')->count();
        $prosesTickets = Ticket::where('status', 'proses')->count();
        $selesaiTickets = Ticket::where('status', 'selesai')->count();
        $totalUsers = User::count();
        $totalServiceTypes = ServiceType::active()->count();

        $recentTickets = Ticket::with(['creator', 'serviceType'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalTickets',
            'pengajuanTickets',
            'prosesTickets',
            'selesaiTickets',
            'totalUsers',
            'totalServiceTypes',
            'recentTickets'
        ));
    }

    public function approvalDashboard()
    {

        // Hitung statistik
        $needReviewTickets = Ticket::where('status', 'pengajuan')->count();
        $approvedToday = Ticket::where('status', 'selesai')
                            ->whereDate('completed_at', today())
                            ->count();
        $totalTickets = Ticket::count();

        // Hitung average response time (dalam jam)
        $avgResponseTime = Ticket::where('status', 'selesai')
                                ->whereNotNull('completed_at')
                                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, completed_at)) as avg_hours')
                                ->value('avg_hours') ?? 0;
        $avgResponseTime = round($avgResponseTime);

        // Tiket yang perlu review
        $reviewTickets = Ticket::with(['creator', 'serviceType'])
                            ->where('status', 'pengajuan')
                            ->latest()
                            ->take(5)
                            ->get();

        // Recent activity
        $recentActivity = Ticket::with(['creator'])
                                ->whereIn('status', ['proses', 'selesai'])
                                ->latest('updated_at')
                                ->take(5)
                                ->get();

        return view('approval.dashboard', compact(
            'needReviewTickets',
            'approvedToday',
            'totalTickets',
            'avgResponseTime',
            'reviewTickets',
            'recentActivity'
        ));
        dd([
            'user_role' => Auth::user()->role,
            'is_approval' => Auth::user()->isApproval(),
            'tickets_proses' => Ticket::where('status', 'proses')->count(),
            'all_tickets' => Ticket::pluck('status')->toArray()
        ]);

    }

    public function pegawaiDashboard()
    {
        $userId = Auth::id();
        Auth::user()->id;

        // Single query dengan conditional count
        $ticketStats = Ticket::where('created_by', $userId)
            ->selectRaw('
                COUNT(*) as total,
                SUM(status = "pengajuan") as pengajuan,
                SUM(status = "proses") as proses,
                SUM(status = "selesai") as selesai
            ')
            ->first();

        $recentTickets = Ticket::with(['serviceType'])
            ->where('created_by', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('pegawai.dashboard', [
            'myTickets' => $ticketStats->total,
            'pengajuanTickets' => $ticketStats->pengajuan,
            'prosesTickets' => $ticketStats->proses,
            'selesaiTickets' => $ticketStats->selesai,
            'recentTickets' => $recentTickets
        ]);
    }
    public function bantuanPegawai()
    {
        $adminContact = User::where('role', 'admin')
                            ->whereNotNull('no_hp')
                            ->first();

        return view('pegawai.bantuan', [
            'admin_phone' => $adminContact ? $adminContact->no_hp : null,
            'admin_email' => $adminContact ? $adminContact->email : null
        ]);
    }

}
