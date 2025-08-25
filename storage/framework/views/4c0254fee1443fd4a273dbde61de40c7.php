<?php $__env->startSection('title', 'Kelola User'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users me-2"></i>
        Kelola User
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-sm btn-primary">
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
        <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="row g-3">
            <div class="col-md-2">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="">Semua Role</option>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($role); ?>" <?php echo e(request('role') == $role ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($role)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="department" class="form-label">Unit Kerja</label>
                <select name="department" id="department" class="form-select">
                    <option value="">Semua Unit Kerja</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e(is_object($department) ? $department->name : $department); ?>" <?php echo e(request('department') == (is_object($department) ? $department->name : $department) ? 'selected' : ''); ?>>
                            <?php echo e(is_object($department) ? $department->name : $department); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="is_active" class="form-label">Status</label>
                <select name="is_active" id="is_active" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="1" <?php echo e(request('is_active') === '1' ? 'selected' : ''); ?>>Aktif</option>
                    <option value="0" <?php echo e(request('is_active') === '0' ? 'selected' : ''); ?>>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Pencarian</label>
                <input type="text" name="search" id="search" class="form-control"
                       placeholder="Cari nama, NIP, atau email..." value="<?php echo e(request('search')); ?>">
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
        <span class="badge bg-primary"><?php echo e($users->total()); ?> total user</span>
    </div>
    <div class="card-body">
        <?php if($users->count() > 0): ?>
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
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <?php echo e(substr($user->name, 0, 1)); ?>

                                    </div>
                                    <div>
                                        <div class="fw-bold"><?php echo e($user->name); ?></div>
                                        
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="font-monospace"><?php echo e($user->nip); ?></span>
                            </td>
                            <td><?php echo e($user->email); ?></td>
                            <td>
                                <?php if($user->no_hp): ?>
                                    <span class="font-monospace"><?php echo e($user->no_hp); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge
                                    <?php if($user->role === 'admin'): ?> bg-danger
                                    <?php elseif($user->role === 'approval'): ?> bg-warning
                                    <?php else: ?> bg-success
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst($user->role)); ?>

                                </span>
                            </td>
                            <td><?php echo e($user->department); ?></td>
                            <td>
                                <?php if($user->is_active): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="small"><?php echo e($user->created_at->format('d/m/Y')); ?></div>
                                
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('admin.users.show', $user)); ?>"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <?php if($user->id !== Auth::id()): ?>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-info"
                                                onclick="toggleStatus(<?php echo e($user->id); ?>)"
                                                title="<?php echo e($user->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                            <i class="fas fa-<?php echo e($user->is_active ? 'user-slash' : 'user-check'); ?>"></i>
                                        </button>

                                        <button type="button"
                                                class="btn btn-sm btn-outline-secondary"
                                                onclick="resetPassword(<?php echo e($user->id); ?>)"
                                                title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </button>

                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteUser(<?php echo e($user->id); ?>)"
                                                title="Hapus User">
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
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div>
                    <small class="text-muted fw-medium">
                        Menampilkan <?php echo e($users->firstItem()); ?> - <?php echo e($users->lastItem()); ?>

                        dari <?php echo e($users->total()); ?> user
                    </small>
                </div>
                <div class="pagination-wrapper">
                    <?php echo e($users->appends(request()->query())->links('custom.pagination')); ?>

                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-gray-300 mb-3"></i>
                <h5 class="text-muted">Tidak Ada User</h5>
                <p class="text-muted">Belum ada user yang terdaftar atau tidak ada yang sesuai dengan filter.</p>
                <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Tambah User Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
        tokenInput.value = '<?php echo e(csrf_token()); ?>';

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
        tokenInput.value = '<?php echo e(csrf_token()); ?>';

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
        tokenInput.value = '<?php echo e(csrf_token()); ?>';

        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/admin/users/index.blade.php ENDPATH**/ ?>