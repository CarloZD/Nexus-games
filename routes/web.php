<?php

use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController; // IMPORTANTE: Agregar esta línea
use Illuminate\Support\Facades\Route;

// Ruta principal - Index de la tienda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Ruta para categorías
Route::get('/categoria/{slug}', [HomeController::class, 'category'])->name('category.show');

// Ruta para vista individual de juegos
Route::get('/juego/{slug}', [HomeController::class, 'show'])->name('game.show');

// Incluir rutas de autenticación de Breeze
require __DIR__.'/auth.php';

// Dashboard según el rol del usuario - Todos van al index
Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard para usuarios normales - También al index
Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', function () {
        return redirect('/');
    })->name('user.dashboard');
});

// Dashboard para administradores - También al index (por ahora)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return redirect('/');
    })->name('admin.dashboard');
});

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});