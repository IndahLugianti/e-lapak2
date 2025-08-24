@extends('layouts.app')

@section('title', 'Detail Jenis Layanan - ' . $serviceType->name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-cog me-2"></i>
        Detail Jenis Layanan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.service-types.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
            <a href="{{ route('admin.service-types.edit', $serviceType) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i>
                Edit
            </a>
            <button type="button" class="btn btn-sm btn-info" onclick="toggleStatus({{ $serviceType->id }})">
                <i class="fas fa-{{ $serviceType->is_active ? 'toggle-off' : 'toggle-on' }} me-1"></i>
                {{ $serviceType->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Service Type Info Card -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <div class="service-icon mx-auto mb-3">
                    <i class="fas fa-cogs fa-4x text-primary"></i>
                </div>
                <h4 class="card-title">{{ $serviceType->name }}</h4>

                <div class="row text-center mt-3">
                    <div class="col-4">
                        <div class="border-end">
                            <div class="h5 mb-0 text-primary">{{ $ticketStats['total'] }}</div>
                            <small class="text-muted">Total Tiket</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border-end">
                            <div class="h5 mb-0 text-info">{{ $serviceType->estimated_days }}</div>
                            <small class="text-muted">Hari</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="h5 mb-0 {{ $serviceType->requires_file ? 'text-warning' : 'text-success' }}">
                            <i class="fas fa-{{ $serviceType->requires_file ? 'paperclip' : 'check' }}"></i>
                        </div>
                        <small class="text-muted">{{ $serviceType->requires_file ? 'File Required' : 'No File' }}</small>
                    </div>
                </div>

                <div class="mt-3">
                    @if($serviceType->is_active)
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

        <!-- Details -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Detail Informasi
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="small text-muted">Deskripsi</label>
                    <div class="bg-light p-3 rounded">{{ $serviceType->description }}</div>
                </div>

                @if($serviceType->requires_file && $serviceType->file_requirements)
                <div class="mb-3">
                    <label class="small text-muted">File yang Diperlukan</label>
                    <div class="bg-warning bg-opacity-10 p-3 rounded border border-warning">
                        <i class="fas fa-paperclip text-warning me-2"></i>
                        {{ $serviceType->file_requirements }}
                    </div>
                </div>
                @endif

                <div class="mb-3">
                    <label class="small text-muted">Dibuat</label>
                    <div>{{ $serviceType->created_at->format('d F Y, H:i') }}</div>
                    <small class="text-muted">{{ $serviceType->created_at->diffForHumans() }}</small>
                </div>

                <div>
                    <label class="small text-muted">Last Update</label>
                    <div>{{ $serviceType->updated_at->format('d F Y, H:i') }}</div>
                    <small class="text-muted">{{ $serviceType->updated_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Tiket
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ticketStats['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ticketStats['open'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ticketStats['completed'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                    Tiket Terbaru (10 Terakhir)
                </h6>
            </div>
            <div class="card-body">
                @if($serviceType->tickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
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
                                @foreach($serviceType->tickets()->with('creator')->latest()->take(10)->get() as $ticket)
                                <tr>
                                    <td>
                                        <span class="font-monospace small">{{ $ticket->ticket_number }}</span>
                                    </td>
                                    <td>{{ Str::limit($ticket->title, 25) }}</td>
                                    <td>
                                        <div class="small">{{ $ticket->creator->name }}</div>
                                        <small class="text-muted">{{ $ticket->creator->department }}</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $ticket->getStatusBadgeClass() }}">
                                            {{ $ticket->getStatusText() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="small">{{ $ticket->created_at->format('d/m/Y') }}</div>
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
                        <a href="{{ route('tickets.index') }}?service_type={{ $serviceType->id }}" class="btn btn-primary">
                            <i class="fas fa-eye me-1"></i>
                            Lihat Semua Tiket Layanan Ini
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-muted">Belum Ada Tiket</h5>
                        <p class="text-muted">Belum ada tiket yang menggunakan jenis layanan ini.</p>
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
.border-end { border-right: 1px solid #dee2e6 !important; }
.service-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}
</style>
@endpush

@push('scripts')
<script>
function toggleStatus(serviceTypeId) {
    if (confirm('Apakah Anda yakin ingin mengubah status jenis layanan ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/service-types/${serviceTypeId}/toggle-status`;

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
