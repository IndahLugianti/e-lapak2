<?php
// app/Http/Controllers/Admin/ServiceTypeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceTypeController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $query = ServiceType::withCount('tickets');

        // Apply filters
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        if ($request->filled('requires_file')) {
            $query->where('requires_file', $request->requires_file === '1');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $serviceTypes = $query->latest()->paginate(15)->withQueryString();

        return view('admin.service-types.index', compact('serviceTypes'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.service-types.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:service_types,name',
            'description' => 'required|string|max:1000',
            'requires_file' => 'required|boolean',
            'file_requirements' => 'nullable|string|max:500',
            'estimated_days' => 'required|integer|min:1|max:30',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'Nama jenis layanan wajib diisi.',
            'name.unique' => 'Nama jenis layanan sudah ada.',
            'description.required' => 'Deskripsi wajib diisi.',
            'requires_file.required' => 'Status file pendukung wajib dipilih.',
            'estimated_days.required' => 'Estimasi hari wajib diisi.',
            'estimated_days.min' => 'Estimasi hari minimal 1 hari.',
            'estimated_days.max' => 'Estimasi hari maksimal 30 hari.',
        ]);

        ServiceType::create([
            'name' => $request->name,
            'description' => $request->description,
            'requires_file' => $request->requires_file,
            'file_requirements' => $request->requires_file ? $request->file_requirements : null,
            'estimated_days' => $request->estimated_days,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.service-types.index')
            ->with('success', 'Jenis layanan berhasil ditambahkan.');
    }

    public function show(ServiceType $serviceType)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $serviceType->load(['tickets']);

        $ticketStats = [
            'total' => $serviceType->tickets()->count(),
            'open' => $serviceType->tickets()->where('status', 'open')->count(),
            'completed' => $serviceType->tickets()->where('status', 'completed')->count(),
        ];

        return view('admin.service-types.show', compact('serviceType', 'ticketStats'));
    }

    public function edit(ServiceType $serviceType)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.service-types.edit', compact('serviceType'));
    }

    public function update(Request $request, ServiceType $serviceType)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:service_types,name,' . $serviceType->id,
            'description' => 'required|string|max:1000',
            'requires_file' => 'required|boolean',
            'file_requirements' => 'nullable|string|max:500',
            'estimated_days' => 'required|integer|min:1|max:30',
            'is_active' => 'required|boolean',
        ]);

        $serviceType->update([
            'name' => $request->name,
            'description' => $request->description,
            'requires_file' => $request->requires_file,
            'file_requirements' => $request->requires_file ? $request->file_requirements : null,
            'estimated_days' => $request->estimated_days,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.service-types.index')
            ->with('success', 'Jenis layanan berhasil diperbarui.');
    }

    public function destroy(ServiceType $serviceType)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if service type has tickets
        $ticketCount = $serviceType->tickets()->count();
        if ($ticketCount > 0) {
            return redirect()->route('admin.service-types.index')
                ->with('error', 'Jenis layanan tidak dapat dihapus karena memiliki ' . $ticketCount . ' tiket.');
        }

        $serviceTypeName = $serviceType->name;
        $serviceType->delete();

        return redirect()->route('admin.service-types.index')
            ->with('success', 'Jenis layanan "' . $serviceTypeName . '" berhasil dihapus.');
    }

    public function toggleStatus(ServiceType $serviceType)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $serviceType->update([
            'is_active' => !$serviceType->is_active
        ]);

        $status = $serviceType->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.service-types.index')
            ->with('success', 'Jenis layanan "' . $serviceType->name . '" berhasil ' . $status . '.');
    }
}
