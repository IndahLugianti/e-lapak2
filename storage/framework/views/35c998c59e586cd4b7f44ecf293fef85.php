<?php $__env->startSection('title', 'Riwayat Approval'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-history me-2"></i>
        Riwayat Approval
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('approval.riwayat.download')); ?>" class="btn btn-sm btn-success">
                <i class="fas fa-download me-1"></i>
                Download Laporan
            </a>
            <button class="btn btn-sm btn-outline-secondary" onclick="showFilterModal()">
                <i class="fas fa-filter me-1"></i>
                Filter Tanggal
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Disetujui
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e($approvedTickets->where('status', 'selesai')->count()); ?>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Sedang Proses
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e($approvedTickets->where('status', 'proses')->count()); ?>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cogs fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Dikembalikan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e($approvedTickets->where('status', 'pengajuan')->whereNotNull('approval_notes')->count()); ?>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-undo fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Aktivitas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e($approvedTickets->count()); ?>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-table me-2"></i>
            Daftar Riwayat Approval
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nomor Tiket</th>
                        <th>Judul</th>
                        <th>Pemohon</th>
                        <th>Tindakan</th>
                        <th>Disetujui Oleh</th>
                        <th>Catatan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $approvedTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('tickets.show', $ticket)); ?>" class="text-decoration-none fw-bold">
                                <?php echo e($ticket->ticket_number); ?>

                            </a>
                        </td>
                        <td><?php echo e(Str::limit($ticket->title, 30)); ?></td>
                        <td>
                            <div class="fw-bold"><?php echo e($ticket->creator->nip); ?></div>
                            <small class="text-muted"><?php echo e($ticket->creator->name); ?></small>
                        </td>
                        <td>
                            <?php if($ticket->status == 'selesai'): ?>
                                <span class="badge bg-success">Disetujui</span>
                            <?php elseif($ticket->status == 'proses'): ?>
                                <span class="badge bg-info">Diproses</span>
                            <?php elseif($ticket->approval_notes && $ticket->status == 'pengajuan'): ?>
                                <span class="badge bg-warning">Dikembalikan</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($ticket->approvedBy): ?>
                                <div class="fw-bold"><?php echo e($ticket->approvedBy->nip); ?></div>
                                <small class="text-muted"><?php echo e($ticket->approvedBy->name); ?></small>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($ticket->approval_notes): ?>
                                <span class="badge bg-info" title="<?php echo e($ticket->approval_notes); ?>">
                                    <?php echo e(Str::limit($ticket->approval_notes, 20)); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="small">
                                <strong>Dibuat:</strong> <?php echo e($ticket->formatted_created_at); ?><br>
                                <?php if($ticket->approved_at): ?>
                                    <strong>Approved:</strong> <?php echo e($ticket->formatted_approved_at); ?>

                                <?php elseif($ticket->processed_at): ?>
                                    <strong>Diproses:</strong> <?php echo e($ticket->formatted_processed_at); ?>

                                <?php elseif($ticket->completed_at): ?>
                                    <strong>Selesai:</strong> <?php echo e($ticket->formatted_completed_at); ?>

                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php if($approvedTickets->count() == 0): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-gray-300 mb-3"></i>
                <h5 class="text-muted">Belum Ada Riwayat Approval</h5>
                <p class="text-muted">Riwayat approval akan muncul setelah Anda melakukan tindakan approval pada tiket.</p>
            </div>
        <?php endif; ?>
        
        <?php echo e($approvedTickets->links()); ?>

    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Laporan Berdasarkan Tanggal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('approval.riwayat.download')); ?>" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="date_from" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="date_from" name="date_from">
                        </div>
                        <div class="col-md-6">
                            <label for="date_to" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="date_to" name="date_to">
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Kosongkan untuk download semua data riwayat approval
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-download me-1"></i>
                        Download CSV
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.border-left-primary { border-left: 0.25rem solid var(--primary-color) !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
.text-gray-800 { color: #5a5c69 !important; }
.text-gray-300 { color: #dddfeb !important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function showFilterModal() {
    const modal = new bootstrap.Modal(document.getElementById('filterModal'));
    modal.show();
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/approval/riwayat.blade.php ENDPATH**/ ?>