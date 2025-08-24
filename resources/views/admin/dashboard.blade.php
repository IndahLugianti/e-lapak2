
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt me-2"></i>
        Admin Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i>
                Buat Tiket Baru
            </a>
            <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-list me-1"></i>
                Kelola Tiket
            </a>
        </div>
        <button class="btn btn-sm btn-outline-info" onclick="refreshStats()">
            <i class="fas fa-sync-alt me-1" id="refreshIcon"></i>
            Refresh
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Tiket
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalTickets">
                            {{ $totalTickets }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pengajuan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="pengajuanTickets">
                            {{ $pengajuanTickets }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Proses
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="prosesTickets">
                            {{ $prosesTickets }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cogs fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Selesai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="selesaiTickets">
                            {{ $selesaiTickets }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Additional Stats Row -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Total Users
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalUsers">
                            {{ $totalUsers }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Jenis Layanan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalServiceTypes">
                            {{ $totalServiceTypes }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-concierge-bell fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-purple shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-purple text-uppercase mb-1">
                            Tiket Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="todayTickets">
                            {{ \App\Models\Ticket::whereDate('created_at', today())->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-teal shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-teal text-uppercase mb-1">
                            Selesai Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="todayCompleted">
                            {{ \App\Models\Ticket::whereDate('completed_at', today())->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-double fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold" style="color: white;">
                    <i class="fas fa-chart-pie me-2"></i>
                    Status Tiket
                </h6>
            </div>
            <div class="card-body">
                <canvas id="statusChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold" style="color: white;">
                    <i class="fas fa-chart-bar me-2"></i>
                    7 Hari Terakhir
                </h6>
            </div>
            <div class="card-body">
                <canvas id="weeklyChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Quick Info -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold" style="color: white;">
                    <i class="fas fa-history me-2"></i>
                    Tiket Terbaru
                </h6>
                @if($recentTickets->count() > 0)
                    <small style="color: white;">{{ $recentTickets->count() }} tiket terbaru</small>
                @endif
            </div>
            <div class="card-body">
                @if($recentTickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Judul</th>
                                    <th>Pemohon</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTickets as $ticket)
                                <tr>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-decoration-none fw-bold">
                                            {{ $ticket->ticket_number }}
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($ticket->title, 40) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2">
                                                {{ substr($ticket->creator->name, 0, 1) }}
                                            </div>
                                            <small>{{ $ticket->creator->name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $ticket->getStatusBadgeClass() }}">
                                            {{ $ticket->getStatusText() }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $ticket->created_at ? $ticket->created_at->format('d/m/Y H:i') : '-' }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                            <i class="fas fa-list me-1"></i>
                            Lihat Semua Tiket
                        </a>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-4x text-gray-300 mb-3"></i>
                        <h5 class="text-muted">Belum Ada Tiket</h5>
                        <p class="text-muted">Belum ada tiket yang diajukan oleh pegawai.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold" style="color: white;">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Buat Tiket Baru
                    </a>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>
                        Kelola Tiket
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-users me-2"></i>
                        Kelola Users
                    </a>
                    <button class="btn btn-outline-info" onclick="showStatistics()">
                        <i class="fas fa-chart-bar me-2"></i>
                        Lihat Statistik
                    </button>
                </div>
            </div>
        </div>


    </div>
</div>

@push('styles')
        <style>
        .border-left-primary { border-left: 0.25rem solid #2E7D32 !important; }
        .border-left-warning { border-left: 0.25rem solid #ffc107 !important; }
        .border-left-info { border-left: 0.25rem solid #66BB6A !important; }
        .border-left-success { border-left: 0.25rem solid #28a745 !important; }
        .border-left-dark { border-left: 0.25rem solid #5a5c69 !important; }
        .border-left-secondary { border-left: 0.25rem solid #6c757d !important; }
        .border-left-purple { border-left: 0.25rem solid #8b5cf6 !important; }
        .border-left-teal { border-left: 0.25rem solid #20c997 !important; }

        .text-gray-800 { color: #5a5c69 !important; }
        .text-gray-300 { color: #dddfeb !important; }
        .text-purple { color: #8b5cf6 !important; }
        .text-teal { color: #20c997 !important; }

        .user-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, #2E7D32 0%, #1B5E20 100%);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600; font-size: 0.8rem;
        }

        .card:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease-in-out;
        }

        #refreshIcon.fa-spin {
            animation: fa-spin 1s infinite linear;
        }

        @keyframes fa-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        </style>
@endpush

@push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <script>
        // Initialize Charts
        let statusChart, weeklyChart;

        document.addEventListener('DOMContentLoaded', function() {
            initCharts();
            updateClock();
            setInterval(updateClock, 1000);
        });

        function initCharts() {
            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pengajuan', 'Proses', 'Selesai'],
                    datasets: [{
                        data: [{{ $pengajuanTickets }}, {{ $prosesTickets }}, {{ $selesaiTickets }}],
                        backgroundColor: ['#ffc107', '#66BB6A', '#28a745'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Weekly Chart - Sample data (you can replace with actual data)
            const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
            weeklyChart = new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Tiket Dibuat',
                        data: [12, 19, 8, 15, 25, 10, 5], // Replace with actual data
                        backgroundColor: '#2E7D32',
                        borderColor: '#1B5E20',
                        borderWidth: 1
                    }, {
                        label: 'Tiket Selesai',
                        data: [8, 15, 6, 12, 20, 8, 3], // Replace with actual data
                        backgroundColor: '#28a745',
                        borderColor: '#1e7e34',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function refreshStats() {
            const refreshIcon = document.getElementById('refreshIcon');
            refreshIcon.classList.add('fa-spin');

            // Simulate refresh (replace with actual AJAX call)
            setTimeout(() => {
                refreshIcon.classList.remove('fa-spin');
                updateLastUpdateTime();
                // You can add actual AJAX call here to refresh data
            }, 1000);
        }

        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('serverTime').textContent = timeString;
        }

        function updateLastUpdateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID');
            document.getElementById('lastUpdate').textContent = timeString;
        }

        function showStatistics() {
            // You can implement a modal or redirect to detailed statistics page
            alert('Fitur statistik detail akan segera hadir!');
        }

        // Auto refresh every 5 minutes
        setInterval(() => {
            refreshStats();
        }, 300000);
        </script>
@endpush
@endsection
