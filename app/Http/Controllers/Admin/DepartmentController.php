<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $query = Department::query()
            ->withCount([
                'users',
                'users as admin_count' => fn($q) => $q->where('role', 'admin'),
                'users as approval_count' => fn($q) => $q->where('role', 'approval'),
                'users as pegawai_count' => fn($q) => $q->where('role', 'pegawai'),
                'tickets as tickets_count',
            ]);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        $departments = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:100|unique:departments,name',
            'description' => 'nullable|string|max:500',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'Nama department wajib diisi.',
            'name.unique' => 'Department sudah ada.',
            'name.max' => 'Nama department maksimal 100 karakter.',
        ]);

        Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department "' . $request->name . '" berhasil ditambahkan.');
    }

    public function show(Department $department)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $users = $department->users()->latest()->paginate(10);

        $departmentStats = [
            'total_users' => $department->users()->count(),
            'active_users' => $department->users()->where('is_active', true)->count(),
            'admin_count' => $department->users()->where('role', 'admin')->count(),
            'approval_count' => $department->users()->where('role', 'approval')->count(),
            'pegawai_count' => $department->users()->where('role', 'pegawai')->count(),
            'total_tickets' => $department->tickets()->count(),
        ];

        return view('admin.departments.show', compact('department', 'users', 'departmentStats'));
    }

    public function edit(Department $department)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:100|unique:departments,name,' . $department->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'Nama department wajib diisi.',
            'name.unique' => 'Department dengan nama tersebut sudah ada.',
        ]);

        $oldName = $department->name;
        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department berhasil diperbarui dari "' . $oldName . '" menjadi "' . $request->name . '".');
    }

    public function destroy(Department $department)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $userCount = $department->users()->count();

        if ($userCount > 0) {
            return redirect()->route('admin.departments.index')
                ->with('error', 'Department tidak dapat dihapus karena masih memiliki ' . $userCount . ' user.');
        }

        $departmentName = $department->name;
        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department "' . $departmentName . '" berhasil dihapus.');
    }

    public function moveUsers(Request $request, Department $department)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'new_department_id' => 'required|exists:departments,id',
        ]);

        $userCount = $department->users()->count();

        if ($userCount > 0) {
            User::where('department_id', $department->id)
                ->update(['department_id' => $request->new_department_id]);
        }

        $newDepartment = Department::find($request->new_department_id);

        return redirect()->route('admin.departments.index')
            ->with('success', $userCount . ' user berhasil dipindahkan dari "' . $department->name . '" ke "' . $newDepartment->name . '".');
    }

    public function toggleStatus(Department $department)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $department->update(['is_active' => !$department->is_active]);

        $status = $department->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department "' . $department->name . '" berhasil ' . $status . '.');
    }
}
