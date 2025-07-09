<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;           
use App\Models\GameCategory;  
use App\Models\News; 
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * Mostrar la página principal de la tienda
     */
    public function index()
    {
        // ✅ OBTENER JUEGOS ALEATORIOS ÚNICOS
        
        // Primero obtener todos los juegos activos
        $allGames = Game::with('category')->where('is_active', true)->get();
        
        // Mezclar aleatoriamente y dividir
        $shuffledGames = $allGames->shuffle();
        
        // Tomar 6 para el carrusel (sin repetir)
        $carouselGames = $shuffledGames->take(6);
        
        // Tomar 3 diferentes para ofertas especiales (excluyendo los del carrusel)
        $specialOffers = $shuffledGames->skip(6)->take(3);
        
        // Si no hay suficientes juegos, llenar con los disponibles
        if ($carouselGames->count() < 6) {
            $carouselGames = $allGames->take(6);
        }
        
        if ($specialOffers->count() < 3) {
            // Si no hay suficientes después del skip, tomar de todos pero evitar duplicados
            $usedIds = $carouselGames->pluck('id')->toArray();
            $specialOffers = $allGames->whereNotIn('id', $usedIds)->take(3);
            
            // Si aún no hay suficientes, completar con cualquiera
            if ($specialOffers->count() < 3) {
                $specialOffers = $allGames->take(3);
            }
        }
        
        // Traer categorías
        $categories = GameCategory::all();

        // Traer noticias más recientes
        $news = News::orderBy('date', 'desc')->take(3)->get();
        
        // Traer 3 reseñas aleatorias con usuario y juego
        $quickReviews = Review::with(['user', 'game'])
            ->where('is_approved', true)
            ->inRandomOrder()
            ->take(3)
            ->get();
        
        return view('home.index', compact(
            'carouselGames', 
            'specialOffers',
            'categories',
            'news',
            'quickReviews'
        ));
    }

    // ... resto de métodos sin cambios ...
    
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $categoryFilter = $request->get('category', 'all');
        $sortBy = $request->get('sort', 'relevance');
        
        if (empty(trim($query))) {
            return redirect()->route('home')->with('error', 'Por favor ingresa un término de búsqueda');
        }
        
        $gamesQuery = Game::with('category')->where('is_active', true);
        
        $gamesQuery->where(function($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%")
              ->orWhere('developer', 'LIKE', "%{$query}%")
              ->orWhere('publisher', 'LIKE', "%{$query}%");
        });
        
        if ($categoryFilter !== 'all') {
            $gamesQuery->where('category_id', $categoryFilter);
        }
        
        switch ($sortBy) {
            case 'price_asc':
                $gamesQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $gamesQuery->orderBy('price', 'desc');
                break;
            case 'newest':
                $gamesQuery->orderBy('created_at', 'desc');
                break;
            case 'name_asc':
                $gamesQuery->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $gamesQuery->orderBy('title', 'desc');
                break;
            case 'relevance':
            default:
                $gamesQuery->orderByRaw("CASE 
                    WHEN title LIKE '{$query}%' THEN 1 
                    WHEN title LIKE '%{$query}%' THEN 2 
                    ELSE 3 
                END")
                ->orderBy('title', 'asc');
        }
        
        $games = $gamesQuery->get();
        $categories = GameCategory::all();
        
        $suggestions = [];
        if ($games->isEmpty()) {
            $suggestions = Game::where('is_active', true)
                ->where(function($q) use ($query) {
                    $searchWords = explode(' ', $query);
                    foreach ($searchWords as $word) {
                        if (strlen($word) > 2) {
                            $q->orWhere('title', 'LIKE', "%{$word}%")
                              ->orWhere('developer', 'LIKE', "%{$word}%");
                        }
                    }
                })
                ->take(5)
                ->get();
        }
        
        return view('search.results', compact(
            'games', 
            'categories', 
            'query', 
            'categoryFilter', 
            'sortBy',
            'suggestions'
        ));
    }

    public function category($slug, Request $request)
    {
        $category = GameCategory::where('slug', $slug)->first();
        
        if (!$category) {
            abort(404, 'Categoría no encontrada');
        }
        
        $query = Game::with('category')->where('category_id', $category->id)->where('is_active', true);
        
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
                $query->orderBy('title', 'asc');
        }
        
        $games = $query->get();
        $categories = GameCategory::all();
        
        return view('games.by-category', compact('category', 'games', 'categories', 'sort'));
    }

    public function show($slug)
    {
        $game = Game::with('category')->where('slug', $slug)->first();
        
        if (!$game) {
            abort(404, 'Juego no encontrado');
        }
        
        $relatedGames = Game::with('category')
            ->where('category_id', $game->category_id)
            ->where('id', '!=', $game->id)
            ->take(4)
            ->get();
        
        return view('games.show', compact('game', 'relatedGames'));
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $suggestions = Game::where('is_active', true)
            ->where('title', 'LIKE', "%{$query}%")
            ->orderByRaw("CASE WHEN title LIKE '{$query}%' THEN 1 ELSE 2 END")
            ->take(8)
            ->get(['id', 'title', 'slug', 'image_url', 'price'])
            ->map(function($game) {
                return [
                    'id' => $game->id,
                    'title' => $game->title,
                    'slug' => $game->slug,
                    'image' => asset($game->image_url),
                    'price' => 'S/ ' . number_format($game->price, 2),
                    'url' => route('game.show', $game->slug)
                ];
            });
        
        return response()->json($suggestions);
    }
}