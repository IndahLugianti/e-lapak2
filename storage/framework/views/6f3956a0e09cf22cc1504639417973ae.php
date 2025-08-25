<?php $__env->startSection('title', 'Tambah Jenis Layanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus-circle me-2"></i>
        Tambah Jenis Layanan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('admin.service-types.index')); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali ke Daftar
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
                    Form Tambah Jenis Layanan
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.service-types.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

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
                               value="<?php echo e(old('name')); ?>"
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
                                  required><?php echo e(old('description')); ?></textarea>
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
                        <div class="form-text">Berikan penjelasan yang jelas tentang layanan ini untuk membantu user memilih</div>
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
                                   value="<?php echo e(old('estimated_days', 3)); ?>"
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
                            <div class="form-text">Estimasi hari kerja untuk menyelesaikan layanan ini</div>
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
                                <option value="1" <?php echo e(old('requires_file') == '1' ? 'selected' : ''); ?>>Ya, Diperlukan</option>
                                <option value="0" <?php echo e(old('requires_file') == '0' ? 'selected' : ''); ?>>Tidak Diperlukan</option>
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
                                <option value="1" <?php echo e(old('is_active') == '1' ? 'selected' : ''); ?>>Aktif</option>
                                <option value="0" <?php echo e(old('is_active') == '0' ? 'selected' : ''); ?>>Nonaktif</option>
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

                    <div class="mb-4" id="fileRequirementsSection" style="display: none;">
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
                                  placeholder="Contoh: Scan KTP, Surat Permohonan dari Atasan, Form Persetujuan"><?php echo e(old('file_requirements')); ?></textarea>
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
                        <div class="form-text">Jelaskan file apa saja yang harus dilampirkan user saat mengajukan layanan ini</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.service-types.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Simpan Jenis Layanan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Guidelines Card -->
        <div class="card mt-4 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Panduan Membuat Jenis Layanan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Tips Nama Layanan:</h6>
                        <ul class="small">
                            <li>Gunakan nama yang jelas dan spesifik</li>
                            <li>Hindari singkatan yang membingungkan</li>
                            <li>Contoh: "Perbaikan Hardware", "Reset Password Email"</li>
                        </ul>

                        <h6 class="text-primary mt-3">Estimasi Hari:</h6>
                        <ul class="small">
                            <li>1 hari: Layanan cepat (reset password, instalasi sederhana)</li>
                            <li>2-3 hari: Layanan normal (perbaikan, setup)</li>
                            <li>7+ hari: Layanan kompleks (pengadaan, training)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">File Pendukung:</h6>
                        <ul class="small">
                            <li>Aktifkan jika layanan memerlukan dokumen</li>
                            <li>Jelaskan file apa saja yang diperlukan</li>
                            <li>Contoh: KTP, Surat Permohonan, Form Persetujuan</li>
                        </ul>

                        <h6 class="text-primary mt-3">Status:</h6>
                        <ul class="small">
                            <li><strong>Aktif:</strong> Tersedia untuk dipilih user</li>
                            <li><strong>Nonaktif:</strong> Tidak tersedia untuk dipilih</li>
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

    // Show/hide file requirements section
    function toggleFileRequirements() {
        if (requiresFileSelect.value === '1') {
            fileRequirementsSection.style.display = 'block';
            fileRequirementsTextarea.required = true;
        } else {
            fileRequirementsSection.style.display = 'none';
            fileRequirementsTextarea.required = false;
            fileRequirementsTextarea.value = '';
        }
    }

    requiresFileSelect.addEventListener('change', toggleFileRequirements);

    // Initialize on page load
    if (requiresFileSelect.value) {
        toggleFileRequirements();
    }

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const description = document.getElementById('description').value.trim();
        const estimatedDays = document.getElementById('estimated_days').value;
        const requiresFile = requiresFileSelect.value;
        const isActive = document.getElementById('is_active').value;

        if (!name || !description || !estimatedDays || requiresFile === '' || isActive === '') {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi (*)');
            return false;
        }

        if (name.length < 3) {
            e.preventDefault();
            alert('Nama jenis layanan minimal 3 karakter');
            document.getElementById('name').focus();
            return false;
        }

        if (description.length < 10) {
            e.preventDefault();
            alert('Deskripsi minimal 10 karakter');
            document.getElementById('description').focus();
            return false;
        }

        if (requiresFile === '1' && !fileRequirementsTextarea.value.trim()) {
            e.preventDefault();
            alert('Keterangan file yang diperlukan wajib diisi jika memerlukan file pendukung');
            fileRequirementsTextarea.focus();
            return false;
        }

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
            submitBtn.disabled = true;
        }
    });

    // Character counter for description
    const descTextarea = document.getElementById('description');
    const charCounter = document.createElement('div');
    charCounter.className = 'form-text text-end';
    charCounter.id = 'charCounter';
    descTextarea.parentNode.appendChild(charCounter);

    function updateCharCounter() {
        const length = descTextarea.value.length;
        charCounter.textContent = `${length}/1000 karakter`;

        if (length < 10) {
            charCounter.className = 'form-text text-end text-danger';
        } else if (length > 800) {
            charCounter.className = 'form-text text-end text-warning';
        } else {
            charCounter.className = 'form-text text-end text-success';
        }
    }

    descTextarea.addEventListener('input', updateCharCounter);
    updateCharCounter(); // Initial count
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/admin/service-types/create.blade.php ENDPATH**/ ?>