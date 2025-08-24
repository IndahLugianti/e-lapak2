@extends('layouts.app')

@section('title', 'Dashboard Approval')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-check-circle me-2"></i>
        Dashboard Approval
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-list me-1"></i>
                Review Tiket
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Perlu Review
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $needReviewTickets }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Approved Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $approvedToday }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Tiket
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTickets }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: var(--primary-color);">
                            Avg Response Time
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $avgResponseTime }}h</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tickets Need Review -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-clock me-2"></i>
                    Tiket Perlu Review
                </h6>
                @if($reviewTickets->count() > 0)
                    <small class="text-white-50">{{ $reviewTickets->count() }} tiket menunggu</small>
                @endif
            </div>
            <div class="card-body">
                @if($reviewTickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nomor Tiket</th>
                                    <th>Judul</th>
                                    <th>Pemohon</th>
                                    <th>Layanan</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviewTickets as $ticket)
                                <tr>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-decoration-none fw-bold">
                                            {{ $ticket->ticket_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($ticket->title, 30) }}</div>
                                        <small class="text-muted">{{ Str::limit($ticket->description, 50) }}</small>
                                    </td>
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
                                    <td>
                                        <span class="badge bg-secondary">{{ $ticket->serviceType->name }}</span>
                                        @if($ticket->hasFile())
                                            <br><small class="text-info">
                                                <i class="fas fa-paperclip"></i> Ada File
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small">{{ $ticket->created_at->format('d/m/Y') }}</div>
                                        {{-- <small class="text-muted">{{ $ticket->created_at->diffForHumans() }}</small> --}}
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('tickets.show', $ticket) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Review Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-success"
                                                    onclick="approveTicket('{{ $ticket->ticket_number }}', 'approve')"
                                                    title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="approveTicket('{{ $ticket->ticket_number }}', 'reject')"
                                                    title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                            <i class="fas fa-eye me-1"></i>
                            Lihat Semua Tiket
                        </a>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h5 class="text-muted">Tidak Ada Tiket Perlu Review</h5>
                        <p class="text-muted">Semua tiket sudah diproses atau belum ada tiket baru yang perlu direview.</p>
                        <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                            <i class="fas fa-list me-1"></i>
                            Lihat Semua Tiket
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                        <i class="fas fa-list me-2"></i>
                        Review Tiket
                    </a>

                    <button class="btn btn-outline-success" onclick="showQuickStatsModal()">
                        <i class="fas fa-chart-line me-2"></i>
                        Quick Stats
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-history me-2"></i>
                    Aktivitas Terakhir
                </h6>
            </div>
            <div class="card-body">
                @if($recentActivity->count() > 0)
                    @foreach($recentActivity as $ticket)
                        <div class="d-flex align-items-center mb-3">
                            <div class="user-avatar me-3">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small fw-bold">{{ $ticket->ticket_number }}</div>
                                <div class="text-muted small">
                                    Status: <span class="badge {{ $ticket->getStatusBadgeClass() }}">{{ $ticket->getStatusText() }}</span>
                                </div>
                                <div class="text-muted small">{{ $ticket->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @if(!$loop->last)<hr class="my-2">@endif
                    @endforeach
                @else
                    <p class="text-muted small text-center py-3">Belum ada aktivitas terbaru.</p>
                @endif
            </div>
        </div>

        <!-- Profile Info -->
        <div class="card shadow">
            <div class="card-header py-3" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-user me-2"></i>
                    Informasi Profil
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="user-avatar mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                    <small class="text-muted">{{ Auth::user()->nip }}</small>
                </div>

                <div class="small">
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Department:</div>
                        <div class="col-7">{{ Auth::user()->department }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Position:</div>
                        <div class="col-7">{{ Auth::user()->position ?? 'Approval Manager' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Role:</div>
                        <div class="col-7">
                            <span class="badge bg-warning">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 text-muted">Last Login:</div>
                        <div class="col-7">{{ now()->format('d/m/Y H:i') }}</div>
                    </div>
                </div>

                <hr>

                <div class="text-center">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1"></i>
                        Approval Access Level
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approvalModalLabel">Konfirmasi Approval</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="approvalForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="approval_notes" class="form-label">Catatan Approval</label>
                        <textarea class="form-control" id="approval_notes" name="approval_notes" rows="3"
                                  placeholder="Berikan catatan mengenai keputusan approval..."></textarea>
                    </div>
                    <input type="hidden" name="action" id="approval_action">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" id="approval_button">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Quick Stats Modal -->
<div class="modal fade" id="quickStatsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-chart-line me-2"></i>
                    Quick Statistics
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @php
                    $weeklyStats = [
                        'this_week' => \App\Models\Ticket::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                        'last_week' => \App\Models\Ticket::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count(),
                        'approved_this_week' => \App\Models\Ticket::where('status', 'selesai')->whereBetween('completed_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                        'pending_review' => \App\Models\Ticket::where('status', 'proses')->count(),
                    ];
                @endphp

                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="h3" style="color: var(--primary-color);">{{ $weeklyStats['this_week'] }}</div>
                        <small class="text-muted">Tiket Minggu Ini</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="h3 text-secondary">{{ $weeklyStats['last_week'] }}</div>
                        <small class="text-muted">Tiket Minggu Lalu</small>
                    </div>
                    <div class="col-6">
                        <div class="h3 text-success">{{ $weeklyStats['approved_this_week'] }}</div>
                        <small class="text-muted">Approved Minggu Ini</small>
                    </div>
                    <div class="col-6">
                        <div class="h3 text-warning">{{ $weeklyStats['pending_review'] }}</div>
                        <small class="text-muted">Pending Review</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.border-left-primary { border-left: 0.25rem solid #2E7D32 !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.text-gray-800 { color: #5a5c69 !important; }
.text-gray-300 { color: #dddfeb !important; }
.user-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 600; font-size: 0.8rem;
}
.table-hover tbody tr:hover { background-color: rgba(0,0,0,.02); }

/* Card headers dengan background primary */
.card-header h6[style*="--primary-color"] {
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

/* Kontras yang baik untuk teks primary */
.card-body [style*="--primary-color"] {
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
function approveTicket(ticketNumber, action) {
    const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
    const form = document.getElementById('approvalForm');
    const button = document.getElementById('approval_button');
    const actionInput = document.getElementById('approval_action');
    const modalTitle = document.getElementById('approvalModalLabel');

    form.action = `/tickets/${ticketNumber}/approve`;
    actionInput.value = action;

    if (action === 'approve') {
        modalTitle.textContent = 'Setujui Tiket';
        button.className = 'btn btn-success';
        button.innerHTML = '<i class="fas fa-check me-1"></i> Setujui';
    } else {
        modalTitle.textContent = 'Tolak Tiket';
        button.className = 'btn btn-danger';
        button.innerHTML = '<i class="fas fa-times me-1"></i> Tolak';
    }

    modal.show();
}

function showGuideModal() {
    const modal = new bootstrap.Modal(document.getElementById('guideModal'));
    modal.show();
}

function showQuickStatsModal() {
    const modal = new bootstrap.Modal(document.getElementById('quickStatsModal'));
    modal.show();
}

// Auto-refresh every 30 seconds for pending tickets
setInterval(function() {
    const needReview = {{ $needReviewTickets }};
    if (needReview > 0) {
        document.title = `(${needReview}) Dashboard Approval - E-Ticketing`;
    }
}, 30000);
</script>
@endpush
@endsection
