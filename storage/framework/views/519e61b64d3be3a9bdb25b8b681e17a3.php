<?php $__env->startSection('title', 'Edit Tiket'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2"></i>
        Edit Tiket #<?php echo e($ticket->ticket_number); ?>

    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('tickets.show', $ticket)); ?>" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali ke Detail Tiket
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Form Edit Tiket
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('tickets.update', $ticket)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <!-- Service Type Selection -->
                    <div class="mb-4">
                        <label for="service_type_id" class="form-label">
                            <i class="fas fa-cogs me-1"></i>
                            Jenis Layanan <span class="text-danger">*</span>
                        </label>
                        <select class="form-select <?php $__errorArgs = ['service_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="service_type_id"
                                name="service_type_id"
                                required>
                            <option value="">Pilih Jenis Layanan</option>
                            <?php $__currentLoopData = $serviceTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($serviceType->id); ?>"
                                        <?php echo e($ticket->service_type_id == $serviceType->id ? 'selected' : ''); ?>

                                        data-requires-file="<?php echo e($serviceType->requires_file ? 'true' : 'false'); ?>"
                                        data-file-requirements="<?php echo e($serviceType->file_requirements); ?>"
                                        data-estimated-days="<?php echo e($serviceType->estimated_days); ?>"
                                        data-description="<?php echo e($serviceType->description); ?>">
                                    <?php echo e($serviceType->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['service_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Service Description (Auto-filled) -->
                    <div class="mb-4" id="service-description" style="display: none;">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Deskripsi Layanan:</strong>
                            <p class="mb-0" id="service-description-text"></p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Estimasi waktu penyelesaian: <span id="service-estimated-days"></span> hari kerja
                            </small>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label">
                            <i class="fas fa-heading me-1"></i>
                            Judul Permohonan <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="title"
                               name="title"
                               value="<?php echo e(old('title', $ticket->title)); ?>"
                               required
                               maxlength="255"
                               placeholder="Masukkan judul singkat dan jelas">
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i>
                            Deskripsi Permohonan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="description"
                                  name="description"
                                  rows="5"
                                  required
                                  maxlength="1000"
                                  placeholder="Jelaskan secara detail apa yang Anda butuhkan..."><?php echo e(old('description', $ticket->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">Maksimal 1000 karakter</div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="mb-4" id="file-upload-section" style="display: none;">
                        <label for="file_pendukung" class="form-label">
                            <i class="fas fa-paperclip me-1"></i>
                            File Pendukung <span class="text-danger" id="file-required-indicator">*</span>
                        </label>
                        
                        <!-- Current file info -->
                        <?php if($ticket->hasFile()): ?>
                            <div class="alert alert-info mb-2">
                                <i class="fas fa-file me-1"></i>
                                <strong>File saat ini:</strong> 
                                <a href="<?php echo e(route('tickets.download', $ticket)); ?>" target="_blank" class="text-decoration-none">
                                    <?php echo e(basename($ticket->file_pendukung)); ?>

                                </a>
                                <small class="d-block text-muted mt-1">Upload file baru untuk mengganti file yang ada</small>
                            </div>
                        <?php endif; ?>

                        <input type="file"
                               class="form-control <?php $__errorArgs = ['file_pendukung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="file_pendukung"
                               name="file_pendukung"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <?php $__errorArgs = ['file_pendukung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">
                            <div id="file-requirements-text">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG. Maksimal 5MB.</div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-1"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a href="<?php echo e(route('tickets.show', $ticket)); ?>" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times me-1"></i>
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceTypeSelect = document.getElementById('service_type_id');
    const serviceDescription = document.getElementById('service-description');
    const serviceDescriptionText = document.getElementById('service-description-text');
    const serviceEstimatedDays = document.getElementById('service-estimated-days');
    const fileUploadSection = document.getElementById('file-upload-section');
    const fileInput = document.getElementById('file_pendukung');
    const fileRequiredIndicator = document.getElementById('file-required-indicator');
    const fileRequirementsText = document.getElementById('file-requirements-text');

    function updateServiceInfo() {
        const selectedOption = serviceTypeSelect.options[serviceTypeSelect.selectedIndex];
        
        if (selectedOption.value) {
            const requiresFile = selectedOption.dataset.requiresFile === 'true';
            const description = selectedOption.dataset.description;
            const estimatedDays = selectedOption.dataset.estimatedDays;
            const fileRequirements = selectedOption.dataset.fileRequirements;

            // Show service description
            serviceDescriptionText.textContent = description;
            serviceEstimatedDays.textContent = estimatedDays;
            serviceDescription.style.display = 'block';

            // Handle file upload requirements
            if (requiresFile) {
                fileUploadSection.style.display = 'block';
                fileInput.required = true;
                fileRequiredIndicator.style.display = 'inline';
                if (fileRequirements) {
                    fileRequirementsText.innerHTML = fileRequirements + '<br>Maksimal 5MB.';
                }
            } else {
                fileUploadSection.style.display = 'none';
                fileInput.required = false;
                fileRequiredIndicator.style.display = 'none';
            }
        } else {
            serviceDescription.style.display = 'none';
            fileUploadSection.style.display = 'none';
            fileInput.required = false;
        }
    }

    serviceTypeSelect.addEventListener('change', updateServiceInfo);
    
    // Initialize on page load
    updateServiceInfo();
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/tickets/edit.blade.php ENDPATH**/ ?>