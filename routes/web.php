<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\ProfileController;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {


    // Admin Routes
    Route::group(['middleware' => function ($request, $next) {
        if (!auth()->user()->isAdmin()) {abort(403, 'Unauthorized access.');
        }
             return $next($request);
        }],
        function ()
        {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

        // User Management Routes
        Route::resource('admin/users', UserController::class, ['as' => 'admin']);
        Route::post('/admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
        Route::post('/admin/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');

        // Service Type Management Routes
        Route::resource('admin/service-types', ServiceTypeController::class, [
            'as' => 'admin'
        ]);
        Route::post('/admin/service-types/{serviceType}/toggle-status', [ServiceTypeController::class, 'toggleStatus'])->name('admin.service-types.toggle-status');

        // Department Management Routes
        Route::resource('admin/departments', DepartmentController::class, [
            'as' => 'admin'
        ]);
        Route::post('/admin/departments/{department}/move-users', [DepartmentController::class, 'moveUsers'])->name('admin.departments.move-users');
        Route::post('/admin/departments/{department}/toggle-status', [DepartmentController::class, 'toggleStatus'])->name('admin.departments.toggle-status');
    });

    // Approval Routes
    Route::group(['middleware' => function ($request, $next) {
        if (!auth()->user()->isApproval() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }], function () {
        Route::get('/approval/dashboard', [DashboardController::class, 'approvalDashboard'])->name('approval.dashboard');
        Route::post('/tickets/{ticket}/approve', [TicketController::class, 'approve'])->name('tickets.approve');
        Route::get('/approval/riwayat', [TicketController::class, 'riwayatApproval'])->name('approval.riwayat');
        Route::get('/approval/riwayat/download', [TicketController::class, 'downloadRiwayatApproval'])->name('approval.riwayat.download');
    });

    // Pegawai Routes
    Route::group(['middleware' => function ($request, $next) {
        if (!auth()->user()->isPegawai()) {
            abort(403, 'Unauthorized access.');
            }   return $next($request);
         }], function () {
    Route::get('/pegawai/dashboard', [DashboardController::class, 'pegawaiDashboard'])->name('pegawai.dashboard');});
    Route::get('/bantuan', [DashboardController::class, 'bantuanPegawai'])->name('bantuan');

    // Shared Routes (All authenticated users)

    Route::resource('tickets', TicketController::class);
       // Form buat tiket baru
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');
    Route::get('/tickets/{ticket}/download', [TicketController::class, 'downloadFile'])->name('tickets.download');
    Route::get('/tickets/{ticket}/download-completion', [TicketController::class, 'downloadCompletionFile'])->name('tickets.download-completion');
    // Ticket Management Routes
        Route::patch('/tickets/{ticket}/update-status', [TicketController::class, 'updateStatus'])->name('tickets.update-status');
        Route::get('/tickets/statistics', [TicketController::class, 'statistics'])->name('tickets.statistics');
        Route::get('/tickets/export', [TicketController::class, 'export'])->name('tickets.export');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});
