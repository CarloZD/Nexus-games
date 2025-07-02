<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus - Tienda de Videojuegos</title>
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
        
        /* Sección de Bienvenida */
        .welcome-section {
            background: linear-gradient(45deg, #4a47a3, #6b5b95);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .welcome-section h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        /* Filtros de Categorías */
        .category-filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
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
        
        /* Sección Hero + Carrusel */
        .hero-carousel-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 20px;
            position: relative;
        }
        
        .hero-game {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .hero-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }
        
        .hero-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            padding: 30px;
        }
        
        .hero-title {
            font-size: 2em;
            margin-bottom: 10px;
        }
        
        .hero-description {
            margin-bottom: 15px;
            opacity: 0.9;
        }
        
        .availability-badge {
            background: #27ae60;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            display: inline-block;
        }
        
        /* Navegación del Hero */
        .hero-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
            font-size: 18px;
            z-index: 10;
        }
        
        .hero-nav:hover {
            background: #7b68ee;
        }
        
        .hero-prev {
            left: 10px;
        }
        
        .hero-next {
            right: 10px;
        }
        
        /* Dots del Hero */
        .hero-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }
        
        .hero-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .hero-dot.active {
            background: #7b68ee;
        }
        
        /* Carrusel Lateral */
        .carousel-section {
            display: flex;
            flex-direction: column;
        }
        
        .game-title-header {
            color: white;
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .carousel-images {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .carousel-item {
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .carousel-item:hover {
            transform: scale(1.05);
        }
        
        .carousel-image {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }
        
        .game-info {
            text-align: center;
        }
        
        .availability-text {
            background: #27ae60;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.9em;
            margin-bottom: 10px;
            display: inline-block;
        }
        
        .game-price {
            color: #27ae60;
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .add-to-cart-hero {
            background: #5a4fcf;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .add-to-cart-hero:hover {
            background: #4a3fcf;
        }
        
        /* Ocultar juegos hero no activos */
        .hero-slide {
            display: none;
        }
        
        .hero-slide.active {
            display: block;
        }
        
        /* Ofertas Especiales */
        .special-offers {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #fff;
        }
        
        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .offer-card {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s;
        }
        
        .offer-card:hover {
            transform: translateY(-5px);
        }
        
        .offer-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .offer-content {
            padding: 15px;
        }
        
        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #27ae60;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: bold;
        }
        
        .price-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .original-price {
            text-decoration: line-through;
            color: #999;
        }
        
        .current-price {
            color: #27ae60;
            font-weight: bold;
            font-size: 1.2em;
        }
        
        /* Footer con Noticias */
        .footer-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 40px;
        }
        
        .news-section, .reviews-section {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px;
            border-radius: 10px;
        }
        
        .news-item, .review-item {
            padding: 15px;
            border-bottom: 1px solid #333;
            margin-bottom: 15px;
        }
        
        .news-item:last-child, .review-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .news-date, .review-date {
            color: #999;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-carousel-section {
                grid-template-columns: 1fr;
            }
            
            .footer-section {
                grid-template-columns: 1fr;
            }
            
            .nav-menu {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header Principal -->
    <header class="main-header">
        <nav class="nav-menu">
            <a href="{{ route('home') }}" class="nav-item active">TIENDA</a>
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
        </div>

        <!-- Hero + Carrusel -->
        <div class="hero-carousel-section">
            <!-- Juegos Destacados (Navegables) -->
            <div class="hero-game">
                @if(isset($carouselGames) && $carouselGames->count() > 0)
                    @foreach($carouselGames->take(5) as $index => $game)
                        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                            <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="hero-image">
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
                                <img src="{{ $screenshot }}" alt="Screenshot" class="carousel-image">
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
                        <a href="{{ route('game.show', $offer->slug) }}" style="text-decoration: none; color: inherit;">
                            <div class="offer-card">
                                <span class="discount-badge">-{{ rand(20, 50) }}%</span>
                                <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}" class="offer-image">
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
                                "{{ $screenshot }}",
                            @endforeach
                        @else
                            "{{ $game->image_url }}",
                            "{{ $game->image_url }}",
                            "{{ $game->image_url }}",
                            "{{ $game->image_url }}"
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