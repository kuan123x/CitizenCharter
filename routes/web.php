<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServicesInfoController;
use Illuminate\Support\Facades\Route;

// Login route
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

// Dashboard route (after login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes that require authentication
Route::middleware('auth')->group(function () {

    // Profile management routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/mvmsp', [UserController::class, 'mvmsp']);
    Route::get('/mvmsp', function() {
        return view('pages.mvmsp');
    })->name('mvmsp');
    Route::get('/org-chart', function() {
        return view('pages.org-chart');
    })->name('org-chart');
    Route::get('/elected-officials', function() {
        return view('pages.elected-officials');
    })->name('elected-officials');
    
    // Route::get('/offices', [OfficeController::class, 'index'])->name('offices');
    
    
    // Admin routes (require 'admin' role)
    Route::middleware(['auth', 'role:admin'])->group(function () {

        // User management
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.storeUser');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        // Office management
        Route::get('/admin/offices', [OfficeController::class, 'index'])->name('admin.offices.index');
        Route::post('/admin/offices', [OfficeController::class, 'store'])->name('admin.storeOffice');

        Route::put('/admin/offices/{office}', [OfficeController::class, 'update'])->name('admin.offices.update');
    Route::delete('/admin/offices/{office}', [OfficeController::class, 'destroy'])->name('admin.offices.destroy');


        // Pending services (admin approval)
        Route::get('/admin/pending-services', [ServiceController::class, 'pendingServices'])->name('pending.services');
        Route::post('/admin/services/{serviceId}/approve', [ServiceController::class, 'approveService'])->name('services.approve');
        Route::post('/admin/services/{serviceId}/reject', [ServiceController::class, 'rejectService'])->name('services.reject');

        // Pending events (admin approval)
        Route::get('/admin/pending-events', [EventController::class, 'showPendingEvents'])->name('pending.events');
        Route::post('/admin/events/{id}/approve', [EventController::class, 'approveEvent'])->name('events.approve');
        Route::post('/admin/events/{id}/reject', [EventController::class, 'rejectEvent'])->name('events.reject');
    });

    // Events management for users
    Route::get('/events', [EventController::class, 'index'])->name('events.page'); // Display approved events

    // Route for storing a new event (from the modal)
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/offices', [OfficeController::class, 'index'])->name('offices');
    Route::get('/offices/{id}', [OfficeController::class, 'showServices'])->name('offices.services');
    Route::get('/offices/{office_id}/services/{service_id}', [OfficeController::class, 'serviceDetails'])->name('offices.show');
    // Offices and services
    // Route::get('/offices/{id}/services', [OfficeController::class, 'show'])->name('offices.show');
    // Route::post('/offices/{id}/services', [OfficeController::class, 'storeService'])->name('services.storeService');
    Route::get('/offices/feedbacks', [OfficeController::class, 'feedbacks'])->name('feedbacks');
    
    // Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/services/edit/{id}', [ServiceController::class, 'edit'])->name('services.edit');
    Route::get('/services/{id}/details', [ServiceController::class, 'showService'])->name('services.details');
    Route::post('/services/store', [ServicesInfoController::class, 'store'])->name('services.store');

    Route::put('/services/{service_id}/info/{info_id}', [ServicesInfoController::class, 'update'])->name('services.info.update');
    Route::delete('/services/{service_id}/info/{info_id}', [ServicesInfoController::class, 'destroy'])->name('services.info.delete');

    Route::post('/offices/{id}/services', [ServiceController::class, 'storeService'])->name('services.storeService');
    // Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    // Route::put('/services/{serviceId}', [ServiceController::class, 'updateService'])->name('services.update');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');

    Route::delete('/services/{serviceId}', [ServiceController::class, 'deleteService'])->name('services.delete');

    // Pending services/events/offices for admin review
    Route::get('/pendings', function () {
        return redirect()->route('pending.events');
    })->name('pendings');
    Route::get('/pendings/events', [EventController::class, 'showPendingEvents'])->name('pending.events');
    Route::get('/pendings/services', [ServiceController::class, 'pendingServices'])->name('pending.services');
    Route::get('/pendings/offices', function () {
        return view('pendings-folder.pending-offices');
    })->name('pending.offices');
});

// Feedback routes
Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');
Route::post('/feedbacks/{feedback}/reply', [FeedbackController::class, 'reply'])->name('feedbacks.reply');

// Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

// Authentication routes
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
