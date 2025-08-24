@extends('layouts.app')

@section('title', 'Kelola Jenis Layanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-cogs me-2"></i>
        Kelola Jenis Layanan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.service-types.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Jenis Layanan
            </a>
            <button class="btn btn-sm btn-outline-secondary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-1"></i>
                Refresh
            </button>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.service-types.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="is_active" class="form-label">Status</label>
                <select name="is_active" id="is_active" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="requires_file" class="form-label">File Pendukung</label>
                <select name="requires_file" id="requires_file" class="form-select">
                    <option value="">Semua</option>
                    <option value="1" {{ request('requires_file') === '1' ? 'selected' : '' }}>Diperlukan</option>
                    <option value="0" {{ request('requires_file') === '0' ? 'selected' : '' }}>Tidak Diperlukan</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="search" class="form-label">Pencarian</label>
                <input type="text" name="search" id="search" class="form-control"
                       placeholder="Cari nama atau deskripsi..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Service Types Table -->
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            Daftar Jenis Layanan
        </h5>
        <span class="badge bg-primary">{{ $serviceTypes->total() }} total layanan</span>
    </div>
    <div class="card-body">
        @if($serviceTypes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>File Required</th>
                            <th>Estimasi</th>
                            <th>Tiket</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serviceTypes as $serviceType)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $serviceType->name }}</div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" title="{{ $serviceType->description }}">
                                    {{ Str::limit($serviceType->description, 80) }}
                                </div>
                            </td>
                            <td class="text-center">
                                @if($serviceType->requires_file)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-paperclip"></i> Ya
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times"></i> Tidak
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $serviceType->estimated_days }} hari</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $serviceType->tickets_count }}</span>
                            </td>
                            <td>
                                @if($serviceType->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.service-types.show', $serviceType) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.service-types.edit', $serviceType) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-info"
                                            onclick="toggleStatus({{ $serviceType->id }})"
                                            title="{{ $serviceType->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $serviceType->is_active ? 'toggle-off' : 'toggle-on' }}"></i>
                                    </button>

                                    @if($serviceType->tickets_count == 0)
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteServiceType({{ $serviceType->id }})"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div>
                    <small class="text-muted fw-medium">
                        Menampilkan {{ $serviceTypes->firstItem() }} - {{ $serviceTypes->lastItem() }}
                        dari {{ $serviceTypes->total() }} layanan
                    </small>
                </div>
                <div class="pagination-wrapper">
                    {{ $serviceTypes->appends(request()->query())->links('custom.pagination') }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-cogs fa-4x text-gray-300 mb-3"></i>
                <h5 class="text-muted">Tidak Ada Jenis Layanan</h5>
                <p class="text-muted">Belum ada jenis layanan yang terdaftar atau tidak ada yang sesuai dengan filter.</p>
                <a href="{{ route('admin.service-types.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Tambah Jenis Layanan Pertama
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination-wrapper .pagination {
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .pagination-wrapper {
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
function refreshPage() {
    window.location.reload();
}

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

function deleteServiceType(serviceTypeId) {
    if (confirm('Apakah Anda yakin ingin menghapus jenis layanan ini? Aksi ini tidak dapat dibatalkan.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/service-types/${serviceTypeId}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';

        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection
