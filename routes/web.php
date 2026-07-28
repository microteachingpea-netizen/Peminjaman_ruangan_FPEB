<?php

use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingAdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showMain'])->name('main');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/api/bookings/{room_id}', [BookingController::class, 'getEvents']);

Route::middleware(['auth'])->group(function () {
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notif}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
});

Route::middleware(['auth'])->prefix('prodi')->name('prodi.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'prodiIndex'])->name('dashboard');
});

// Grup Utama Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman Notifikasi Admin
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');

    // Manajemen Booking
    Route::get('/bookings', [BookingAdminController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/approve', [BookingAdminController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [BookingAdminController::class, 'reject'])->name('bookings.reject');

    // Manajemen Ruangan
    Route::get('/rooms', [RoomController::class, 'adminIndex'])->name('rooms.index');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // Fasilitas
    Route::post('/facilities', [FacilityController::class, 'storeFacility'])->name('facilities.store');
    Route::delete('/facilities/{facility}', [FacilityController::class, 'destroy'])->name('facilities.destroy');

    // KHUSUS MENU SENSITIF (Hanya Admin Tunggal)
    // Cukup gunakan grup rute biasa, karena sudah berada di dalam middleware 'admin' utama
    Route::group([], function () {
        
        // Users 
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}/update-roles', [UserController::class, 'updateRoles'])->name('users.update-roles');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Roles
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

        // Permissions
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });
});