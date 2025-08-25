<?php $__env->startSection('title', 'Kelola Unit Kerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-building me-2"></i>
        Kelola Unit Kerja
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('admin.departments.create')); ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Unit Kerja
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
        <form method="GET" action="<?php echo e(route('admin.departments.index')); ?>" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Pencarian</label>
                <input type="text" name="search" id="search" class="form-control"
                       placeholder="Cari nama unit..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-3">
                <label for="is_active" class="form-label">Status</label>
                <select name="is_active" id="is_active" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="1" <?php echo e(request('is_active') === '1' ? 'selected' : ''); ?>>Aktif</option>
                    <option value="0" <?php echo e(request('is_active') === '0' ? 'selected' : ''); ?>>Nonaktif</option>
                </select>
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
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <a href="<?php echo e(route('admin.departments.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-1"></i>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Departments Table -->
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            Daftar Unit Kerja
        </h5>
        <span class="badge bg-primary"><?php echo e($departments->total()); ?> total unit kerja</span>
    </div>
    <div class="card-body">
        <?php if($departments->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Unit Kerja</th>
                            <th class="text-center">Jumlah User</th>
                            <th>Role Distribution</th>
                            <th class="text-center">Total Tiket</th>
                            <th class="text-center">Status</th>
                            <th class="text-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="department-icon me-3">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?php echo e($department->name); ?></div>
                                        <small class="text-muted">
                                            <?php echo e($department->description ?? 'Tidak ada deskripsi'); ?>

                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary fs-6"><?php echo e($department->users_count); ?></span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <?php if($department->admin_count > 0): ?>
                                        <span class="badge bg-danger" title="Admin">Admin: <?php echo e($department->admin_count); ?></span>
                                    <?php endif; ?>
                                    <?php if($department->approval_count > 0): ?>
                                        <span class="badge bg-warning text-dark" title="Approval">Approval: <?php echo e($department->approval_count); ?></span>
                                    <?php endif; ?>
                                    <?php if($department->pegawai_count > 0): ?>
                                        <span class="badge bg-success" title="Pegawai">Pegawai: <?php echo e($department->pegawai_count); ?></span>
                                    <?php endif; ?>
                                    <?php if($department->admin_count + $department->approval_count + $department->pegawai_count === 0): ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info"><?php echo e($department->tickets_count); ?></span>
                            </td>
                            <td class="text-center">
                                <?php if($department->is_active): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-nowrap">
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('admin.departments.show', $department)); ?>"
                                       class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="<?php echo e(route('admin.departments.edit', $department)); ?>"
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-info"
                                            onclick="toggleStatus(<?php echo e($department->id); ?>)"
                                            title="<?php echo e($department->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                        <i class="fas fa-<?php echo e($department->is_active ? 'toggle-off' : 'toggle-on'); ?>"></i>
                                    </button>

                                    <?php if($department->users_count > 0): ?>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-info"
                                                onclick="moveUsers(<?php echo e($department->id); ?>, '<?php echo e($department->name); ?>')"
                                                title="Pindah Seluruh User">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    <?php else: ?>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteDepartment(<?php echo e($department->id); ?>, '<?php echo e($department->name); ?>')"
                                                title="Hapus Department">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Menampilkan <?php echo e($departments->firstItem()); ?> - <?php echo e($departments->lastItem()); ?>

                        dari <?php echo e($departments->total()); ?> department
                    </small>
                </div>
                <div>
                    <?php echo e($departments->links()); ?>

                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-building fa-4x text-gray-300 mb-3"></i>
                <h5 class="text-muted">Tidak Ada Department</h5>
                <p class="text-muted">Belum ada department yang terdaftar atau tidak ada yang sesuai dengan pencarian.</p>
                <a href="<?php echo e(route('admin.departments.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Tambah Unit Kerja Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Move Users Modal -->
<div class="modal fade" id="moveUsersModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pindah User ke Department Lain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="moveUsersForm" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Department Asal</label>
                        <input type="text" id="fromDepartment" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="new_department_id" class="form-label">Department Tujuan</label>
                        <select name="new_department_id" id="new_department_id" class="form-select" required>
                            <option value="">Pilih Department Tujuan</option>
                            <?php $__currentLoopData = \App\Models\Department::where('is_active', true)->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        Semua user pada department asal akan dipindahkan ke department tujuan.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pindahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.department-icon {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%);
    display: inline-flex; align-items: center; justify-content: center;
    color: #fff;
}
.text-gray-300 { color: #dddfeb !important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function refreshPage() { window.location.reload(); }

function moveUsers(deptId, deptName) {
    const modal = new bootstrap.Modal(document.getElementById('moveUsersModal'));
    const form = document.getElementById('moveUsersForm');
    const fromInput = document.getElementById('fromDepartment');
    const selectElement = document.getElementById('new_department_id');

    fromInput.value = deptName;
    form.action = `/admin/departments/${deptId}/move-users`;

    // Remove current department from options
    Array.from(selectElement.options).forEach(option => {
        if (option.value == deptId) {
            option.style.display = 'none';
        } else {
            option.style.display = 'block';
        }
    });

    modal.show();
}

function deleteDepartment(deptId, deptName) {
    if (!confirm(`Hapus department "${deptName}"? Aksi ini tidak dapat dibatalkan.`)) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/departments/${deptId}`;

    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';

    const tokenInput = document.createElement('input');
    tokenInput.type = 'hidden';
    tokenInput.name = '_token';
    tokenInput.value = '<?php echo e(csrf_token()); ?>';

    form.appendChild(methodInput);
    form.appendChild(tokenInput);
    document.body.appendChild(form);
    form.submit();
}

function toggleStatus(deptId) {
    if (confirm('Apakah Anda yakin ingin mengubah status department ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/departments/${deptId}/toggle-status`;

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '<?php echo e(csrf_token()); ?>';

        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/admin/departments/index.blade.php ENDPATH**/ ?>