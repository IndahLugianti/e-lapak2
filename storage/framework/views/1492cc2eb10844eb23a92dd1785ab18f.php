<?php $__env->startSection('title', 'Tambah Department'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus me-2"></i>
        Tambah Department
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('admin.departments.index')); ?>" class="btn btn-sm btn-outline-secondary">
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
                    <i class="fas fa-building me-2"></i>
                    Form Tambah Department
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.departments.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag me-1"></i>
                            Nama Department <span class="text-danger">*</span>
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
                               placeholder="Contoh: IT, Finance, HR, Marketing"
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
                        <div class="form-text">Nama department harus unik dan tidak boleh sama dengan yang sudah ada</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i>
                            Deskripsi
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
                                  placeholder="Jelaskan fungsi dan tanggung jawab department ini..."><?php echo e(old('description')); ?></textarea>
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
                        <div class="form-text">Deskripsi singkat tentang department (opsional)</div>
                    </div>

                    <div class="mb-4">
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
                        <div class="form-text">Department aktif akan muncul dalam pilihan saat membuat user baru</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.departments.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Simpan Department
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
                    Panduan Membuat Department
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Tips Nama Department:</h6>
                        <ul class="small">
                            <li>Gunakan nama yang jelas dan mudah dipahami</li>
                            <li>Hindari singkatan yang membingungkan</li>
                            <li>Contoh yang baik: "Information Technology", "Human Resources"</li>
                            <li>Nama harus unik, tidak boleh duplikat</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Status Department:</h6>
                        <ul class="small">
                            <li><strong>Aktif:</strong> Department dapat dipilih saat membuat user baru</li>
                            <li><strong>Nonaktif:</strong> Department tidak muncul dalam pilihan</li>
                            <li>Department nonaktif tidak mempengaruhi user yang sudah ada</li>
                        </ul>
                    </div>
                </div>

                <div class="alert alert-warning mt-3 mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    <strong>Catatan:</strong> Setelah department dibuat, Anda dapat menambahkan user ke department ini melalui menu User Management.
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const isActive = document.getElementById('is_active').value;

        if (!name) {
            e.preventDefault();
            alert('Nama department wajib diisi');
            document.getElementById('name').focus();
            return false;
        }

        if (name.length < 2) {
            e.preventDefault();
            alert('Nama department minimal 2 karakter');
            document.getElementById('name').focus();
            return false;
        }

        if (isActive === '') {
            e.preventDefault();
            alert('Status department wajib dipilih');
            document.getElementById('is_active').focus();
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
        charCounter.textContent = `${length}/500 karakter`;

        if (length > 400) {
            charCounter.className = 'form-text text-end text-warning';
        } else {
            charCounter.className = 'form-text text-end text-muted';
        }
    }

    descTextarea.addEventListener('input', updateCharCounter);
    updateCharCounter(); // Initial count

    // Auto-capitalize first letter of department name
    const nameInput = document.getElementById('name');
    nameInput.addEventListener('input', function() {
        let value = this.value;
        // Capitalize first letter of each word
        this.value = value.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\e-lapak\resources\views/admin/departments/create.blade.php ENDPATH**/ ?>