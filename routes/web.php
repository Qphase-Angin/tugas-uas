<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [DashboardController::class, 'tampilProfil'])->name('profil');
        Route::put('/profil', [DashboardController::class, 'updateProfil']);
        Route::get('/ganti-password', [DashboardController::class, 'tampilGantiPassword'])->name('ganti-password');
        Route::post('/ganti-password', [DashboardController::class, 'updateGantiPassword'])->name('ganti-password');

            // Admin user management: delete users
            Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

            // Items management: browse/index (list)
            Route::get('/items', [App\Http\Controllers\Admin\ItemController::class, 'index'])->name('items.index');

            // Items management: create/store items (skins)
            Route::get('/items/create', [App\Http\Controllers\Admin\ItemController::class, 'create'])->name('items.create');
            Route::post('/items', [App\Http\Controllers\Admin\ItemController::class, 'store'])->name('items.store');
            // edit, update, delete
            Route::get('/items/{item}/edit', [App\Http\Controllers\Admin\ItemController::class, 'edit'])->name('items.edit');
            // item show/detail must come after '/items/{item}/edit' to avoid route conflicts with 'create'
            Route::get('/items/{item}', [App\Http\Controllers\Admin\ItemController::class, 'show'])->name('items.show');
            Route::put('/items/{item}', [App\Http\Controllers\Admin\ItemController::class, 'update'])->name('items.update');
            Route::delete('/items/{item}', [App\Http\Controllers\Admin\ItemController::class, 'destroy'])->name('items.destroy');
    });


});
