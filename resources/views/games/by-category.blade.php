<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - Nexus</title>
    <link rel="stylesheet" href="{{ asset('css/category.css') }}">
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
                    <button type="submit" class="logout-btn">Cerrar Sesión</button>
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
                <span>Ordenar por:</span>
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
                    <div class="game-card" onclick="window.location.href='{{ route('game.show', $game->slug) }}'">
                        <img src="{{ asset($game->image_url) }}" 
                             alt="{{ $game->title }}" 
                             class="game-image"
                             onerror="this.src='https://via.placeholder.com/300x200/333/ccc?text=No+Image'">
                        
                        <div class="game-content">
                            <h3 class="game-title">{{ $game->title }}</h3>
                            <p class="game-description">{{ $game->description }}</p>
                            
                            <div class="game-meta">
                                <span class="game-developer">{{ $game->developer }}</span>
                                <span class="game-rating">{{ $game->age_rating }}</span>
                            </div>
                            
                            <div class="game-price-section">
                                @auth
                                    <button class="action-btn" onclick="event.stopPropagation(); addToCart({{ $game->id }})">
                                        Agregar al Carrito
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="action-btn login" onclick="event.stopPropagation()">
                                        Iniciar Sesión
                                    </a>
                                @endauth
                                
                                <div class="price-info">
                                    <span class="current-price">S/ {{ number_format($game->price, 2) }}</span>
                                    <span class="original-price">S/ {{ number_format($game->price * 1.25, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
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

    <script>
        function addToCart(gameId) {
            alert('Función de carrito en desarrollo para el juego ID: ' + gameId);
        }
    </script>
</body>
</html>