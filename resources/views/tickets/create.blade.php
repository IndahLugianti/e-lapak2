@extends('layouts.app')

@section('title', 'Buat Tiket Baru')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus-circle me-2"></i>
        Buat Tiket Baru
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali ke Daftar Tiket
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
                    Form Pembuatan Tiket Layanan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Service Type Selection -->
                    <div class="mb-4">
                        <label for="service_type_id" class="form-label">
                            <i class="fas fa-cogs me-1"></i>
                            Jenis Layanan <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('service_type_id') is-invalid @enderror"
                                id="service_type_id"
                                name="service_type_id"
                                required>
                            <option value="">Pilih Jenis Layanan</option>
                            @foreach($serviceTypes as $serviceType)
                                <option value="{{ $serviceType->id }}"
                                        data-requires-file="{{ $serviceType->requires_file ? 'true' : 'false' }}"
                                        data-file-requirements="{{ $serviceType->file_requirements }}"
                                        data-estimated-days="{{ $serviceType->estimated_days }}"
                                        data-description="{{ $serviceType->description }}"
                                        {{ old('service_type_id') == $serviceType->id ? 'selected' : '' }}>
                                    {{ $serviceType->name }}
                                    @if($serviceType->requires_file)
                                        <span class="text-danger">*</span>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('service_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            <i class="fas fa-heading me-1"></i>
                            Judul Tiket <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               placeholder="Masukkan judul yang jelas dan ringkas"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i>
                            Deskripsi Detail <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="5"
                                  placeholder="Jelaskan kebutuhan atau masalah Anda secara detail..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <div class="row">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4 text-end">
                                    <small id="charCounter" class="text-muted">0 karakter</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-4" id="fileUploadSection">
                        <label for="file_pendukung" class="form-label">
                            <i class="fas fa-paperclip me-1"></i>
                            File Pendukung <span id="fileRequired" class="text-danger" style="display: none;">*</span>
                        </label>
                        <input type="file"
                               class="form-control @error('file_pendukung') is-invalid @enderror"
                               id="file_pendukung"
                               name="file_pendukung"
                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        @error('file_pendukung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="form-text">
                            <div class="row">
                                <div class="col-md-8">
                                    <strong>Format yang diizinkan:</strong> PDF, JPG, PNG, DOC, DOCX<br>
                                    <strong>Ukuran maksimal:</strong> 5MB
                                </div>
                                <div class="col-md-4">
                                    <div id="fileRequirements" class="small text-info" style="display: none;">
                                        <strong>File yang diperlukan:</strong><br>
                                        <span id="fileRequirementsText"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- File Preview -->
                        <div id="filePreview" class="mt-2" style="display: none;">
                            <div class="alert alert-info">
                                <i class="fas fa-file me-2"></i>
                                <strong>File terpilih:</strong> <span id="fileName"></span>
                                <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeFile()">
                                    <i class="fas fa-times"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Creator Info (Read Only) -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-user me-1"></i>
                                Dibuat Oleh
                            </label>
                            <div class="form-control-plaintext border rounded p-2 bg-light">
                                <strong>{{ Auth::user()->name }}</strong><br>
                                <small class="text-muted">NIP: {{ Auth::user()->nip }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-building me-1"></i>
                                Unit Kerja
                            </label>
                            <div class="form-control-plaintext border rounded p-2 bg-light">
                                {{ Auth::user()->department }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-calendar me-1"></i>
                                Tanggal Pengajuan
                            </label>
                            <div class="form-control-plaintext border rounded p-2 bg-light">
                                {{ now()->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tickets.create') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-paper-plane me-1"></i>
                            Ajukan Tiket
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Service Types Info Card -->
        <div class="card mt-4 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Panduan Pengajuan Tiket
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Tips Pengajuan yang Baik:
                        </h6>
                        <ul class="small">
                            <li>Pilih jenis layanan yang sesuai dengan kebutuhan</li>
                            <li>Berikan judul yang spesifik dan jelas</li>
                            <li>Jelaskan detail kebutuhan atau masalah</li>
                            <li>Lampirkan file pendukung jika diperlukan</li>

                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">
                            <i class="fas fa-clock me-1"></i>
                            Status Tiket:
                        </h6>
                        <ul class="small">
                            <li><span class="badge bg-warning">Pengajuan</span> - Tiket baru diajukan</li>
                            <li><span class="badge bg-info">Proses</span> - Tiket Sedang dikerjakan</li>
                            <li><span class="badge bg-success">Selesai</span> - Tiket telah diselesaikan</li>
                        </ul>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Pastikan informasi kontak dapat dihubungi
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceTypeSelect = document.getElementById('service_type_id');
    const fileInput = document.getElementById('file_pendukung');
    const fileUploadSection = document.getElementById('fileUploadSection');
    const fileRequired = document.getElementById('fileRequired');
    const fileRequirements = document.getElementById('fileRequirements');
    const fileRequirementsText = document.getElementById('fileRequirementsText');
    const serviceDescription = document.getElementById('serviceDescription');
    const serviceDescText = document.getElementById('serviceDescText');
    const estimatedDays = document.getElementById('estimatedDays');
    const fileRequirementInfo = document.getElementById('fileRequirementInfo');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const descTextarea = document.getElementById('description');
    const charCounter = document.getElementById('charCounter');

    // Service type change handler
    serviceTypeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (this.value) {
            const requiresFile = selectedOption.dataset.requiresFile === 'true';
            const fileReqs = selectedOption.dataset.fileRequirements;
            const description = selectedOption.dataset.description;
            const days = selectedOption.dataset.estimatedDays;

            // Show service description
            serviceDescription.style.display = 'block';
            serviceDescText.textContent = description;
            estimatedDays.textContent = days;

            // Handle file requirements
            if (requiresFile) {
                fileRequired.style.display = 'inline';
                fileRequirements.style.display = 'block';
                fileRequirementsText.textContent = fileReqs;
                fileRequirementInfo.style.display = 'block';
                fileInput.required = true;
            } else {
                fileRequired.style.display = 'none';
                fileRequirements.style.display = 'none';
                fileRequirementInfo.style.display = 'none';
                fileInput.required = false;
            }
        } else {
            serviceDescription.style.display = 'none';
            fileRequired.style.display = 'none';
            fileRequirements.style.display = 'none';
            fileRequirementInfo.style.display = 'none';
            fileInput.required = false;
        }
    });

        // File input change handler
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const fileSize = file.size / 1024 / 1024; // Convert to MB

            // Check file size (5MB limit)
            if (fileSize > 5) {
                alert('Ukuran file terlalu besar! Maksimal 5MB.');
                this.value = '';
                filePreview.style.display = 'none';
                return;
            }

            // Show file preview
            fileName.textContent = file.name + ' (' + fileSize.toFixed(2) + ' MB)';
            filePreview.style.display = 'block';
        } else {
            filePreview.style.display = 'none';
        }
    });

    // Character counter for description
    function updateCharCounter() {
        const length = descTextarea.value.length;
        charCounter.textContent = `${length} karakter`;

        if (length < 10) {
            charCounter.className = 'text-danger';
        } else if (length > 500) {
            charCounter.className = 'text-warning';
        } else {
            charCounter.className = 'text-success';
        }
    }

    descTextarea.addEventListener('input', updateCharCounter);
    updateCharCounter(); // Initial count

    // Auto-resize textarea
    descTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });

    // Form validation
    const form = document.getElementById('ticketForm');
    form.addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const description = descTextarea.value.trim();
        const serviceType = serviceTypeSelect.value;
        const selectedOption = serviceTypeSelect.options[serviceTypeSelect.selectedIndex];
        const requiresFile = selectedOption.dataset.requiresFile === 'true';

        // Basic validation
        if (!serviceType) {
            e.preventDefault();
            alert('Silakan pilih jenis layanan terlebih dahulu.');
            serviceTypeSelect.focus();
            return false;
        }

        if (!title || title.length < 5) {
            e.preventDefault();
            alert('Judul tiket minimal 5 karakter.');
            document.getElementById('title').focus();
            return false;
        }

        if (!description || description.length < 10) {
            e.preventDefault();
            alert('Deskripsi minimal 10 karakter.');
            descTextarea.focus();
            return false;
        }

        // File validation for services that require files
        if (requiresFile && !fileInput.files[0]) {
            e.preventDefault();
            alert('Jenis layanan ini memerlukan file pendukung.');
            fileInput.focus();
            return false;
        }

        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengajukan Tiket...';
            submitBtn.disabled = true;
        }
    });

    // Initialize on page load
    if (serviceTypeSelect.value) {
        serviceTypeSelect.dispatchEvent(new Event('change'));
    }
});

// Remove file function
function removeFile() {
    document.getElementById('file_pendukung').value = '';
    document.getElementById('filePreview').style.display = 'none';
}

// Preview file content (for images)
function previewFile(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();

        if (file.type.startsWith('image/')) {
            reader.onload = function(e) {
                // You can add image preview here if needed
                console.log('Image loaded for preview');
            };
            reader.readAsDataURL(file);
        }
    }
}
</script>
@endpush
@endsection
