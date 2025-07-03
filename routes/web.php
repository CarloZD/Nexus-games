<?php
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController; // ← AGREGAR ESTA LÍNEA
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// Ruta principal - Index de la tienda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Ruta para categorías
Route::get('/categoria/{slug}', [HomeController::class, 'category'])->name('category.show');

// Ruta para vista individual de juegos
Route::get('/juego/{slug}', [HomeController::class, 'show'])->name('game.show');

// Incluir rutas de autenticación de Breeze
require __DIR__.'/auth.php';

// Rutas de administración - Solo para admins
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/games', [AdminController::class, 'games'])->name('games');
});

// Dashboard principal - redirige según el rol
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');
});

// Rutas de perfil Breeze (mantener)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// RUTAS DE PERFIL PERSONALIZADO - ACTUALIZADAS
Route::middleware('auth')->group(function () {
    Route::get('/mi-perfil', [UserProfileController::class, 'index'])->name('profile.index');
    Route::get('/mi-perfil/editar', [UserProfileController::class, 'edit'])->name('profile.edit.custom');
    Route::patch('/mi-perfil', [UserProfileController::class, 'update'])->name('profile.update.custom');
    Route::delete('/mi-perfil/foto', [UserProfileController::class, 'removeProfileImage'])->name('profile.remove-image');
});

// Biblioteca del usuario
Route::middleware('auth')->group(function () {
    Route::get('/biblioteca', [LibraryController::class, 'index'])->name('library.index');
});

// Helper para detectar ruta activa
function isActiveRoute($routeName) {
    return request()->routeIs($routeName) ? 'active' : '';
}

// Rutas de búsqueda
Route::get('/buscar', [HomeController::class, 'search'])->name('search');
Route::get('/api/autocomplete', [HomeController::class, 'autocomplete'])->name('autocomplete');