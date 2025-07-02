<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - Nexus</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2c1810 0%, #1a0e2e 50%, #0f051a 100%);
            color: white;
            min-height: 100vh;
        }
        
        /* Header Principal */
        .main-header {
            background: rgba(0, 0, 0, 0.8);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #444;
        }
        
        .nav-menu {
            display: flex;
            gap: 30px;
        }
        
        .nav-item {
            color: #ccc;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .nav-item:hover, .nav-item.active {
            background: #5a4fcf;
            color: white;
        }
        
        .user-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .cart-icon {
            position: relative;
            color: #ccc;
            font-size: 20px;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Contenedor Principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            margin-bottom: 20px;
            color: #ccc;
        }
        
        .breadcrumb a {
            color: #5a4fcf;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        /* Header de Categoría */
        .category-header {
            background: linear-gradient(45deg, #4a47a3, #6b5b95);
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .category-header h1 {
            font-size: 3em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .category-header p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        /* Filtros de Categorías */
        .category-filters {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .category-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #555;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .category-btn:hover, .category-btn.active {
            background: #5a4fcf;
            border-color: #5a4fcf;
        }
        
        /* Información de resultados */
        .results-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #333;
        }
        
        .results-count {
            color: #ccc;
            font-size: 1.1em;
        }
        
        .sort-options {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .sort-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #555;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .sort-btn:hover, .sort-btn.active {
            background: #5a4fcf;
            border-color: #5a4fcf;
        }
        
        /* Grid de Juegos */
        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .game-card {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        
        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(90, 79, 207, 0.3);
        }
        
        .game-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .game-content {
            padding: 20px;
        }
        
        .game-title {
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 10px;
            color: white;
        }
        
        .game-description {
            color: #ccc;
            font-size: 0.9em;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .game-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .game-developer {
            color: #999;
            font-size: 0.9em;
        }
        
        .game-rating {
            background: #27ae60;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
        }
        
        .game-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .price-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        
        .current-price {
            color: #27ae60;
            font-weight: bold;
            font-size: 1.3em;
        }
        
        .original-price {
            color: #999;
            text-decoration: line-through;
            font-size: 0.9em;
        }
        
        .add-to-cart {
            background: #5a4fcf;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .add-to-cart:hover {
            background: #4a3fcf;
        }
        
        /* Mensaje cuando no hay juegos */
        .no-games {
            text-align: center;
            padding: 60px 20px;
            color: #ccc;
        }
        
        .no-games h3 {
            font-size: 2em;
            margin-bottom: 15px;
        }
        
        .no-games p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .results-info {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .sort-options {
                width: 100%;
                justify-content: space-between;
            }
            
            .category-header h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <!-- Header Principal -->
    <header class="main-header">
        <nav class="nav-menu">
            <a href="{{ route('home') }}" class="nav-item">TIENDA</a>
            <a href="#" class="nav-item">BIBLIOTECA</a>
            <a href="#" class="nav-item">COMUNIDAD</a>
            <a href="#" class="nav-item">PERFIL</a>
        </nav>
        
        <div class="user-section">
            <div class="cart-icon">
                🛒
                <span class="cart-count">0</span>
            </div>
            @auth
                <span>{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                        Cerrar Sesión
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-item">Iniciar Sesión</a>
            @endauth
        </div>
    </header>

    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Inicio</a> / <span>{{ $category->name }}</span>
        </div>

        <!-- Header de Categoría -->
        <div class="category-header">
            <h1>{{ strtoupper($category->name) }}</h1>
            <p>Descubre los mejores juegos de {{ strtolower($category->name) }}</p>
        </div>

        <!-- Filtros de Categorías -->
        <div class="category-filters">
            <a href="{{ route('home') }}" class="category-btn">TODOS</a>
            @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->slug) }}" 
                   class="category-btn {{ $cat->id == $category->id ? 'active' : '' }}">
                    {{ strtoupper($cat->name) }}
                </a>
            @endforeach
        </div>

        <!-- Información de resultados -->
        <div class="results-info">
            <div class="results-count">
                {{ $games->count() }} {{ $games->count() == 1 ? 'juego encontrado' : 'juegos encontrados' }}
            </div>
            <div class="sort-options">
                <span style="color: #ccc;">Ordenar por:</span>
                <a href="#" class="sort-btn active">Populares</a>
                <a href="#" class="sort-btn">Precio: Menor a Mayor</a>
                <a href="#" class="sort-btn">Precio: Mayor a Menor</a>
                <a href="#" class="sort-btn">Más Recientes</a>
            </div>
        </div>

        <!-- Grid de Juegos -->
        @if($games->count() > 0)
            <div class="games-grid">
                @foreach($games as $game)
                    <a href="{{ route('game.show', $game->slug) }}" style="text-decoration: none; color: inherit;">
                        <div class="game-card">
                            <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="game-image">
                            <div class="game-content">
                                <h3 class="game-title">{{ $game->title }}</h3>
                                <p class="game-description">{{ $game->description }}</p>
                                
                                <div class="game-meta">
                                    <span class="game-developer">{{ $game->developer }}</span>
                                    <span class="game-rating">{{ $game->age_rating }}</span>
                                </div>
                                
                                <div class="game-price">
                                    @auth
                                        <button class="add-to-cart" onclick="event.preventDefault(); event.stopPropagation(); alert('Función de carrito en desarrollo');">Agregar al Carrito</button>
                                    @else
                                        <a href="{{ route('login') }}" class="add-to-cart" style="text-decoration: none;" onclick="event.stopPropagation();">Iniciar Sesión</a>
                                    @endauth
                                    
                                    <div class="price-section">
                                        <span class="current-price">S/ {{ number_format($game->price, 2) }}</span>
                                        <span class="original-price">S/ {{ number_format($game->price * 1.25, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="no-games">
                <h3>No hay juegos en esta categoría</h3>
                <p>Parece que aún no tenemos juegos disponibles en {{ strtolower($category->name) }}.</p>
                <a href="{{ route('home') }}" class="category-btn">Ver todos los juegos</a>
            </div>
        @endif
    </div>
</body>
</html>