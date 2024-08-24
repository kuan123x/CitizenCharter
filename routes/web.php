<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing route
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes for authenticated users
Route::middleware('auth')->group(function () {

    // Profile management routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User management routes for admin
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.storeUser');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('/admin/offices', [OfficeController::class, 'index'])->name('admin.offices.index');
        Route::post('/admin/offices', [OfficeController::class, 'store'])->name('admin.storeOffice');
    });

    // Route for Offices page
    Route::get('/offices', [OfficeController::class, 'index'])->name('offices');

    // Routes for pending requests
    Route::get('/pendings/services', function () {
        return view('pendings-folder.pending-services');
    })->name('pending.services');

    Route::get('/pendings/offices', function () {
        return view('pendings-folder.pending-offices');
    })->name('pending.offices');

    // Redirect the default pendings route to the offices route
    Route::get('/pendings', function () {
        return redirect()->route('pending.offices');
    })->name('pendings');
});

// Authentication routes
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
