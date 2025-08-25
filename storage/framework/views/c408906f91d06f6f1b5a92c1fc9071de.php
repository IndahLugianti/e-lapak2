<?php $__env->startSection('title', 'Detail Tiket - ' . $ticket->ticket_number); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-ticket-alt me-2"></i>
        Detail Tiket: <?php echo e($ticket->ticket_number); ?>

    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('tickets.index')); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
            <?php if(Auth::user()->isAdmin()): ?>
                <a href="<?php echo e(route('tickets.edit', $ticket)); ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit me-1"></i>
                    Edit
                </a>
            <?php endif; ?>
            
            
            <?php if(Auth::user()->isAdmin() || Auth::user()->isApproval()): ?>
                <?php if($ticket->status !== 'selesai'): ?>
                    <button type="button" class="btn btn-sm btn-primary" onclick="updateStatus(<?php echo e($ticket->id); ?>)">
                        <i class="fas fa-sync-alt me-1"></i>
                        Update Status
                    </button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-8">
        <!-- Ticket Details -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Tiket
                </h5>
            </div>
            <div class="card-body">
                <!-- Warning Catatan Approval -->
                <?php if($ticket->approval_notes): ?>
                <div class="alert alert-warning mb-3" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Catatan Approval:</strong>
                    <p class="mb-0 mt-1"><?php echo e($ticket->approval_notes); ?></p>
                </div>
                <?php endif; ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nomor Tiket:</strong><br>
                        <span class="text-primary fw-bold"><?php echo e($ticket->ticket_number); ?></span>
                    </div>
                        <div class="col-md-6">
                            <strong>Status:</strong><br>
                            <span class="badge <?php echo e($ticket->getStatusBadgeClass()); ?> fs-6">
                                <?php echo e($ticket->getStatusText()); ?>

                            </span>

                            <span class="badge fs-6">
                            <?php if( $ticket->status === 'pengajuan'): ?>
                                    <button type="button" class="btn btn-sm btn-danger"
                                                
                                                onclick="deleteTicket(<?php echo e($ticket->id); ?>)"
                                                title="Batalkan Tiket">
                                            <i >Batalkan  </i>
                                        </button>

                            <?php endif; ?>
                            </span>
                        </div>

                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Judul:</strong><br>
                        <h5 class="text-dark"><?php echo e($ticket->title); ?></h5>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Jenis Layanan:</strong><br>
                        <span class="badge bg-secondary fs-6"><?php echo e($ticket->serviceType->name); ?></span>
                        <?php if($ticket->serviceType->requires_file): ?>
                            <br><small class="text-info">
                                <i class="fas fa-paperclip"></i> Memerlukan file pendukung
                            </small>
                        <?php endif; ?>
                    </div>
                    
                </div>

                <div class="mb-3">
                    <strong>Deskripsi:</strong>
                    <div class="border rounded p-3 bg-light mt-2">
                        <?php echo nl2br(e($ticket->description)); ?>

                    </div>
                </div>

                <?php if($ticket->hasFile()): ?>
                <div class="mb-3">
                    <strong>File Pendukung:</strong><br>
                    <?php if($ticket->hasFile()): ?>
                        <div class="d-flex align-items-center mt-2">
                            <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                            <div>
                                <div class="fw-bold"><?php echo e($ticket->file_pendukung); ?></div>
                                <div class="btn-group mt-1">
                                    <a href="<?php echo e(route('tickets.download', $ticket)); ?>"
                                        class="btn btn-sm btn-outline-primary"
                                        target="_blank">
                                        <i class="fas fa-eye me-1"></i>
                                        Lihat File
                                    </a>
                                    <a href="<?php echo e(route('tickets.download', $ticket)); ?>?download=true"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-download me-1"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-muted mt-2">
                            <i class="fas fa-file-excel me-2"></i>
                            Tidak ada file pendukung
                        </div>
                    <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if($ticket->admin_notes): ?>
                <div class="mb-3">
                    <strong>Catatan Admin:</strong>
                    <div class="alert alert-info mt-2">
                        <i class="fas fa-sticky-note me-2"></i>
                        <?php echo e($ticket->admin_notes); ?>

                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Timeline -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Timeline Tiket
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <!-- Created -->
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Tiket Dibuat</h6>
                            <p class="timeline-text">
                                Tiket dibuat oleh <strong><?php echo e($ticket->creator->nip); ?> (<?php echo e($ticket->creator->name); ?>)</strong>
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo e($ticket->created_at ? $ticket->created_at->format('d F Y, H:i') : '-'); ?>


                                

                            </small>
                        </div>
                    </div>

                    <!-- Processed -->
                    <?php if($ticket->processed_at): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Tiket Diproses</h6>
                            <p class="timeline-text">
                                Tiket mulai diproses oleh admin
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo e($ticket->processed_at->format('d F Y, H:i')); ?>

                                (<?php echo e($ticket->processed_at->diffForHumans()); ?>)
                            </small>
                        </div>
                    </div>
                    <?php endif; ?>


                    <!-- Completed -->
                    <?php if($ticket->completed_at): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Tiket Selesai</h6>
                            <p class="timeline-text">
                                Tiket telah diselesaikan
                                <?php if($ticket->approval_notes): ?>
                                    dengan catatan: "<?php echo e($ticket->approval_notes); ?>"
                                <?php endif; ?>
                            </p>
                            <?php if($ticket->hasCompletionFile()): ?>
                            <div class="mt-3">
                                <strong>File Penyelesaian:</strong><br>
                                <div class="d-flex align-items-center mt-2">
                                    <i class="fas fa-file-alt fa-lg text-success me-2"></i>
                                    <div>
                                        <div class="fw-bold"><?php echo e($ticket->completion_file); ?></div>
                                        <div class="btn-group mt-1">
                                            <a href="<?php echo e(route('tickets.download-completion', $ticket)); ?>" 
                                               class="btn btn-sm btn-outline-success"
                                               target="_blank">
                                                <i class="fas fa-eye me-1"></i>
                                                Lihat File
                                            </a>
                                            <a href="<?php echo e(route('tickets.download-completion', $ticket)); ?>?download=true" 
                                               class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-download me-1"></i>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo e($ticket->completed_at->format('d F Y, H:i')); ?>

                                (<?php echo e($ticket->completed_at->diffForHumans()); ?>)
                            </small>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Ticket Info -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-user me-2"></i>
                    Informasi Pemohon
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="user-avatar me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                        <?php echo e(substr($ticket->creator->name, 0, 1)); ?>

                    </div>
                    <div>
                        <div class="fw-bold"><?php echo e($ticket->creator->name); ?></div>
                        <div class="text-muted small"><?php echo e($ticket->creator->nip); ?></div>
                        <div class="text-muted small"><?php echo e($ticket->creator->department); ?></div>
                    </div>
                </div>

                <div class="small">
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Position:</div>
                        <div class="col-7"><?php echo e($ticket->creator->position ?? '-'); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Email:</div>
                        <div class="col-7"><?php echo e($ticket->creator->email); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Type Info -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Informasi Layanan
                </h6>
            </div>
            <div class="card-body">
                <h6 class="text-primary"><?php echo e($ticket->serviceType->name); ?></h6>
                <p class="text-muted small"><?php echo e($ticket->serviceType->description); ?></p>

                

                <?php if($ticket->serviceType->requires_file): ?>
                <div class="row small">
                    <div class="col-7 text-muted">File Required:</div>
                    <div class="col-5"><i class="fas fa-check text-success"></i></div>
                </div>
                <?php endif; ?>

                <?php if($ticket->serviceType->file_requirements): ?>
                <div class="mt-2">
                    <small class="text-info">
                        <strong>File yang diperlukan:</strong><br>
                        <?php echo e($ticket->serviceType->file_requirements); ?>

                    </small>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <?php if(Auth::user()->isAdmin()): ?>
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <?php if($ticket->status !== 'selesai'): ?>
                        <button type="button" class="btn btn-primary" onclick="updateStatus(<?php echo e($ticket->id); ?>)">
                            <i class="fas fa-sync-alt me-1"></i>
                            Update Status
                        </button>
                    <?php endif; ?>

                    <a href="<?php echo e(route('tickets.edit', $ticket)); ?>" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>
                        Edit Tiket
                    </a>

                    <button type="button" class="btn btn-danger" onclick="deleteTicket(<?php echo e($ticket->id); ?>)">
                        <i class="fas fa-trash me-1"></i>
                        Hapus Tiket
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Update Status Modal -->
<?php if(Auth::user()->isAdmin() || Auth::user()->isApproval()): ?>
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm" method="POST" enctype="multipart/form-data" onsubmit="console.log('Form submitting to:', this.action, 'with method:', this.method); return true;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="modalStatus" name="status" required onchange="toggleCompletionFileField()">
                            <option value="pengajuan" <?php echo e($ticket->status === 'pengajuan' ? 'selected' : ''); ?>>Pengajuan</option>
                            <option value="proses" <?php echo e($ticket->status === 'proses' ? 'selected' : ''); ?>>Proses</option>
                            <option value="selesai" <?php echo e($ticket->status === 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Catatan Admin</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3"
                                  placeholder="Berikan catatan atau keterangan..."><?php echo e($ticket->approval_notes); ?></textarea>
                    </div>
                    <div class="mb-3" id="completionFileField" style="display: none;">
                        <label for="completion_file" class="form-label">
                            File Penyelesaian <small class="text-muted">(Opsional)</small>
                        </label>
                        <input type="file" class="form-control" id="completion_file" name="completion_file" 
                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                        <div class="form-text">
                            Upload file bukti penyelesaian atau dokumen terkait. Format yang diizinkan: PDF, JPG, PNG, DOC, DOCX, XLS, XLSX. Maksimal 5MB.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitStatusUpdate()">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }

        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: -1.5rem;
            top: 1.5rem;
            bottom: -2rem;
            width: 2px;
            background-color: #dee2e6;
        }

        .timeline-marker {
            position: absolute;
            left: -2rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #dee2e6;
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 3px solid #007bff;
        }

        .timeline-title {
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .timeline-text {
            margin-bottom: 0.5rem;
            color: #6c757d;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function updateStatus(ticketId) {
    console.log('updateStatus called with ticketId:', ticketId);
    const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
    const form = document.getElementById('updateStatusForm');
    const action = `/tickets/${ticketId}/update-status`;
    form.action = action;
    console.log('Form action set to:', action);
    console.log('Form method:', form.method);
    
    // Show/hide completion file field based on current status
    toggleCompletionFileField();
    
    modal.show();
}

function toggleCompletionFileField() {
    const statusSelect = document.getElementById('modalStatus');
    const completionFileField = document.getElementById('completionFileField');
    
    if (statusSelect.value === 'selesai') {
        completionFileField.style.display = 'block';
    } else {
        completionFileField.style.display = 'none';
        // Clear the file input when hidden
        document.getElementById('completion_file').value = '';
    }
}

async function submitStatusUpdate() {
    console.log('submitStatusUpdate called');
    const form = document.getElementById('updateStatusForm');
    const statusSelect = document.getElementById('modalStatus');
    const notesField = document.getElementById('admin_notes');
    const fileField = document.getElementById('completion_file');
    
    console.log('Status:', statusSelect.value);
    console.log('Notes:', notesField.value);
    console.log('File:', fileField.files.length > 0 ? fileField.files[0].name : 'No file');
    console.log('Submitting to:', form.action);
    
    // Prepare form data (FormData automatically handles file uploads)
    const formData = new FormData(form);
    
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        console.log('Response status:', response.status);
        console.log('Response headers:', Object.fromEntries(response.headers.entries()));
        
        // Check if response is a redirect (302)
        if (response.status === 302 || response.redirected) {
            console.log('Redirect detected, following...');
            window.location.href = response.url || window.location.href;
            return;
        }
        
        // Try to parse as JSON
        try {
            const result = await response.json();
            console.log('JSON Response:', result);
            
            if (result.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('updateStatusModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Show success message and redirect
                alert(result.message);
                window.location.href = result.redirect;
            } else {
                alert('Error: ' + result.message);
            }
        } catch (jsonError) {
            console.log('Not JSON response, assuming success and reloading page');
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('updateStatusModal'));
            if (modal) {
                modal.hide();
            }
            // Reload page to see updated status
            window.location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui status');
    }
}

function deleteTicket(ticketId) {
    if (confirm('Apakah Anda yakin ingin membatalkan tiket ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/tickets/${ticketId}/cancel`;

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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/tickets/show.blade.php ENDPATH**/ ?>