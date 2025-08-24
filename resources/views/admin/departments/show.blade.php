@extends('layouts.app')

@section('title', 'Detail Department - ' . $departmentName)

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"> <h1 class="h2"> <i class="fas fa-building me-2"></i> Detail Department: {{ $departmentName }} </h1> <div class="btn-toolbar"> <div class="btn-group"> <a href="{{ route('admin.departments.index') }}" class="btn btn-sm btn-outline-secondary"> <i class="fas fa-arrow-left me-1"></i> Kembali </a> <a href="{{ route('admin.departments.edit', urlencode($departmentName)) }}" class="btn btn-sm btn-warning"> <i class="fas fa-edit me-1"></i> Edit </a> <button type="button" class="btn btn-sm btn-info" onclick="openMoveUsers('{{ $departmentName }}')"> <i class="fas fa-exchange-alt me-1"></i> Pindah User </button> </div> </div> </div> <div class="row"> <div class="col-lg-4"> <div class="card shadow mb-4"> <div class="card-body text-center"> <div class="department-icon mx-auto mb-3" style="width:70px;height:70px;"> <i class="fas fa-building"></i> </div> <h4 class="card-title">{{ $departmentName }}</h4> <div class="mt-3"> <span class="badge bg-primary fs-6">{{ $departmentStats['total_users'] }} User</span> </div> <div class="mt-3 small"> <div>Aktif: <strong>{{ $departmentStats['active_users'] }}</strong></div> <div>Tiket: <strong>{{ $departmentStats['total_tickets'] }}</strong></div> <div>Admin: <strong>{{ $departmentStats['admin_count'] }}</strong>, Approval: <strong>{{ $departmentStats['approval_count'] }}</strong>, Pegawai: <strong>{{ $departmentStats['pegawai_count'] }}</strong></div> </div> </div> </div>

    <div class="alert alert-info">
        <i class="fas fa-info-circle me-1"></i>
        Gunakan "Pindah User" untuk memindahkan seluruh user ke department lain.
    </div>
</div>

<div class="col-lg-8">
    <div class="card shadow">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-users me-2"></i> User pada Department ini</h6>
        </div>
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Gabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td>{{ $u->name }}</td>
                                <td class="font-monospace">{{ $u->nip }}</td>
                                <td>{{ $u->email }}</td>
                                <td><span class="badge {{ $u->role === 'admin' ? 'bg-danger' : ($u->role === 'approval' ? 'bg-warning' : 'bg-success') }}">{{ ucfirst($u->role) }}</span></td>
                                <td>{!! $u->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>' !!}</td>
                                <td>{{ optional($u->created_at)->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-muted">Belum Ada User</h5>
                    <p class="text-muted">Tidak ada user pada department ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>

</div> <!-- Move Users Modal --> <div class="modal fade" id="moveUsersModal" tabindex="-1"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title">Pindah User ke Department Lain</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button> </div> <form id="moveUsersForm" method="POST" action="{{ route('admin.departments.move-users', urlencode($departmentName)) }}"> @csrf <div class="modal-body"> <div class="mb-3"> <label class="form-label">Department Asal</label> <input type="text" class="form-control" value="{{ $departmentName }}" readonly> </div> <div class="mb-3"> <label for="new_department" class="form-label">Department Tujuan</label> <input type="text" name="new_department" id="new_department" class="form-control" placeholder="Masukkan nama department tujuan" required> </div> <div class="alert alert-info"> Semua user pada department asal akan dipindahkan ke department tujuan. </div> </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> <button type="submit" class="btn btn-primary">Pindahkan</button> </div> </form> </div> </div> </div>
@push('styles')

<style> .department-icon { width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%); display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 28px; } .text-gray-300 { color: #dddfeb !important; } </style>
@endpush

@push('scripts')

<script> function openMoveUsers(deptName) { const modal = new bootstrap.Modal(document.getElementById('moveUsersModal')); modal.show(); } </script>
@endpush @endsection
