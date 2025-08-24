@extends('layouts.app')

@section('title', 'Edit Jenis Layanan - ' . $serviceType->name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2"></i>
        Edit Jenis Layanan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.service-types.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali ke Daftar
            </a>
            <a href="{{ route('admin.service-types.show', $serviceType) }}" class="btn btn-sm btn-outline-primary">
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
                    Form Edit Jenis Layanan: {{ $serviceType->name }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.service-types.update', $serviceType) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag me-1"></i>
                            Nama Jenis Layanan <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $serviceType->name) }}"
                               placeholder="Contoh: Perbaikan Hardware, Instalasi Software"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i>
                            Deskripsi <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="4"
                                  placeholder="Jelaskan detail layanan ini..."
                                  required>{{ old('description', $serviceType->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="estimated_days" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Estimasi Hari <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('estimated_days') is-invalid @enderror"
                                   id="estimated_days"
                                   name="estimated_days"
                                   value="{{ old('estimated_days', $serviceType->estimated_days) }}"
                                   min="1"
                                   max="30"
                                   required>
                            @error('estimated_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="requires_file" class="form-label">
                                <i class="fas fa-paperclip me-1"></i>
                                Perlu File Pendukung <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('requires_file') is-invalid @enderror"
                                    id="requires_file"
                                    name="requires_file"
                                    required>
                                <option value="">Pilih</option>
                                <option value="1" {{ old('requires_file', $serviceType->requires_file) == '1' ? 'selected' : '' }}>Ya, Diperlukan</option>
                                <option value="0" {{ old('requires_file', $serviceType->requires_file) == '0' ? 'selected' : '' }}>Tidak Diperlukan</option>
                            </select>
                            @error('requires_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="is_active" class="form-label">
                                <i class="fas fa-toggle-on me-1"></i>
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('is_active') is-invalid @enderror"
                                    id="is_active"
                                    name="is_active"
                                    required>
                                <option value="">Pilih Status</option>
                                <option value="1" {{ old('is_active', $serviceType->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $serviceType->is_active) == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4" id="fileRequirementsSection" style="{{ $serviceType->requires_file ? 'display: block;' : 'display: none;' }}">
                        <label for="file_requirements" class="form-label">
                            <i class="fas fa-list-ul me-1"></i>
                            Keterangan File yang Diperlukan
                        </label>
                        <textarea class="form-control @error('file_requirements') is-invalid @enderror"
                                  id="file_requirements"
                                  name="file_requirements"
                                  rows="3"
                                  placeholder="Contoh: Scan KTP, Surat Permohonan dari Atasan, Form Persetujuan">{{ old('file_requirements', $serviceType->file_requirements) }}</textarea>
                        @error('file_requirements')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.service-types.index') }}" class="btn btn-secondary">
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
                            <li><strong>Total Tiket:</strong> {{ $serviceType->tickets()->count() }}</li>
                            <li><strong>Dibuat:</strong> {{ $serviceType->created_at->format('d F Y') }}</li>
                            <li><strong>Last Update:</strong> {{ $serviceType->updated_at->diffForHumans() }}</li>
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

@push('scripts')
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
@endpush
@endsection
