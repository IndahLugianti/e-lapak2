<?php $__env->startSection('title', 'Detail User - ' . $user->name); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user me-2"></i>
        Detail User: <?php echo e($user->name); ?>

    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i>
                Edit User
            </a>
            <?php if($user->id !== Auth::id()): ?>
                <button type="button" class="btn btn-sm btn-info" onclick="toggleStatus(<?php echo e($user->id); ?>)">
                    <i class="fas fa-<?php echo e($user->is_active ? 'user-slash' : 'user-check'); ?> me-1"></i>
                    <?php echo e($user->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>

                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- User Profile Card -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <div class="user-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    <?php echo e(substr($user->name, 0, 1)); ?>

                </div>
                <h4 class="card-title"><?php echo e($user->name); ?></h4>
                <p class="text-muted"><?php echo e($user->position ?? 'No Position'); ?></p>

                <div class="row text-center mt-3">
                    <div class="col-4">
                        <div class="border-end">
                            <div class="h5 mb-0 text-primary"><?php echo e($ticketStats['created']); ?></div>
                            <small class="text-muted">Tiket</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border-end">
                            <div class="h5 mb-0 text-info"><?php echo e($user->created_at->diffInDays(now())); ?></div>
                            <small class="text-muted">Hari</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="h5 mb-0
                            <?php if($user->role === 'admin'): ?> text-danger
                            <?php elseif($user->role === 'approval'): ?> text-warning
                            <?php else: ?> text-success
                            <?php endif; ?>">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        <small class="text-muted"><?php echo e(ucfirst($user->role)); ?></small>
                    </div>
                </div>

                <div class="mt-3">
                    <?php if($user->is_active): ?>
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check-circle me-1"></i>
                            Aktif
                        </span>
                    <?php else: ?>
                        <span class="badge bg-secondary fs-6">
                            <i class="fas fa-times-circle me-1"></i>
                            Nonaktif
                        </span>
                    <?php endif; ?>
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
                    <div class="fw-bold font-monospace"><?php echo e($user->nip); ?></div>
                </div>

                <div class="mb-3">
                    <label class="small text-muted">Email</label>
                    <div>
                        <a href="mailto:<?php echo e($user->email); ?>" class="text-decoration-none">
                            <?php echo e($user->email); ?>

                        </a>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small text-muted">No. Handphone</label>
                    <div>
                        <?php if($user->no_hp): ?>
                            <a href="tel:<?php echo e($user->no_hp); ?>" class="text-decoration-none font-monospace">
                                <?php echo e($user->no_hp); ?>

                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small text-muted">Department</label>
                    <div class="fw-bold"><?php echo e($user->department); ?></div>
                </div>

                <div class="mb-3">
                    <label class="small text-muted">Bergabung</label>
                    <div><?php echo e($user->created_at->format('d F Y')); ?></div>
                    <small class="text-muted"><?php echo e($user->created_at->diffForHumans()); ?></small>
                </div>

                <div>
                    <label class="small text-muted">Last Update</label>
                    <div><?php echo e($user->updated_at->format('d F Y, H:i')); ?></div>
                    <small class="text-muted"><?php echo e($user->updated_at->diffForHumans()); ?></small>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($ticketStats['created']); ?></div>
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
                                    <?php echo e($user->createdTickets()->where('status', 'completed')->count()); ?>

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
                                    <?php echo e($user->createdTickets()->whereIn('status', ['open', 'in_progress'])->count()); ?>

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
                <?php if($user->createdTickets->count() > 0): ?>
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
                                <?php $__currentLoopData = $user->createdTickets()->latest()->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <span class="font-monospace"><?php echo e($ticket->ticket_number); ?></span>
                                    </td>
                                    <td><?php echo e(Str::limit($ticket->title, 30)); ?></td>
                                    <td>
                                        <span class="badge <?php echo e($ticket->getStatusBadgeClass()); ?>">
                                            <?php echo e($ticket->getStatusText()); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($ticket->created_at->format('d/m/Y')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('tickets.show', $ticket)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mt-3">
                        <a href="<?php echo e(route('tickets.index')); ?>?created_by=<?php echo e($user->id); ?>" class="btn btn-primary">
                            <i class="fas fa-eye me-1"></i>
                            Lihat Semua Tiket User Ini
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-muted">Belum Ada Tiket</h5>
                        <p class="text-muted">User ini belum pernah membuat tiket.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
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
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/admin/users/show.blade.php ENDPATH**/ ?>