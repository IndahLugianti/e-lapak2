@extends('layouts.app')

@section('title', 'Pegawai Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user me-2"></i>
        Dashboard Pegawai
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i>
                Buat Tiket Baru
            </a>
            <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-list me-1"></i>
                Lihat Semua Tiket
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: var(--primary-color);">
                            Total Tiket Saya
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $myTickets }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Tiket Pengajuan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengajuanTickets }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Tiket Selesai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $selesaiTickets }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="row">
    <div class="col-lg-8">
        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-rocket me-2"></i>
                    Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="action-card h-100">
                            <div class="action-icon bg-success">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="action-content">
                                <h5>Buat Tiket Baru</h5>
                                <p class="text-muted mb-3">Ajukan permintaan atau laporkan masalah baru</p>
                                <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i>
                                    Buat Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="action-card h-100">
                            <div class="action-icon bg-success">
                                <i class="fas fa-list-check"></i>
                            </div>
                            <div class="action-content">
                                <h5>Kelola Tiket</h5>
                                <p class="text-muted mb-3">Lihat dan kelola semua tiket Anda</p>
                                <a href="{{ route('tickets.index') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-list me-1"></i>
                                    Lihat Tiket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Overview -->
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
            <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-chart-pie me-2"></i>
                    Status Tiket Anda
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="status-item">
                            <div class="status-icon bg-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h4 class="mt-2">{{ $pengajuanTickets }}</h4>
                            <p class="text-muted">Menunggu</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="status-item">
                            <div class="status-icon bg-info">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <h4 class="mt-2">{{ $myTickets - $pengajuanTickets - $selesaiTickets }}</h4>
                            <p class="text-muted">Diproses</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="status-item">
                            <div class="status-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h4 class="mt-2">{{ $selesaiTickets }}</h4>
                            <p class="text-muted">Selesai</p>
                        </div>
                    </div>
                </div>

                @if($myTickets > 0)
                <div class="mt-4">
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-warning" style="width: {{ ($pengajuanTickets / $myTickets) * 100 }}%"></div>
                        <div class="progress-bar bg-info" style="width: {{ (($myTickets - $pengajuanTickets - $selesaiTickets) / $myTickets) * 100 }}%"></div>
                        <div class="progress-bar bg-success" style="width: {{ ($selesaiTickets / $myTickets) * 100 }}%"></div>
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted">
                            Progress: {{ $myTickets > 0 ? number_format(($selesaiTickets / $myTickets) * 100, 1) : 0 }}% tiket selesai
                        </small>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>

    <div class="col-lg-4">


        <!-- Status Tiket Saya -->
        {{-- <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i>
                    Status Tiket Saya
                </h6>
            </div>
            <div class="card-body">
                @php
                    $statusCounts = [
                        'open' => \App\Models\Ticket::where('created_by', Auth::id())->where('status', 'open')->count(),
                        'in_progress' => \App\Models\Ticket::where('created_by', Auth::id())->where('status', 'in_progress')->count(),
                        'pending_approval' => \App\Models\Ticket::where('created_by', Auth::id())->where('status', 'pending_approval')->count(),
                        'approved' => \App\Models\Ticket::where('created_by', Auth::id())->where('status', 'approved')->count(),
                        'rejected' => \App\Models\Ticket::where('created_by', Auth::id())->where('status', 'rejected')->count(),
                        'closed' => \App\Models\Ticket::where('created_by', Auth::id())->where('status', 'closed')->count(),
                    ];
                @endphp

                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border-bottom pb-2">
                            <div class="h5 mb-0 text-primary">{{ $statusCounts['open'] }}</div>
                            <small class="text-muted">Open</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border-bottom pb-2">
                            <div class="h5 mb-0 text-warning">{{ $statusCounts['in_progress'] }}</div>
                            <small class="text-muted">In Progress</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border-bottom pb-2">
                            <div class="h5 mb-0 text-info">{{ $statusCounts['pending_approval'] }}</div>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border-bottom pb-2">
                            <div class="h5 mb-0 text-success">{{ $statusCounts['approved'] }}</div>
                            <small class="text-muted">Approved</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="h5 mb-0 text-danger">{{ $statusCounts['rejected'] }}</div>
                        <small class="text-muted">Rejected</small>
                    </div>
                    <div class="col-6">
                        <div class="h5 mb-0 text-secondary">{{ $statusCounts['closed'] }}</div>
                        <small class="text-muted">Closed</small>
                    </div>
                </div>
            </div>
        </div> --}}



           <!-- Profile Info -->
            <div class="card shadow">
            <div class="card-header py-3" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-user me-2"></i>
                    Informasi Profil
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="user-avatar mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                    <small class="text-muted">{{ Auth::user()->nip }}</small>
                </div>

                <div class="small">
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Department:</div>
                        <div class="col-7">{{ Auth::user()->department }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Position:</div>
                        <div class="col-7">{{ Auth::user()->position ?? 'Staff' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Role:</div>
                        <div class="col-7">
                            <span class="badge bg-success">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Email:</div>
                        <div class="col-7 text-truncate">{{ Auth::user()->email ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Bergabung:</div>
                        <div class="col-7">{{ Auth::user()->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5 text-muted">Status:</div>
                        <div class="col-7">
                            <span class="badge bg-{{ Auth::user()->is_active ? 'success' : 'danger' }}">
                                {{ Auth::user()->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            </div>


@push('styles')
<style>
.border-left-primary { border-left: 0.25rem solid var(--primary-color) !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.text-gray-800 { color: #5a5c69 !important; }
.text-gray-300 { color: #dddfeb !important; }

.user-avatar {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
}

.table-hover tbody tr:hover { background-color: rgba(0,0,0,.02); }

/* Card headers dengan kontras yang baik */
.card-header h6.text-white {
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

/* Quick Actions Cards */
.action-card {
    background: white;
    border: 1px solid #e3e6f0;
    border-radius: 10px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-color: var(--primary-color);
}

.action-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.action-content h5 {
    color: #2d3748;
    margin-bottom: 0.5rem;
}

/* Status Overview */
.status-item {
    padding: 1rem;
}

.status-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin: 0 auto;
}

/* Tips & Info */
.tip-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.tip-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}

.tip-content h6 {
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.tip-content ul {
    color: #6b7280;
}

/* Progress bar styling */
.progress {
    background-color: #f1f3f4;
    border-radius: 10px;
}

.progress-bar {
    transition: width 0.6s ease;
}
</style>
@endpush

@endsection
