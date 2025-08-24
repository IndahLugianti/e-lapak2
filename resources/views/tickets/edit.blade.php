@extends('layouts.app')

@section('title', 'Edit Tiket')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2"></i>
        Edit Tiket #{{ $ticket->ticket_number }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
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
                <form action="{{ route('tickets.update', $ticket) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

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
                                        {{ $ticket->service_type_id == $serviceType->id ? 'selected' : '' }}
                                        data-requires-file="{{ $serviceType->requires_file ? 'true' : 'false' }}"
                                        data-file-requirements="{{ $serviceType->file_requirements }}"
                                        data-estimated-days="{{ $serviceType->estimated_days }}"
                                        data-description="{{ $serviceType->description }}">
                                    {{ $serviceType->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                               class="form-control @error('title') is-invalid @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title', $ticket->title) }}"
                               required
                               maxlength="255"
                               placeholder="Masukkan judul singkat dan jelas">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i>
                            Deskripsi Permohonan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="5"
                                  required
                                  maxlength="1000"
                                  placeholder="Jelaskan secara detail apa yang Anda butuhkan...">{{ old('description', $ticket->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Maksimal 1000 karakter</div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="mb-4" id="file-upload-section" style="display: none;">
                        <label for="file_pendukung" class="form-label">
                            <i class="fas fa-paperclip me-1"></i>
                            File Pendukung <span class="text-danger" id="file-required-indicator">*</span>
                        </label>
                        
                        <!-- Current file info -->
                        @if($ticket->hasFile())
                            <div class="alert alert-info mb-2">
                                <i class="fas fa-file me-1"></i>
                                <strong>File saat ini:</strong> 
                                <a href="{{ route('tickets.download', $ticket) }}" target="_blank" class="text-decoration-none">
                                    {{ basename($ticket->file_pendukung) }}
                                </a>
                                <small class="d-block text-muted mt-1">Upload file baru untuk mengganti file yang ada</small>
                            </div>
                        @endif

                        <input type="file"
                               class="form-control @error('file_pendukung') is-invalid @enderror"
                               id="file_pendukung"
                               name="file_pendukung"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        @error('file_pendukung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary w-100">
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

@push('scripts')
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
@endpush

@endsection