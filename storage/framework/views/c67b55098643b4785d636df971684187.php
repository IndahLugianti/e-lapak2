<?php $__env->startSection('title', 'Kelola Jenis Layanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-cogs me-2"></i>
        Kelola Jenis Layanan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('admin.service-types.create')); ?>" class="btn btn-sm btn-primary">
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
        <form method="GET" action="<?php echo e(route('admin.service-types.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label for="is_active" class="form-label">Status</label>
                <select name="is_active" id="is_active" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="1" <?php echo e(request('is_active') === '1' ? 'selected' : ''); ?>>Aktif</option>
                    <option value="0" <?php echo e(request('is_active') === '0' ? 'selected' : ''); ?>>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="requires_file" class="form-label">File Pendukung</label>
                <select name="requires_file" id="requires_file" class="form-select">
                    <option value="">Semua</option>
                    <option value="1" <?php echo e(request('requires_file') === '1' ? 'selected' : ''); ?>>Diperlukan</option>
                    <option value="0" <?php echo e(request('requires_file') === '0' ? 'selected' : ''); ?>>Tidak Diperlukan</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="search" class="form-label">Pencarian</label>
                <input type="text" name="search" id="search" class="form-control"
                       placeholder="Cari nama atau deskripsi..." value="<?php echo e(request('search')); ?>">
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
        <span class="badge bg-primary"><?php echo e($serviceTypes->total()); ?> total layanan</span>
    </div>
    <div class="card-body">
        <?php if($serviceTypes->count() > 0): ?>
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
                        <?php $__currentLoopData = $serviceTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="fw-bold"><?php echo e($serviceType->name); ?></div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" title="<?php echo e($serviceType->description); ?>">
                                    <?php echo e(Str::limit($serviceType->description, 80)); ?>

                                </div>
                            </td>
                            <td class="text-center">
                                <?php if($serviceType->requires_file): ?>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-paperclip"></i> Ya
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times"></i> Tidak
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info"><?php echo e($serviceType->estimated_days); ?> hari</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary"><?php echo e($serviceType->tickets_count); ?></span>
                            </td>
                            <td>
                                <?php if($serviceType->is_active): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('admin.service-types.show', $serviceType)); ?>"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="<?php echo e(route('admin.service-types.edit', $serviceType)); ?>"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-info"
                                            onclick="toggleStatus(<?php echo e($serviceType->id); ?>)"
                                            title="<?php echo e($serviceType->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                        <i class="fas fa-<?php echo e($serviceType->is_active ? 'toggle-off' : 'toggle-on'); ?>"></i>
                                    </button>

                                    <?php if($serviceType->tickets_count == 0): ?>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteServiceType(<?php echo e($serviceType->id); ?>)"
                                                title="Hapus">
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
                        Menampilkan <?php echo e($serviceTypes->firstItem()); ?> - <?php echo e($serviceTypes->lastItem()); ?>

                        dari <?php echo e($serviceTypes->total()); ?> layanan
                    </small>
                </div>
                <div>
                    <?php echo e($serviceTypes->links()); ?>

                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-cogs fa-4x text-gray-300 mb-3"></i>
                <h5 class="text-muted">Tidak Ada Jenis Layanan</h5>
                <p class="text-muted">Belum ada jenis layanan yang terdaftar atau tidak ada yang sesuai dengan filter.</p>
                <a href="<?php echo e(route('admin.service-types.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Tambah Jenis Layanan Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
        tokenInput.value = '<?php echo e(csrf_token()); ?>';

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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/admin/service-types/index.blade.php ENDPATH**/ ?>