@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-cog me-2"></i>
        Pengaturan Profil
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Profile Information -->
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>
                    Informasi Profil
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text"
                                   class="form-control @error('nip') is-invalid @enderror"
                                   id="nip"
                                   name="nip"
                                   value="{{ old('nip', $user->nip) }}"
                                   required readonly>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label">No. Telepon</label>
                            <input type="text"
                                   class="form-control @error('no_hp') is-invalid @enderror"
                                   id="no_hp"
                                   name="no_hp"
                                   value="{{ old('no_hp', $user->no_hp) }}"
                                   placeholder="Opsional">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="position" class="form-label">Jabatan</label>
                            <input type="text"
                                   class="form-control @error('position') is-invalid @enderror"
                                   id="position"
                                   name="position"
                                   value="{{ old('position', $user->position) }}"
                                   placeholder="Opsional">
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="department_id" class="form-label">Unit Kerja</label>
                            <select class="form-select @error('department_id') is-invalid @enderror"
                                    id="department_id"
                                    name="department_id">
                                <option value="">Pilih Unit Kerja</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}"
                                            {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            {{-- <div class="form-text">Pilih unit kerja sesuai dengan tugas Anda.</div> --}}
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Change -->
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-lock me-2"></i>
                    Ubah Password
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               id="current_password"
                               name="current_password"
                               required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password"
                               class="form-control"
                               id="password_confirmation"
                               name="password_confirmation"
                               required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-2"></i>
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Akun
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="user-avatar-large mb-2" style="width: 80px; height: 80px; font-size: 2rem; margin: 0 auto;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h6 class="mb-1">{{ $user->name }}</h6>
                    <small class="text-muted">{{ ucfirst($user->role) }}</small>
                </div>

                <div class="small">
                    <div class="row mb-2">
                        <div class="col-5 text-muted">NIP:</div>
                        <div class="col-7 fw-bold">{{ $user->nip }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Email:</div>
                        <div class="col-7">{{ $user->email ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Jabatan:</div>
                        <div class="col-7">{{ $user->position ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Unit Kerja:</div>
                        <div class="col-7">{{ $user->departmentRef->name ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">No. HP:</div>
                        <div class="col-7">{{ $user->no_hp ?? '-' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5 text-muted">Bergabung:</div>
                        <div class="col-7">{{ $user->created_at->format('M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.user-avatar-large {
    background: linear-gradient(135deg,
        var(--primary-transparent) 0%,
        var(--primary-color) 50%,
        var(--primary-dark) 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(6, 95, 70, 0.2);
}

.btn-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border: none;
    font-weight: 600;
    color: white;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    color: white;
    transform: translateY(-1px);
}
</style>
@endpush
@endsection
