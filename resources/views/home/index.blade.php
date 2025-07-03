<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus - Tienda de Videojuegos</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <!-- Header Principal - Dos niveles -->
    <header class="main-header">
        <!-- Nivel Superior -->
        <div class="header-top">
            <nav class="main-nav">
                <a href="{{ route('home') }}" class="nav-item active">TIENDA</a>
                <a href="{{ route('library.index') }}" class="nav-item">BIBLIOTECA</a>
                <a href="#" class="nav-item">COMUNIDAD</a>
                <a href="{{ route('profile.index') }}" class="nav-item">PERFIL</a>
            </nav>
            
            <div class="header-top-right">
                <div class="cart-icon">
                    🛒
                    <span class="cart-count">0</span>
                </div>
                <div class="nexus-logo">
                    <span class="logo-text">NEXUS</span>
                </div>
            </div>
        </div>
        
    </header>

    <div class="container">
        <!-- Sección de Bienvenida -->
        <div class="welcome-section">
            <h1>BIENVENIDO A NEXUS, {{ auth()->check() ? strtoupper(auth()->user()->name) : 'VISITANTE' }}</h1>
        </div>

        <!-- Filtros de Categorías -->
        <div class="category-filters">
            <a href="{{ route('home') }}" class="category-btn active">TODOS</a>
            @if(isset($categories) && $categories->count() > 0)
                @foreach($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}" class="category-btn">{{ strtoupper($category->name) }}</a>
                @endforeach
            @else
                <a href="/categoria/accion" class="category-btn">ACCIÓN</a>
                <a href="/categoria/terror" class="category-btn">TERROR</a>
                <a href="/categoria/supervivencia" class="category-btn">SUPERVIVENCIA</a>
                <a href="/categoria/aventura" class="category-btn">AVENTURA</a>
                <a href="/categoria/estrategia" class="category-btn">ESTRATEGIA</a>
            @endif

                    <!-- Nivel Inferior -->
        <div class="header-bottom"> 
            <div class="header-search">
                <form action="{{ route('search') }}" method="GET" class="search-form-header">
                    <input type="text" 
                           name="q" 
                           class="search-input-header" 
                           placeholder="BUSCAR"
                           autocomplete="off">
                    <button type="submit" class="search-btn-header">🔍</button>
                </form>
            </div>
        </div>
        </div>

        <!-- Hero + Carrusel -->
        <div class="hero-carousel-section">
            <!-- Juegos Destacados (Navegables) -->
            <div class="hero-game">
                @if(isset($carouselGames) && $carouselGames->count() > 0)
                    @foreach($carouselGames->take(5) as $index => $game)
                        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                            <img src="{{ asset($game->image_url) }}" alt="{{ $game->title }}" class="hero-image">
                            <div class="hero-content">
                                <h2 class="hero-title">{{ strtoupper($game->title) }}</h2>
                                <p class="hero-description">{{ $game->description }}</p>
                                <span class="availability-badge">YA DISPONIBLE</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    @for($i = 0; $i < 5; $i++)
                        <div class="hero-slide {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}">
                            <img src="https://picsum.photos/800/400?random={{ $i + 20 }}" alt="Juego Destacado {{ $i + 1 }}" class="hero-image">
                            <div class="hero-content">
                                <h2 class="hero-title">JUEGO DESTACADO {{ $i + 1 }}</h2>
                                <p class="hero-description">Descubre los mejores juegos en Nexus</p>
                                <span class="availability-badge">YA DISPONIBLE</span>
                            </div>
                        </div>
                    @endfor
                @endif

                <!-- Navegación del Hero -->
                <button class="hero-nav hero-prev" onclick="changeHeroSlide(-1)">‹</button>
                <button class="hero-nav hero-next" onclick="changeHeroSlide(1)">›</button>

                <!-- Dots del Hero -->
                <div class="hero-dots" id="heroDots">
                    @for($i = 0; $i < 5; $i++)
                        <span class="hero-dot {{ $i === 0 ? 'active' : '' }}" onclick="currentHeroSlide({{ $i }})"></span>
                    @endfor
                </div>
            </div>

            <!-- Sección Lateral -->
            <div class="carousel-section">
                <h3 class="game-title-header" id="currentGameTitle">
                    @if(isset($carouselGames) && $carouselGames->count() > 0)
                        {{ strtoupper($carouselGames->first()->title) }}
                    @else
                        JUEGO DESTACADO 1
                    @endif
                </h3>
                
                <div class="carousel-images" id="currentGameScreenshots">
                    @if(isset($carouselGames) && $carouselGames->count() > 0)
                        @foreach($carouselGames->first()->screenshots as $screenshot)
                            <div class="carousel-item">
                                <img src="{{ asset($screenshot) }}" alt="Screenshot" class="carousel-image">
                            </div>
                        @endforeach
                    @else
                        @for($i = 1; $i <= 4; $i++)
                            <div class="carousel-item">
                                <img src="https://picsum.photos/200/100?random={{ $i + 30 }}" alt="Screenshot {{ $i }}" class="carousel-image">
                            </div>
                        @endfor
                    @endif
                </div>
                
                <div class="game-info">
                    <div class="availability-text">YA DISPONIBLE</div>
                    <div class="game-price" id="currentGamePrice">
                        @if(isset($carouselGames) && $carouselGames->count() > 0)
                            S/ {{ number_format($carouselGames->first()->price, 2) }}
                        @else
                            S/ 59.99
                        @endif
                    </div>
                    @auth
                        <button class="add-to-cart-hero">Agregar al Carrito</button>
                    @else
                        <a href="{{ route('login') }}" class="add-to-cart-hero">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Ofertas Especiales -->
        <section class="special-offers">
            <h2 class="section-title">OFERTAS ESPECIALES</h2>
            <div class="offers-grid" id="gamesContainer">
                @if(isset($specialOffers) && $specialOffers->count() > 0)
                    @foreach($specialOffers as $offer)
                        <a href="{{ route('game.show', $offer->slug) }}" class="offer-link">
                            <div class="offer-card">
                                <span class="discount-badge">-{{ rand(20, 50) }}%</span>
                                <img src="{{ asset($offer->image_url) }}" alt="{{ $offer->title }}" class="offer-image">
                                <div class="offer-content">
                                    <h3>{{ $offer->title }}</h3>
                                    <div class="price-section">
                                        <span class="original-price">S/ {{ number_format($offer->price * 1.33, 2) }}</span>
                                        <span class="current-price">S/ {{ number_format($offer->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    @for($i = 1; $i <= 3; $i++)
                        <div class="offer-card">
                            <span class="discount-badge">-{{ rand(20, 50) }}%</span>
                            <img src="https://picsum.photos/300/200?random={{ $i + 10 }}" alt="Oferta {{ $i }}" class="offer-image">
                            <div class="offer-content">
                                <h3>Juego en Oferta {{ $i }}</h3>
                                <div class="price-section">
                                    <span class="original-price">S/ 59.99</span>
                                    <span class="current-price">S/ 39.99</span>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
        </section>

        <!-- Footer con Noticias y Reseñas -->
        <div class="footer-section">
            <div class="news-section">
                <h3 class="section-title">Noticias y actualizaciones</h3>
                <div class="news-item">
                    <div class="news-date">11 enero 2025</div>
                    <h4>Monster Hunter Wilds nueva trailer extendido</h4>
                    <p>Se revela nuevo contenido y características del juego más esperado.</p>
                </div>
                <div class="news-item">
                    <div class="news-date">10 enero 2025</div>
                    <h4>Actualización 1.5.0 disponible para Hades 2</h4>
                    <p>Nuevos poderes, enemigos y mejoras de rendimiento.</p>
                </div>
                <div class="news-item">
                    <div class="news-date">09 enero 2025</div>
                    <h4>GTA 6 confirma fecha de lanzamiento</h4>
                    <p>Rockstar Games confirma que el juego saldrá en otoño de 2025.</p>
                </div>
            </div>

            <div class="reviews-section">
                <h3 class="section-title">Reseñas rápidas</h3>
                <div class="review-item">
                    <div class="review-date">Subido hace 2 horas</div>
                    <h4>Cyberpunk 2077: Phantom Liberty</h4>
                    <p>Una expansión que redefine el juego base con una historia cautivadora.</p>
                </div>
                <div class="review-item">
                    <div class="review-date">Subido hace 5 horas</div>
                    <h4>The Witcher 3: Wild Hunt</h4>
                    <p>Sigue siendo el mejor RPG de mundo abierto años después.</p>
                </div>
                <div class="review-item">
                    <div class="review-date">Subido hace 1 día</div>
                    <h4>Resident Evil 4 Remake</h4>
                    <p>Un remake perfecto que respeta el original mientras lo moderniza.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentHeroIndex = 0;
        const totalHeroSlides = 5;
        
        // Datos de los juegos desde la base de datos
        const gameData = [
            @if(isset($carouselGames) && $carouselGames->count() > 0)
                @foreach($carouselGames->take(5) as $index => $game)
                {
                    title: "{{ strtoupper($game->title) }}",
                    price: "{{ number_format($game->price, 2) }}",
                    screenshots: [
                        @if($game->screenshots && count($game->screenshots) > 0)
                            @foreach(array_slice($game->screenshots, 0, 4) as $screenshot)
                                "{{ asset($screenshot) }}",
                            @endforeach
                        @else
                            "{{ asset($game->image_url) }}",
                            "{{ asset($game->image_url) }}",
                            "{{ asset($game->image_url) }}",
                            "{{ asset($game->image_url) }}"
                        @endif
                    ]
                }{{ $loop->last ? '' : ',' }}
                @endforeach
            @endif
        ];

        function showHeroSlide(index) {
            // Ocultar todos los slides
            document.querySelectorAll('.hero-slide').forEach(slide => {
                slide.classList.remove('active');
            });
            
            // Mostrar el slide actual
            const currentSlide = document.querySelector(`.hero-slide[data-slide="${index}"]`);
            if (currentSlide) {
                currentSlide.classList.add('active');
            }
            
            // Actualizar dots
            document.querySelectorAll('.hero-dot').forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            
            // Actualizar información lateral
            updateSidePanel(index);
        }

        function updateSidePanel(index) {
            const game = gameData[index];
            if (!game) return;
            
            // Actualizar título
            document.getElementById('currentGameTitle').textContent = game.title;
            
            // Actualizar precio
            document.getElementById('currentGamePrice').textContent = `S/ ${game.price}`;
            
            // Actualizar screenshots
            const screenshotsContainer = document.getElementById('currentGameScreenshots');
            screenshotsContainer.innerHTML = '';
            
            game.screenshots.slice(0, 4).forEach(screenshot => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'carousel-item';
                itemDiv.innerHTML = `<img src="${screenshot}" alt="Screenshot" class="carousel-image">`;
                screenshotsContainer.appendChild(itemDiv);
            });
        }

        function changeHeroSlide(direction) {
            currentHeroIndex = (currentHeroIndex + direction + totalHeroSlides) % totalHeroSlides;
            showHeroSlide(currentHeroIndex);
        }

        function currentHeroSlide(index) {
            currentHeroIndex = index;
            showHeroSlide(currentHeroIndex);
        }

        // Auto-slide cada 8 segundos
        setInterval(() => {
            changeHeroSlide(1);
        }, 8000);

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            showHeroSlide(0);
        });
    </script>
</body>
</html>