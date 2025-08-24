@extends('layouts.app')

@section('title', 'Detail User - ' . $user->name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user me-2"></i>
        Detail User: {{ $user->name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i>
                Edit User
            </a>
            @if($user->id !== Auth::id())
                <button type="button" class="btn btn-sm btn-info" onclick="toggleStatus({{ $user->id }})">
                    <i class="fas fa-{{ $user->is_active ? 'user-slash' : 'user-check' }} me-1"></i>
                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- User Profile Card -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <div class="user-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h4 class="card-title">{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->position ?? 'No Position' }}</p>

                <div class="row text-center mt-3">
                    <div class="col-4">
                        <div class="border-end">
                            <div class="h5 mb-0 text-primary">{{ $ticketStats['created'] }}</div>
                            <small class="text-muted">Tiket</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border-end">
                            <div class="h5 mb-0 text-info">{{ $user->created_at->diffInDays(now()) }}</div>
                            <small class="text-muted">Hari</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="h5 mb-0
                            @if($user->role === 'admin') text-danger
                            @elseif($user->role === 'approval') text-warning
                            @else text-success
                            @endif">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        <small class="text-muted">{{ ucfirst($user->role) }}</small>
                    </div>
                </div>

                <div class="mt-3">
                    @if($user->is_active)
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check-circle me-1"></i>
                            Aktif
                        </span>
                    @else
                        <span class="badge bg-secondary fs-6">
                            <i class="fas fa-times-circle me-1"></i>
                            Nonaktif
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-address-card me-2"></i>
                    Informasi Kontak
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="small text-muted">NIP</label>
                    <div class="fw-bold font-monospace">{{ $user->nip }}</div>
                </div>

                <div class="mb-3">
                    <label class="small text-muted">Email</label>
                    <div>
                        <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                            {{ $user->email }}
                        </a>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small text-muted">No. Handphone</label>
                    <div>
                        @if($user->no_hp)
                            <a href="tel:{{ $user->no_hp }}" class="text-decoration-none font-monospace">
                                {{ $user->no_hp }}
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small text-muted">Department</label>
                    <div class="fw-bold">{{ $user->department }}</div>
                </div>

                <div class="mb-3">
                    <label class="small text-muted">Bergabung</label>
                    <div>{{ $user->created_at->format('d F Y') }}</div>
                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                </div>

                <div>
                    <label class="small text-muted">Last Update</label>
                    <div>{{ $user->updated_at->format('d F Y, H:i') }}</div>
                    <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- User Statistics -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Tiket Dibuat
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ticketStats['created'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Tiket Selesai
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $user->createdTickets()->where('status', 'completed')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Tiket Pending
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $user->createdTickets()->whereIn('status', ['open', 'in_progress'])->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tickets -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Tiket Terbaru (5 Terakhir)
                </h6>
            </div>
            <div class="card-body">
                @if($user->createdTickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->createdTickets()->latest()->take(5)->get() as $ticket)
                                <tr>
                                    <td>
                                        <span class="font-monospace">{{ $ticket->ticket_number }}</span>
                                    </td>
                                    <td>{{ Str::limit($ticket->title, 30) }}</td>
                                    <td>
                                        <span class="badge {{ $ticket->getStatusBadgeClass() }}">
                                            {{ $ticket->getStatusText() }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
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
                        <a href="{{ route('tickets.index') }}?created_by={{ $user->id }}" class="btn btn-primary">
                            <i class="fas fa-eye me-1"></i>
                            Lihat Semua Tiket User Ini
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-muted">Belum Ada Tiket</h5>
                        <p class="text-muted">User ini belum pernah membuat tiket.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.border-left-primary { border-left: 0.25rem solid #2E7D32 !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
.text-gray-800 { color: #5a5c69 !important; }
.text-gray-300 { color: #dddfeb !important; }
.user-avatar {
    background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
}
.border-end { border-right: 1px solid #dee2e6 !important; }
</style>
@endpush

@push('scripts')
<script>
function toggleStatus(userId) {
    if (confirm('Apakah Anda yakin ingin mengubah status user ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${userId}/toggle-status`;

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';

        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection
