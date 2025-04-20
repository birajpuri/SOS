<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/', [LoginController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'getUser'])->name('admin.get-user');
    Route::get('/admin/drivers', [AdminController::class, 'getDriver'])->name('admin.get-driver');
    Route::get('/admin/bookings', [AdminController::class, 'getBooking'])->name('admin.get-booking');
    // Route::post('/admin/assign', [AdminController::class,'getBooking'])->name('admin.get-booking');
    // Route::get('/admin/settings/update', [AdminController::class,'getBooking'])->name('admin.get-booking');

    //admin functions
    Route::get('/admin/user-list', [UserController::class, 'index'])->name('user.index');
    Route::get('/admin/user-create', [UserController::class, 'create'])->name('user.create');
    Route::post('/admin/user-store', [UserController::class, 'store'])->name('user.store');
    Route::get('/admin/user-show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/admin/user-edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/admin/user-update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/admin/user-delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});
