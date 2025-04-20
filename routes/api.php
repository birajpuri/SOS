<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\DriverController;
use App\Http\Controllers\Api\Admin\VehicleController;
use App\Http\Controllers\Api\Admin\BookingController;
use App\Http\Controllers\Api\Admin\EmergencyController;
use App\Http\Controllers\Api\Admin\HospitalController;
use App\Http\Controllers\Api\Admin\SupportController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookingController as UserBookingController;

// Admin API Routes
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('drivers', DriverController::class);
    Route::apiResource('vehicles', VehicleController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('hospitals', HospitalController::class);
    Route::apiResource('emergency', EmergencyController::class);
    Route::apiResource('support', SupportController::class);
    Route::get('dashboard/stats', [BookingController::class, 'dashboardStats']);
});

// Mobile App API Routes (V1)
Route::prefix('v1')->group(function () {
    // Auth Routes
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    
    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
        
        // Booking Routes
        Route::apiResource('bookings', UserBookingController::class);
        Route::post('bookings/{booking}/cancel', [UserBookingController::class, 'cancel']);
        Route::get('nearby-drivers', [UserBookingController::class, 'nearbyDrivers']);
        Route::get('nearby-hospitals', [UserBookingController::class, 'nearbyHospitals']);
        
        // Emergency SOS
        Route::post('emergency-sos', [UserBookingController::class, 'emergencySos']);
    });
});


