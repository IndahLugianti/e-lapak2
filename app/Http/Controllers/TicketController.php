<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        // Validate search input
        $request->validate([
            'search' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pengajuan,proses,selesai,dibatalkan',
            'service_type' => 'nullable|numeric|exists:service_types,id',
            'created_by' => 'nullable|numeric|exists:users,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        try {
            $user = Auth::user();

            // Build query based on user role
            $query = Ticket::with(['creator', 'serviceType']);

            if (!$user->isAdmin()) {
                if ($user->isApproval()) {
                     $query->whereIn('status', ['pengajuan', 'proses', 'selesai']);
                } else {
                    $query->where('created_by', $user->id);
                }
            }

            // Apply filters
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('service_type')) {
                $query->where('service_type_id', $request->service_type);
            }

            if ($request->filled('created_by') && $user->isAdmin()) {
                $query->where('created_by', $request->created_by);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Enhanced search with proper sanitization
            if ($request->filled('search')) {
                $search = trim($request->search);

                if (!empty($search)) {
                    // Sanitize search input to prevent SQL injection
                    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

                    $query->where(function($q) use ($search) {
                        $q->where('ticket_number', 'like', "%{$search}%")
                          ->orWhere('title', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%")
                          ->orWhereHas('creator', function($creatorQuery) use ($search) {
                              $creatorQuery->where('name', 'like', "%{$search}%");
                          })
                          ->orWhereHas('serviceType', function($serviceQuery) use ($search) {
                              $serviceQuery->where('name', 'like', "%{$search}%");
                          });
                    });
                }
            }

            $tickets = $query->latest()->paginate(10)->withQueryString();

            // Data for filter dropdowns
            $serviceTypes = ServiceType::active()->get();
            $users = $user->isAdmin() ? User::where('role', 'pegawai')->get() : collect();

            return view('tickets.index', compact('tickets', 'serviceTypes', 'users'));

        } catch (\Exception $e) {
            \Log::error('Error in tickets index: ' . $e->getMessage());

            // Return with error message and empty results
            $serviceTypes = ServiceType::active()->get();
            $users = collect();
            $tickets = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);

            return view('tickets.index', compact('tickets', 'serviceTypes', 'users'))
                ->with('error', 'Terjadi kesalahan saat melakukan pencarian. Silakan coba lagi.');
        }
    }

    public function create()
    {
        $serviceTypes = ServiceType::active()->orderBy('name')->get();
        return view('tickets.create', compact('serviceTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'service_type_id' => 'required|exists:service_types,id',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:5120',
        ]);

        $user = Auth::user();

        try {
            $ticketNumber = sprintf(
                'KU-%d-%s-%03d',
                $user->department_id ?? 0,
                date('ymd'),
                Ticket::whereDate('created_at', today())->count() + 1
            );

            $data = [
                'ticket_number' => $ticketNumber,
                'title' => $request->title,
                'description' => $request->description,
                'service_type_id' => $request->service_type_id,
                'created_by' => Auth::user()->id,
                'status' => 'pengajuan'
            ];

              // Handle file upload dengan nama sesuai ticket number
            if ($request->hasFile('file_pendukung')) {
                $file = $request->file('file_pendukung');

                if ($file->isValid()) {
                    // Buat nama file dari ticket number
                    $extension = $file->getClientOriginalExtension();
                    $fileName = str_replace(['/', '-'], '_', $ticketNumber) . '.' . $extension;

                    // Simpan ke storage/app/public/tickets
                    $uploadPath = storage_path('app/public/tickets');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    $file->move($uploadPath, $fileName);
                    $data['file_pendukung'] = $fileName;
                }
            }
            $ticket = Ticket::create($data);

            return redirect()->route('tickets.index')
                ->with('success', 'Tiket berhasil dibuat');

        } catch (\Exception $e) {
            \Log::error('Error creating ticket: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat tiket. Silakan coba lagi.');
        }
    }
    public function show(Ticket $ticket)
    {
        $ticket->load(['creator', 'serviceType']);

        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isApproval() && $ticket->created_by !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat tiket ini.');
        }

        return view('tickets.show', compact('ticket'));
    }

    public function cancel(Ticket $ticket)
    {
        $user = Auth::user();

        // Only allow ticket creator or admin to cancel tickets
        if (!$user->isAdmin() && $ticket->created_by !== $user->id) {
            abort(403, 'Anda hanya dapat membatalkan tiket yang Anda buat sendiri.');
        }

        // Only check if ticket status is 'pengajuan'
        if ($ticket->status !== 'pengajuan') {
            abort(403, "Status tiket '{$ticket->status}' tidak dapat dibatalkan. Hanya tiket dengan status 'pengajuan' yang dapat dibatalkan.");
        }

        // Delete the ticket instead of updating status since 'dibatalkan' doesn't exist in enum
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dibatalkan dan dihapus');
    }

    public function edit(Ticket $ticket)
    {
        if (!Auth::user()->isAdmin()&& $ticket->created_by !== $user->id) {
            abort(403, 'Hanya admin yang dapat mengedit tiket.');
        }

        $serviceTypes = ServiceType::active()->get();
        $users = User::where('is_active', true)->get();

        return view('tickets.edit', compact('ticket', 'serviceTypes', 'users'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'service_type_id' => 'required|exists:service_types,id',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:5120',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'service_type_id' => $request->service_type_id,
        ];

        // Handle file upload for update
        if ($request->hasFile('file_pendukung')) {
            // Delete old file if exists
            if ($ticket->file_pendukung) {
                $oldFilePath = storage_path('app/public/tickets/' . $ticket->file_pendukung);
                if (file_exists($oldFilePath)) {
                    @unlink($oldFilePath);
                }
            }

            $file = $request->file('file_pendukung');
            if ($file->isValid()) {
                try {
                    $uploadPath = storage_path('app/public/tickets');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    $extension = $file->getClientOriginalExtension();
                    $fileName = time() . '_' . Str::random(10) . '.' . $extension;

                    $file->move($uploadPath, $fileName);

                    if (file_exists($uploadPath . '/' . $fileName)) {
                        $data['file_pendukung'] = $fileName;
                    }
                } catch (\Exception $e) {
                    \Log::error('File upload error on update: ' . $e->getMessage());
                }
            }
        }

        $ticket->update($data);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Tiket berhasil diperbarui.');
    }

    public function destroy(Ticket $ticket)
    {
        // if (!Auth::user()->isAdmin()) {
        if (!$user->isAdmin() && !$user->isApproval()) {
            abort(403);
        }

        // Delete file if exists
        if ($ticket->file_pendukung) {
            $filePath = storage_path('app/public/tickets/' . $ticket->file_pendukung);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $ticketNumber = $ticket->ticket_number;
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Tiket ' . $ticketNumber . ' berhasil dihapus.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {

        $user = Auth::user();
        // if (!$user->isAdmin() && !$user->isApproval()) {
        if (!$user->isApproval()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah status tiket.');
        }

        // Check if request is AJAX
        $isAjax = request()->ajax() || request()->wantsJson() || request()->hasHeader('X-Requested-With');

        $request->validate([
            'status' => 'required|in:pengajuan,proses,selesai',
            'admin_notes' => 'nullable|string|max:500',
            'completion_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:5120',
        ]);

        $data = [
            'status' => $request->status,
            'approval_notes' => $request->admin_notes
        ];

        // Set timestamp berdasarkan status
        if ($request->status === 'proses') {
            $data['processed_at'] = now();
            // Set approved_by when processing starts
            $data['approved_by'] = Auth::user()->id;
        } elseif ($request->status === 'selesai') {
            $data['completed_at'] = now();
            $data['approved_at'] = now();
            $data['approved_by'] = Auth::user()->id;

            // Handle completion file upload
            if ($request->hasFile('completion_file')) {
                $file = $request->file('completion_file');
                if ($file->isValid()) {
                    try {
                        $uploadPath = storage_path('app/public/tickets/completion');
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadPath, 0755, true);
                        }

                        $extension = $file->getClientOriginalExtension();
                        $fileName = 'completion_' . $ticket->ticket_number . '_' . time() . '.' . $extension;
                        $fileName = str_replace(['/', '-'], '_', $fileName);

                        $file->move($uploadPath, $fileName);
                        $data['completion_file'] = $fileName;
                    } catch (\Exception $e) {
                        \Log::error('Completion file upload error: ' . $e->getMessage());
                    }
                }
            }
        } elseif ($request->status === 'pengajuan' && $request->admin_notes) {
            // When returning to pengajuan with notes, also record who did it
            $data['approved_by'] = Auth::user()->id;
        }

        try {
            $ticket->update($data);

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status tiket berhasil diperbarui',
                    'redirect' => route('tickets.show', $ticket)
                ]);
            }

            return redirect()->route('tickets.show', $ticket)->with('success', 'Status tiket berhasil diperbarui');
        } catch (\Exception $e) {

            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui status: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function downloadFile(Ticket $ticket)
    {
        if (!$ticket->hasFile()) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isApproval() && $ticket->created_by !== $user->id) {
            abort(403);
        }

        $filePath = storage_path('app/public/tickets/' . $ticket->file_pendukung);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server.');
        }

        // Return file untuk ditampilkan, bukan download
        return response()->file($filePath);
    }

    public function downloadCompletionFile(Ticket $ticket)
    {
        if (!$ticket->hasCompletionFile()) {
            return redirect()->back()->with('error', 'File penyelesaian tidak ditemukan.');
        }

        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isApproval() && $ticket->created_by !== $user->id) {
            abort(403);
        }

        $filePath = storage_path('app/public/tickets/completion/' . $ticket->completion_file);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File penyelesaian tidak ditemukan di server.');
        }

        // Return file untuk ditampilkan, bukan download
        return response()->file($filePath);
    }

    public function export(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $query = Ticket::with(['creator', 'serviceType']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_type')) {
            $query->where('service_type_id', $request->service_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $tickets = $query->latest()->get();

        $filename = 'tickets_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($tickets) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'Nomor Tiket',
                'Judul',
                'Jenis Layanan',
                'Status',
                'Dibuat Oleh',
                'Tanggal Dibuat',
                'Tanggal Proses',
                'Tanggal Selesai'
            ]);

            foreach ($tickets as $ticket) {
                fputcsv($file, [
                    $ticket->ticket_number,
                    $ticket->title,
                    $ticket->serviceType->name ?? '-',
                    ucfirst($ticket->status),
                    $ticket->creator->name ?? '-',
                    $ticket->created_at->format('d/m/Y H:i'),
                    $ticket->processed_at ? $ticket->processed_at->format('d/m/Y H:i') : '-',
                    $ticket->completed_at ? $ticket->completed_at->format('d/m/Y H:i') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function statistics()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $stats = [
            'total' => Ticket::count(),
            'pengajuan' => Ticket::where('status', 'pengajuan')->count(),
            'proses' => Ticket::where('status', 'proses')->count(),
            'selesai' => Ticket::where('status', 'selesai')->count(),
        ];

        $serviceTypeStats = ServiceType::withCount('tickets')->get();

        $monthlyStats = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $dailyStatsThisWeek = Ticket::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return view('tickets.statistics', compact('stats', 'serviceTypeStats', 'monthlyStats', 'dailyStatsThisWeek'));
    }

    public function riwayatApproval()
    {
        if (!Auth::user()->isApproval() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        // Show all tickets that have approval activity (not just current user's)
        $approvedTickets = Ticket::where(function($query) {
                $query->whereNotNull('approved_by')
                      ->orWhereNotNull('approval_notes')
                      ->orWhere('status', 'selesai')
                      ->orWhere('status', 'proses');
            })
            ->with(['creator', 'serviceType', 'approvedBy'])
            ->latest('updated_at')
            ->paginate(20);

        \Log::info('Found ' . $approvedTickets->count() . ' tickets in riwayat approval (all tickets)');

        return view('approval.riwayat', compact('approvedTickets'));
    }

    public function downloadRiwayatApproval(Request $request)
    {
           if (!Auth::user()->isApproval() && !Auth::user()->isAdmin()) {
            abort(403);
        }


        $userId = Auth::user()->id;

        // Get the same data as riwayat with optional date filtering
        $query = Ticket::where(function($query) use ($userId) {
                $query->where('approved_by', $userId)
                      ->orWhere('created_by', $userId);
            })
            ->whereIn('status', ['selesai', 'proses', 'pengajuan'])
            ->where(function($query) {
                $query->whereNotNull('approval_notes')
                      ->orWhereNotNull('approved_at')
                      ->orWhereNotNull('processed_at');
            })
            ->with(['creator', 'serviceType']);

        // Apply date filters if provided
        if ($request->filled('date_from')) {
            $query->whereDate('updated_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('updated_at', '<=', $request->date_to);
        }

        $tickets = $query->latest('updated_at')->get();

        $filename = 'riwayat_approval_' . Auth::user()->name . '_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($tickets) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'Nomor Tiket',
                'Judul',
                'Jenis Layanan',
                'Pemohon',
                'NIP Pemohon',
                'Status',
                'Tindakan',
                'Catatan Approval',
                'Tanggal Pengajuan',
                'Tanggal Approval',
                'Approver'
            ]);

            foreach ($tickets as $ticket) {
                // Determine action based on status and dates
                $tindakan = 'Pending';
                if ($ticket->status === 'selesai') {
                    $tindakan = 'Disetujui';
                } elseif ($ticket->status === 'proses') {
                    $tindakan = 'Diproses';
                } elseif ($ticket->approval_notes && $ticket->status === 'pengajuan') {
                    $tindakan = 'Dikembalikan';
                }

                fputcsv($file, [
                    $ticket->ticket_number,
                    $ticket->title,
                    $ticket->serviceType->name ?? '-',
                    $ticket->creator->name ?? '-',
                    $ticket->creator->nip ?? '-',
                    ucfirst($ticket->status),
                    $tindakan,
                    $ticket->approval_notes ?? '-',
                    $ticket->created_at->format('d/m/Y H:i'),
                    $ticket->approved_at ? $ticket->approved_at->format('d/m/Y H:i') : '-',
                    Auth::user()->name
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
