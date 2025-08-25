<?php $__env->startSection('title', 'Detail Department - ' . $departmentName); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"> <h1 class="h2"> <i class="fas fa-building me-2"></i> Detail Department: <?php echo e($departmentName); ?> </h1> <div class="btn-toolbar"> <div class="btn-group"> <a href="<?php echo e(route('admin.departments.index')); ?>" class="btn btn-sm btn-outline-secondary"> <i class="fas fa-arrow-left me-1"></i> Kembali </a> <a href="<?php echo e(route('admin.departments.edit', urlencode($departmentName))); ?>" class="btn btn-sm btn-warning"> <i class="fas fa-edit me-1"></i> Edit </a> <button type="button" class="btn btn-sm btn-info" onclick="openMoveUsers('<?php echo e($departmentName); ?>')"> <i class="fas fa-exchange-alt me-1"></i> Pindah User </button> </div> </div> </div> <div class="row"> <div class="col-lg-4"> <div class="card shadow mb-4"> <div class="card-body text-center"> <div class="department-icon mx-auto mb-3" style="width:70px;height:70px;"> <i class="fas fa-building"></i> </div> <h4 class="card-title"><?php echo e($departmentName); ?></h4> <div class="mt-3"> <span class="badge bg-primary fs-6"><?php echo e($departmentStats['total_users']); ?> User</span> </div> <div class="mt-3 small"> <div>Aktif: <strong><?php echo e($departmentStats['active_users']); ?></strong></div> <div>Tiket: <strong><?php echo e($departmentStats['total_tickets']); ?></strong></div> <div>Admin: <strong><?php echo e($departmentStats['admin_count']); ?></strong>, Approval: <strong><?php echo e($departmentStats['approval_count']); ?></strong>, Pegawai: <strong><?php echo e($departmentStats['pegawai_count']); ?></strong></div> </div> </div> </div>

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
            <?php if($users->count() > 0): ?>
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
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($u->name); ?></td>
                                <td class="font-monospace"><?php echo e($u->nip); ?></td>
                                <td><?php echo e($u->email); ?></td>
                                <td><span class="badge <?php echo e($u->role === 'admin' ? 'bg-danger' : ($u->role === 'approval' ? 'bg-warning' : 'bg-success')); ?>"><?php echo e(ucfirst($u->role)); ?></span></td>
                                <td><?php echo $u->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>'; ?></td>
                                <td><?php echo e(optional($u->created_at)->format('d/m/Y')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-muted">Belum Ada User</h5>
                    <p class="text-muted">Tidak ada user pada department ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</div> <!-- Move Users Modal --> <div class="modal fade" id="moveUsersModal" tabindex="-1"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title">Pindah User ke Department Lain</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button> </div> <form id="moveUsersForm" method="POST" action="<?php echo e(route('admin.departments.move-users', urlencode($departmentName))); ?>"> <?php echo csrf_field(); ?> <div class="modal-body"> <div class="mb-3"> <label class="form-label">Department Asal</label> <input type="text" class="form-control" value="<?php echo e($departmentName); ?>" readonly> </div> <div class="mb-3"> <label for="new_department" class="form-label">Department Tujuan</label> <input type="text" name="new_department" id="new_department" class="form-control" placeholder="Masukkan nama department tujuan" required> </div> <div class="alert alert-info"> Semua user pada department asal akan dipindahkan ke department tujuan. </div> </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> <button type="submit" class="btn btn-primary">Pindahkan</button> </div> </form> </div> </div> </div>
<?php $__env->startPush('styles'); ?>

<style> .department-icon { width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%); display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 28px; } .text-gray-300 { color: #dddfeb !important; } </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

<script> function openMoveUsers(deptName) { const modal = new bootstrap.Modal(document.getElementById('moveUsersModal')); modal.show(); } </script>
<?php $__env->stopPush(); ?> <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/admin/departments/show.blade.php ENDPATH**/ ?>