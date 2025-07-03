<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda: "{{ $query }}" - Nexus</title>
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
</head>
<body>
    <!-- Header Principal -->
    <header class="main-header">
        <nav class="nav-menu">
            <a href="{{ route('home') }}" class="nav-item active">TIENDA</a>
            <a href="{{ route('library.index') }}" class="nav-item">BIBLIOTECA</a>
            <a href="#" class="nav-item">COMUNIDAD</a>
            <a href="{{ route('profile.index') }}" class="nav-item">PERFIL</a>
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
            <a href="{{ route('home') }}">Inicio</a> / 
            <span>Búsqueda: "{{ $query }}"</span>
        </div>

        <!-- Header de Búsqueda -->
        <div class="search-header">
            <h1 class="search-title">Resultados para "{{ $query }}"</h1>
            <p class="search-subtitle">
                {{ $games->count() }} {{ $games->count() == 1 ? 'resultado encontrado' : 'resultados encontrados' }}
            </p>
        </div>

        <!-- Nueva Búsqueda -->
        <div class="new-search-section">
            <form action="{{ route('search') }}" method="GET" class="search-form">
                <div class="search-input-container">
                    <input type="text" 
                           name="q" 
                           class="search-input" 
                           placeholder="Buscar juegos..." 
                           value="{{ $query }}"
                           autocomplete="off"
                           id="searchInput">
                    <button type="submit" class="search-btn">🔍</button>
                </div>
                <div class="search-suggestions" id="searchSuggestions"></div>
            </form>
        </div>

        <!-- Filtros y Ordenamiento -->
        <div class="filters-section">
            <form action="{{ route('search') }}" method="GET" class="filters-form" id="filtersForm">
                <input type="hidden" name="q" value="{{ $query }}">
                
                <div class="filter-group">
                    <label>Categoría:</label>
                    <select name="category" class="filter-select" onchange="document.getElementById('filtersForm').submit()">
                        <option value="all" {{ $categoryFilter == 'all' ? 'selected' : '' }}>Todas las categorías</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryFilter == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label>Ordenar por:</label>
                    <select name="sort" class="filter-select" onchange="document.getElementById('filtersForm').submit()">
                        <option value="relevance" {{ $sortBy == 'relevance' ? 'selected' : '' }}>Relevancia</option>
                        <option value="name_asc" {{ $sortBy == 'name_asc' ? 'selected' : '' }}>Nombre A-Z</option>
                        <option value="name_desc" {{ $sortBy == 'name_desc' ? 'selected' : '' }}>Nombre Z-A</option>
                        <option value="price_asc" {{ $sortBy == 'price_asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                        <option value="price_desc" {{ $sortBy == 'price_desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                        <option value="newest" {{ $sortBy == 'newest' ? 'selected' : '' }}>Más Recientes</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Resultados -->
        @if($games->count() > 0)
            <div class="results-grid">
                @foreach($games as $game)
                    <div class="game-result-card">
                        <a href="{{ route('game.show', $game->slug) }}" class="game-result-link">
                            <div class="game-result-image">
                                <img src="{{ asset($game->image_url) }}" 
                                     alt="{{ $game->title }}" 
                                     onerror="this.src='https://via.placeholder.com/300x200/333/ccc?text=No+Image'">
                            </div>
                            
                            <div class="game-result-info">
                                <h3 class="game-result-title">{{ $game->title }}</h3>
                                <p class="game-result-developer">{{ $game->developer }}</p>
                                <p class="game-result-description">{{ Str::limit($game->description, 120) }}</p>
                                
                                <div class="game-result-meta">
                                    <span class="game-result-category">{{ $game->category->name }}</span>
                                    <span class="game-result-rating">{{ $game->age_rating }}</span>
                                </div>
                                
                                <div class="game-result-footer">
                                    <div class="game-result-price">
                                        <span class="current-price">S/ {{ number_format($game->price, 2) }}</span>
                                        <span class="original-price">S/ {{ number_format($game->price * 1.25, 2) }}</span>
                                    </div>
                                    
                                    @auth
                                        <button class="add-to-cart-btn" onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $game->id }})">
                                            Agregar al Carrito
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" class="add-to-cart-btn login-btn" onclick="event.stopPropagation()">
                                            Iniciar Sesión
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No hay resultados -->
            <div class="no-results">
                <div class="no-results-icon">🔍</div>
                <h3>No se encontraron resultados para "{{ $query }}"</h3>
                <p>Intenta con otros términos de búsqueda o explora nuestras categorías.</p>
                
                @if($suggestions->count() > 0)
                    <div class="suggestions-section">
                        <h4>¿Quizás te interese?</h4>
                        <div class="suggestions-grid">
                            @foreach($suggestions as $suggestion)
                                <a href="{{ route('game.show', $suggestion->slug) }}" class="suggestion-item">
                                    <img src="{{ asset($suggestion->image_url) }}" alt="{{ $suggestion->title }}">
                                    <span>{{ $suggestion->title }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="no-results-actions">
                    <a href="{{ route('home') }}" class="btn-home">Volver al Inicio</a>
                    @foreach($categories->take(5) as $category)
                        <a href="{{ route('category.show', $category->slug) }}" class="btn-category">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        // Autocompletado de búsqueda
        const searchInput = document.getElementById('searchInput');
        const suggestions = document.getElementById('searchSuggestions');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                suggestions.style.display = 'none';
                return;
            }
            
            searchTimeout = setTimeout(() => {
                fetch(`{{ route('autocomplete') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            suggestions.innerHTML = data.map(game => `
                                <div class="suggestion-item" onclick="window.location.href='${game.url}'">
                                    <img src="${game.image}" alt="${game.title}">
                                    <div class="suggestion-info">
                                        <div class="suggestion-title">${game.title}</div>
                                        <div class="suggestion-price">${game.price}</div>
                                    </div>
                                </div>
                            `).join('');
                            suggestions.style.display = 'block';
                        } else {
                            suggestions.style.display = 'none';
                        }
                    })
                    .catch(() => {
                        suggestions.style.display = 'none';
                    });
            }, 300);
        });

        // Ocultar sugerencias al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-input-container')) {
                suggestions.style.display = 'none';
            }
        });

        // Función para agregar al carrito
        function addToCart(gameId) {
            alert('Función de carrito en desarrollo para el juego ID: ' + gameId);
        }

        // Resaltar términos de búsqueda
        function highlightSearchTerms() {
            const searchTerm = "{{ $query }}".toLowerCase();
            const titles = document.querySelectorAll('.game-result-title');
            
            titles.forEach(title => {
                const text = title.textContent;
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                title.innerHTML = text.replace(regex, '<mark>$1</mark>');
            });
        }

        // Ejecutar al cargar la página
        document.addEventListener('DOMContentLoaded', highlightSearchTerms);
    </script>
</body>
</html>