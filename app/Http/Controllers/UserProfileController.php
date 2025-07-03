<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLibrary;
use App\Models\Review;
use App\Models\Order;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Si no está autenticado, redirigir al login
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Obtener juegos de la biblioteca del usuario
        $libraryGames = UserLibrary::with('game.category')
            ->where('user_id', $user->id)
            ->orderBy('purchased_at', 'desc')
            ->get();
        
        // Obtener reseñas del usuario
        $userReviews = Review::with('game')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Obtener órdenes recientes
        $recentOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // Estadísticas del perfil
        $stats = [
            'total_games' => $libraryGames->count(),
            'hours_played' => $libraryGames->sum('hours_played'),
            'favorites' => $libraryGames->where('is_favorite', true)->count(),
            'completed' => $libraryGames->where('status', 'completed')->count(),
            'total_reviews' => $userReviews->count(),
            'total_orders' => $recentOrders->count(),
        ];
        
        return view('profile.index', compact('user', 'libraryGames', 'stats', 'userReviews', 'recentOrders'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'profile_image' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'bio' => $request->bio,
            'profile_image' => $request->profile_image,
        ]);

        return redirect()->route('profile.index')->with('success', '¡Perfil actualizado correctamente!');
    }
}