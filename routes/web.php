<?php
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController; 
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

// Dashboard según el rol del usuario
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect('/'); // Usuarios normales van al home (tienda)
    })->name('dashboard');

});

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});