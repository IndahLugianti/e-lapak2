@extends('layouts.app')

@section('title', 'Daftar Tiket')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-list me-2"></i>

        @if(Auth::user()->isAdmin() || Auth::user()->isApproval())
            Kelola Tiket
        @else
            Tiket Saya
        @endif
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            @if(!Auth::user()->isAdmin())
                <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Buat Tiket Baru
                </a>
            @endif
            <button class="btn btn-sm btn-outline-secondary" onclick="refreshPage()">
                <i class="fas fa-sync-alt me-1"></i>
                Refresh
            </button>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('tickets.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pengajuan" {{ request('status') == 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="service_type" class="form-label">Jenis Layanan</label>
                <select name="service_type" id="service_type" class="form-select">
                    <option value="">Semua Layanan</option>
                    @foreach(\App\Models\ServiceType::active()->get() as $serviceType)
                        <option value="{{ $serviceType->id }}" {{ request('service_type') == $serviceType->id ? 'selected' : '' }}>
                            {{ $serviceType->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="search" class="form-label">Pencarian</label>
                <input type="text" name="search" id="search" class="form-control"
                       placeholder="Cari nomor tiket atau judul..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tickets Table -->
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
              <i class="fas fa-list me-2"></i>
            Daftar Tiket
        </h5>
        <span class="badge bg-primary">{{ $tickets->total() }} total tiket</span>
    </div>
    <div class="card-body">
        @if($tickets->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nomor Tiket</th>
                            <th>Judul</th>
                            <th>Jenis Layanan</th>
                            @if(Auth::user()->isAdmin() || Auth::user()->isApproval())
                                <th>Pemohon</th>
                            @endif
                            <th>Status</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($tickets as $index => $ticket)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-light text-dark">
                                    {{ ($tickets->currentPage() - 1) * $tickets->perPage() + $index + 1 }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-decoration-none fw-bold">
                                    {{ $ticket->ticket_number }}
                                </a>
                            </td>
                            <td>
                                <div class="fw-bold">{{ Str::limit($ticket->title, 40) }}</div>
                                <small class="text-muted">{{ Str::limit($ticket->description, 60) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $ticket->serviceType->name }}
                                </span>
                                @if($ticket->serviceType->requires_file)
                                    <br><small class="text-info">
                                        <i class="fas fa-paperclip"></i> File Required
                                    </small>
                                @endif
                            </td>
                            @if(Auth::user()->isAdmin() || Auth::user()->isApproval())
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2">
                                            {{ substr($ticket->creator->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold small">{{ $ticket->creator->nip }}</div>
                                            <small class="text-muted">{{ $ticket->creator->department }}</small>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            <td>
                                <span class="badge {{ $ticket->getStatusBadgeClass() }}">
                                    {{ $ticket->getStatusText() }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    @if($ticket->hasFile())
                                        @if($ticket->fileExists())
                                            <a href="{{ route('tickets.download', $ticket) }}"
                                            class="btn btn-sm btn-outline-info"
                                            target="_blank"
                                            title="Lihat File Pendukung">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @else
                                            <span class="text-danger small">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif

                                    @if($ticket->hasCompletionFile())
                                        <a href="{{ route('tickets.download-completion', $ticket) }}"
                                        class="btn btn-sm btn-outline-success"
                                        target="_blank"
                                        title="Lihat File Penyelesaian">
                                            <i class="fas fa-file-check"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tickets.show', $ticket) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Tombol Cancel untuk Pegawai -->
                                    @if( $ticket->status === 'pengajuan')
                                        <button type="button"
                                                class="btn btn-sm btn-outline-warning"
                                                onclick="deleteTicket('{{ $ticket->ticket_number }}')"
                                                title="Batalkan Tiket">
                                            <i class="fas fa-times"></i>
                                        </button>


                                    @endif

                                    <!-- Tombol Update Status untuk Admin dan Approval -->
                                    @if(Auth::user()->isAdmin() || Auth::user()->isApproval())
                                        @if($ticket->status !== 'selesai')
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-warning"
                                                    onclick="updateStatus('{{ $ticket->ticket_number }}')"
                                                    title="Update Status">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                    @endif

                                    <!-- Tombol Hapus untuk Admin -->
                                    @if(Auth::user()->isAdmin())
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteTicket('{{ $ticket->ticket_number }}')"
                                                title="Hapus Tiket">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div>
                    <small class="text-muted fw-medium">
                        Menampilkan {{ $tickets->firstItem() }} - {{ $tickets->lastItem() }}
                        dari {{ $tickets->total() }} tiket
                    </small>
                </div>
                <div class="pagination-wrapper">
                    {{ $tickets->appends(request()->query())->links('custom.pagination') }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-gray-300 mb-3"></i>
                <h5 class="text-muted">Tidak Ada Tiket</h5>
                @if(Auth::user()->isAdmin())
                    <p class="text-muted">Belum ada tiket yang diajukan oleh pegawai.</p>
                @else
                    <p class="text-muted">Anda belum mengajukan tiket apapun.</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Buat Tiket Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination-wrapper .pagination {
    margin-bottom: 0;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #065f46 0%, #064e3b 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .pagination-wrapper {
        justify-content: center;
    }
}
</style>
@endpush

        <!-- Update Status Modal (Admin & Approval) -->
        @if(Auth::user()->isAdmin() || Auth::user()->isApproval())
            <div class="modal fade" id="updateStatusModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Status Tiket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form id="updateStatusForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="modalStatus" name="status" required onchange="toggleCompletionFileField()">
                                        <option value="pengajuan">Pengajuan</option>
                                        <option value="proses">Proses</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="admin_notes" class="form-label">Catatan Admin</label>
                                    <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3"
                                              placeholder="Berikan catatan atau keterangan..."></textarea>
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
        @endif

@push('scripts')
    <script>
        function refreshPage() {
            window.location.reload();
        }

        @if(Auth::user()->isAdmin() || Auth::user()->isApproval())
            function updateStatus(ticketNumber) {
                console.log('updateStatus called with ticketNumber:', ticketNumber);
                const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
                const form = document.getElementById('updateStatusForm');
                const action = `/tickets/${ticketNumber}/update-status`;
                form.action = action;
                console.log('Form action set to:', action);

                // Reset form
                document.getElementById('modalStatus').value = '';
                document.getElementById('admin_notes').value = '';
                document.getElementById('completion_file').value = '';

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

                            // Show success message and reload
                            alert(result.message);
                            window.location.reload();
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

            function deleteTicket(ticketNumber) {
                if (confirm('Apakah Anda yakin ingin membatalkan tiket ini?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/tickets/${ticketNumber}/cancel`;

                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = '{{ csrf_token() }}';

                    form.appendChild(tokenInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            }

        @endif

        // Auto refresh every 30 seconds
        setInterval(function() {
            // Optional: Add AJAX refresh for real-time updates
            console.log('Auto refresh check...');
        }, 30000);
    </script>
@endpush

@endsection
