@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users me-2"></i>
        Kelola User
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah User Baru
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
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
            <div class="col-md-2">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="">Semua Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="department" class="form-label">Unit Kerja</label>
                <select name="department" id="department" class="form-select">
                    <option value="">Semua Unit Kerja</option>
                    @foreach($departments as $department)
                        <option value="{{ is_object($department) ? $department->name : $department }}" {{ request('department') == (is_object($department) ? $department->name : $department) ? 'selected' : '' }}>
                            {{ is_object($department) ? $department->name : $department }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="is_active" class="form-label">Status</label>
                <select name="is_active" id="is_active" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Pencarian</label>
                <input type="text" name="search" id="search" class="form-control"
                       placeholder="Cari nama, NIP, atau email..." value="{{ request('search') }}">
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

<!-- Users Table -->
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            Daftar User
        </h5>
        <span class="badge bg-primary">{{ $users->total() }} total user</span>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $user->name }}</div>
                                        {{-- <small class="text-muted">{{ $user->position ?? 'No Position' }}</small> --}}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="font-monospace">{{ $user->nip }}</span>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->no_hp)
                                    <span class="font-monospace">{{ $user->no_hp }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge
                                    @if($user->role === 'admin') bg-danger
                                    @elseif($user->role === 'approval') bg-warning
                                    @else bg-success
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->department }}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">{{ $user->created_at->format('d/m/Y') }}</div>
                                {{-- <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small> --}}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    @if($user->id !== Auth::id())
                                        <button type="button"
                                                class="btn btn-sm btn-outline-info"
                                                onclick="toggleStatus({{ $user->id }})"
                                                title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $user->is_active ? 'user-slash' : 'user-check' }}"></i>
                                        </button>

                                        <button type="button"
                                                class="btn btn-sm btn-outline-secondary"
                                                onclick="resetPassword({{ $user->id }})"
                                                title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </button>

                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteUser({{ $user->id }})"
                                                title="Hapus User">
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
                        Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }}
                        dari {{ $users->total() }} user
                    </small>
                </div>
                <div class="pagination-wrapper">
                    {{ $users->appends(request()->query())->links('custom.pagination') }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-gray-300 mb-3"></i>
                <h5 class="text-muted">Tidak Ada User</h5>
                <p class="text-muted">Belum ada user yang terdaftar atau tidak ada yang sesuai dengan filter.</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Tambah User Pertama
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1rem;
}

.table-hover tbody tr:hover { 
    background-color: rgba(0,0,0,.02); 
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Additional pagination container styling */
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

function resetPassword(userId) {
    if (confirm('Apakah Anda yakin ingin reset password user ini ke "password123"?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${userId}/reset-password`;

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';

        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function deleteUser(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus user ini? Aksi ini tidak dapat dibatalkan.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${userId}`;

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
