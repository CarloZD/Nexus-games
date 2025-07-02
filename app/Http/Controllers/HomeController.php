<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;           
use App\Models\GameCategory;  

class HomeController extends Controller
{
    /**
     * Mostrar la página principal de la tienda
     */
    public function index()
    {
        // Traer juegos destacados para el carrusel hero
        $carouselGames = Game::with('category')->take(6)->get();
        
        // Traer solo algunas ofertas especiales
        $specialOffers = Game::with('category')->inRandomOrder()->take(3)->get();
        
        // Traer categorías
        $categories = GameCategory::all();
        
        return view('home.index', compact(
            'carouselGames', 
            'specialOffers',
            'categories'
        ));
    }

    /**
     * Mostrar juegos por categoría
     */
    /**
 * Mostrar juegos por categoría
 */
    public function category($slug, Request $request)
    {
        // Buscar la categoría por slug
        $category = GameCategory::where('slug', $slug)->first();
        
        if (!$category) {
            abort(404, 'Categoría no encontrada');
        }
        
        // Query base para juegos de esa categoría
        $query = Game::with('category')->where('category_id', $category->id)->where('is_active', true);
        
        // Aplicar ordenamiento según el parámetro
        $sort = $request->get('sort', 'popular');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
            default:
                $query->orderBy('title', 'asc'); // Por defecto alfabético
        }
        
        $games = $query->get();
        
        // Traer todas las categorías para el menú
        $categories = GameCategory::all();
        
        return view('games.by-category', compact('category', 'games', 'categories', 'sort'));
    }

    /**
     * Mostrar página individual del juego
     */
    public function show($slug)
    {
        // Buscar el juego por slug
        $game = Game::with('category')->where('slug', $slug)->first();
        
        if (!$game) {
            abort(404, 'Juego no encontrado');
        }
        
        // Juegos relacionados (misma categoría)
        $relatedGames = Game::with('category')
            ->where('category_id', $game->category_id)
            ->where('id', '!=', $game->id)
            ->take(4)
            ->get();
        
        return view('games.show', compact('game', 'relatedGames'));
    }
}