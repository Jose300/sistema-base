<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');

Route::middleware('guest')->group(function () {
    Route::post('/', [LoginController::class, 'login']);
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Configuración
    Route::prefix('configuracion')->group(function () {
        Route::resource('usuarios', App\Http\Controllers\Config\UsersController::class)->names('usuarios');
        Route::resource('roles', App\Http\Controllers\Config\RolesController::class)->names('roles');
        Route::get('/permisos', [App\Http\Controllers\Config\PermissionsController::class, 'index'])->name('permisos.index');
        Route::post('/permisos/toggle', [App\Http\Controllers\Config\PermissionsController::class, 'toggle'])->name('permisos.toggle');
    });
});
