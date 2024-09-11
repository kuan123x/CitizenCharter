<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServicesInfoController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.storeUser');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('/admin/offices', [OfficeController::class, 'index'])->name('admin.offices.index');
        Route::post('/admin/offices', [OfficeController::class, 'store'])->name('admin.storeOffice');

        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');


         Route::post('/events', [EventController::class, 'store'])->name('events.store');

         Route::get('/admin/pending-services', [ServiceController::class, 'pendingServices'])->name('pending.services');
        Route::post('/admin/services/{serviceId}/approve', [ServiceController::class, 'approveService'])->name('services.approve');
         Route::post('/admin/services/{serviceId}/reject', [ServiceController::class, 'rejectService'])->name('services.reject');
    });


    Route::get('/offices', [OfficeController::class, 'index'])->name('offices');
    Route::get('/offices/{id}/services', [OfficeController::class, 'show'])->name('offices.show');


    Route::post('/offices/{id}/services', [OfficeController::class, 'storeService'])->name('services.storeService');


    Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');


    Route::get('/services/{id}/details', [ServiceController::class, 'showService'])->name('services.details');

    Route::post('/services/store', [ServicesInfoController::class, 'store'])->name('services.store');
    Route::delete('/services/{service_id}/info/{info_id}', [ServicesInfoController::class, 'destroy'])->name('services.info.delete');

    Route::get('/pendings/events', [EventController::class, 'showPendingEvents'])->name('pending.events');


    Route::get('/pendings/services', [ServiceController::class, 'pendingServices'])->name('pending.services');

    Route::get('/pendings/offices', function () {
        return view('pendings-folder.pending-offices');
    })->name('pending.offices');

    // Route::get('/pendings/events', function () {
    //     return view('pendings-folder.pending-events');
    // })->name('pending.events');


    Route::get('/pendings', function () {
        return redirect()->route('pending.events');
    })->name('pendings');
});

Route::get('/events', function () {
    return view('pages.events');
})->name('events');

Route::get('/event', function () {
    return view('events.index');
})->name('events.page');

Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');
Route::post('/feedbacks/{feedback}/reply', [FeedbackController::class, 'reply'])->name('feedbacks.reply');


Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
