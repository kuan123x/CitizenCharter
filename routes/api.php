<?php

use App\Http\Controllers\API\GuestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/offices', [GuestController::class, 'getOffices']);
Route::get('/offices/{office_id}/services', [GuestController::class, 'getServicesForOffice']);
Route::get('/offices/{office_id}/services/{service_id}', [GuestController::class, 'getServiceInfo']);
// /offices/$officeId/services/$serviceId
Route::get('/events', [GuestController::class, 'getEvents']);
Route::get('/events/{event_id}', [GuestController::class, 'getEventById']);
Route::get('/notifications', [GuestController::class, 'getNotifications']);

// Route::middleware('auth:sanctum')->group(function () {
//     // Route::get('auth/user', [OfficeController::class, 'user']);
//     Route::get('user/offices', [OfficeController::class, 'index']);
//     // Route::
// });

// Route::get
// Route::post('auth/token', [TokenController::class, 'store']);
// Route::post('user/register', [RegisterController::class, 'store']);