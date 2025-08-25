<?php $__env->startSection('title', 'Edit Jenis Layanan - ' . $serviceType->name); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2"></i>
        Edit Jenis Layanan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('admin.service-types.index')); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali ke Daftar
            </a>
            <a href="<?php echo e(route('admin.service-types.show', $serviceType)); ?>" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-eye me-1"></i>
                Lihat Detail
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cog me-2"></i>
                    Form Edit Jenis Layanan: <?php echo e($serviceType->name); ?>

                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.service-types.update', $serviceType)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag me-1"></i>
                            Nama Jenis Layanan <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="name"
                               name="name"
                               value="<?php echo e(old('name', $serviceType->name)); ?>"
                               placeholder="Contoh: Perbaikan Hardware, Instalasi Software"
                               required>
                        <?php $__errorArgs = ['name'];
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

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i>
                            Deskripsi <span class="text-danger">*</span>
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
                                  rows="4"
                                  placeholder="Jelaskan detail layanan ini..."
                                  required><?php echo e(old('description', $serviceType->description)); ?></textarea>
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
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="estimated_days" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Estimasi Hari <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control <?php $__errorArgs = ['estimated_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="estimated_days"
                                   name="estimated_days"
                                   value="<?php echo e(old('estimated_days', $serviceType->estimated_days)); ?>"
                                   min="1"
                                   max="30"
                                   required>
                            <?php $__errorArgs = ['estimated_days'];
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

                        <div class="col-md-4 mb-3">
                            <label for="requires_file" class="form-label">
                                <i class="fas fa-paperclip me-1"></i>
                                Perlu File Pendukung <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?php $__errorArgs = ['requires_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="requires_file"
                                    name="requires_file"
                                    required>
                                <option value="">Pilih</option>
                                <option value="1" <?php echo e(old('requires_file', $serviceType->requires_file) == '1' ? 'selected' : ''); ?>>Ya, Diperlukan</option>
                                <option value="0" <?php echo e(old('requires_file', $serviceType->requires_file) == '0' ? 'selected' : ''); ?>>Tidak Diperlukan</option>
                            </select>
                            <?php $__errorArgs = ['requires_file'];
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

                        <div class="col-md-4 mb-3">
                            <label for="is_active" class="form-label">
                                <i class="fas fa-toggle-on me-1"></i>
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="is_active"
                                    name="is_active"
                                    required>
                                <option value="">Pilih Status</option>
                                <option value="1" <?php echo e(old('is_active', $serviceType->is_active) == '1' ? 'selected' : ''); ?>>Aktif</option>
                                <option value="0" <?php echo e(old('is_active', $serviceType->is_active) == '0' ? 'selected' : ''); ?>>Nonaktif</option>
                            </select>
                            <?php $__errorArgs = ['is_active'];
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
                    </div>

                    <div class="mb-4" id="fileRequirementsSection" style="<?php echo e($serviceType->requires_file ? 'display: block;' : 'display: none;'); ?>">
                        <label for="file_requirements" class="form-label">
                            <i class="fas fa-list-ul me-1"></i>
                            Keterangan File yang Diperlukan
                        </label>
                        <textarea class="form-control <?php $__errorArgs = ['file_requirements'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="file_requirements"
                                  name="file_requirements"
                                  rows="3"
                                  placeholder="Contoh: Scan KTP, Surat Permohonan dari Atasan, Form Persetujuan"><?php echo e(old('file_requirements', $serviceType->file_requirements)); ?></textarea>
                        <?php $__errorArgs = ['file_requirements'];
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

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.service-types.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Update Jenis Layanan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Service Type Info -->
        <div class="card mt-4 border-warning">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Jenis Layanan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Statistik:</h6>
                        <ul class="small">
                            <li><strong>Total Tiket:</strong> <?php echo e($serviceType->tickets()->count()); ?></li>
                            <li><strong>Dibuat:</strong> <?php echo e($serviceType->created_at->format('d F Y')); ?></li>
                            <li><strong>Last Update:</strong> <?php echo e($serviceType->updated_at->diffForHumans()); ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">Peringatan:</h6>
                        <ul class="small">
                            <li>Jenis layanan nonaktif tidak akan muncul di form pengajuan</li>
                            <li>Mengubah requirement file akan mempengaruhi validasi tiket baru</li>
                            <li>Estimasi hari akan ditampilkan ke user sebagai panduan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const requiresFileSelect = document.getElementById('requires_file');
    const fileRequirementsSection = document.getElementById('fileRequirementsSection');
    const fileRequirementsTextarea = document.getElementById('file_requirements');

    function toggleFileRequirements() {
        if (requiresFileSelect.value === '1') {
            fileRequirementsSection.style.display = 'block';
            fileRequirementsTextarea.required = true;
        } else {
            fileRequirementsSection.style.display = 'none';
            fileRequirementsTextarea.required = false;
        }
    }

    requiresFileSelect.addEventListener('change', toggleFileRequirements);

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiresFile = requiresFileSelect.value;
        const fileRequirements = fileRequirementsTextarea.value.trim();

        if (requiresFile === '1' && !fileRequirements) {
            e.preventDefault();
            alert('Keterangan file yang diperlukan wajib diisi jika memerlukan file pendukung');
            fileRequirementsTextarea.focus();
            return false;
        }

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengupdate...';
            submitBtn.disabled = true;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/admin/service-types/edit.blade.php ENDPATH**/ ?>