<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $game->title }} - Nexus</title>
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
        
        /* Layout Principal */
        .game-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        /* Lado Izquierdo */
        .game-main {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 20px;
        }
        
        .game-header {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .game-image-main {
            width: 300px;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }
        
        .game-info {
            flex: 1;
        }
        
        .game-title {
            font-size: 2.5em;
            margin-bottom: 15px;
            color: white;
        }
        
        .game-description {
            color: #ccc;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .game-category {
            background: #5a4fcf;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 15px;
            font-size: 0.9em;
            font-weight: bold;
        }
        
        .availability-badge {
            background: #27ae60;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            margin-bottom: 20px;
            display: inline-block;
        }
        
        .add-to-cart-btn {
            background: #27ae60;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            display: block;
            width: 200px;
        }
        
        .add-to-cart-btn:hover {
            background: #219a52;
        }
        
        /* Screenshots */
        .screenshots-section {
            margin-top: 30px;
        }
        
        .screenshots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
        }
        
        .screenshot-item {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .screenshot-item:hover {
            transform: scale(1.05);
        }
        
        /* Lado Derecho */
        .game-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        /* Especificaciones */
        .specifications {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 20px;
        }
        
        .specifications h3 {
            color: white;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .spec-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #333;
        }
        
        .spec-item:last-child {
            border-bottom: none;
        }
        
        .spec-icon {
            font-size: 1.2em;
        }
        
        .spec-text {
            color: #ccc;
        }
        
        /* Requerimientos del Sistema */
        .system-requirements {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 20px;
        }
        
        .system-requirements h3 {
            color: white;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .requirements-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .req-tab {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #555;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .req-tab.active {
            background: #5a4fcf;
            border-color: #5a4fcf;
        }
        
        .requirements-content {
            display: none;
        }
        
        .requirements-content.active {
            display: block;
        }
        
        .req-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #333;
        }
        
        .req-item:last-child {
            border-bottom: none;
        }
        
        .req-label {
            color: #ccc;
            font-weight: bold;
        }
        
        .req-value {
            color: white;
            text-align: right;
        }
        
        /* Juegos Relacionados */
        .related-games {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 20px;
        }
        
        .related-games h3 {
            color: white;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .related-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .related-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            padding: 10px;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            color: white;
        }
        
        .related-item:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .related-image {
            width: 100%;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 8px;
        }
        
        .related-title {
            font-size: 0.9em;
            font-weight: bold;
            margin-bottom: 4px;
        }
        
        .related-price {
            color: #27ae60;
            font-size: 0.8em;
        }
        
        /* Sección de Reseñas */
        .reviews-section {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .reviews-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .reviews-title {
            color: white;
            font-size: 1.5em;
        }
        
        .write-review-btn {
            background: #5a4fcf;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .write-review-btn:hover {
            background: #4a3fcf;
        }
        
        .review-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .reviewer-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .reviewer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #5a4fcf;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .reviewer-name {
            font-weight: bold;
            color: white;
        }
        
        .review-rating {
            display: flex;
            gap: 2px;
        }
        
        .star {
            color: #ffd700;
        }
        
        .review-text {
            color: #ccc;
            line-height: 1.6;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .game-layout {
                grid-template-columns: 1fr;
            }
            
            .game-header {
                flex-direction: column;
                text-align: center;
            }
            
            .game-image-main {
                width: 100%;
                max-width: 300px;
                margin: 0 auto;
            }
            
            .related-grid {
                grid-template-columns: 1fr;
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
            <a href="{{ route('home') }}">Inicio</a> / 
            <a href="{{ route('category.show', $game->category->slug) }}">{{ $game->category->name }}</a> / 
            <span>{{ $game->title }}</span>
        </div>

        <!-- Layout Principal -->
        <div class="game-layout">
            <!-- Lado Izquierdo -->
            <div class="game-main">
                <div class="game-header">
                    <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="game-image-main">
                    
                    <div class="game-info">
                        <h1 class="game-title">{{ strtoupper($game->title) }}</h1>
                        <p class="game-description">{{ $game->description }}</p>
                        
                        <div class="game-category">{{ strtoupper($game->category->name) }}</div>
                        <div class="availability-badge">YA DISPONIBLE</div>
                        
                        @auth
                            <button class="add-to-cart-btn">Agregar al Carrito</button>
                        @else
                            <a href="{{ route('login') }}" class="add-to-cart-btn" style="text-decoration: none; text-align: center;">
                                Iniciar Sesión para Comprar
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Screenshots -->
                <div class="screenshots-section">
                    <div class="screenshots-grid">
                        @if($game->screenshots && count($game->screenshots) > 0)
                            @foreach($game->screenshots as $screenshot)
                                <img src="{{ $screenshot }}" alt="Screenshot" class="screenshot-item">
                            @endforeach
                        @else
                            @for($i = 1; $i <= 4; $i++)
                                <img src="{{ $game->image_url }}" alt="Screenshot {{ $i }}" class="screenshot-item">
                            @endfor
                        @endif
                    </div>
                </div>
            </div>

            <!-- Lado Derecho -->
            <div class="game-sidebar">
                <!-- Especificaciones -->
                <div class="specifications">
                    <h3>Especificaciones</h3>
                    <div class="spec-item">
                        <span class="spec-icon">👤</span>
                        <span class="spec-text">Un jugador</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">👥</span>
                        <span class="spec-text">Multijugador masivo</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">🌐</span>
                        <span class="spec-text">JvJ en línea</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">⭐</span>
                        <span class="spec-text">Cooperativo en línea</span>
                    </div>
                </div>

                <!-- Requerimientos del Sistema -->
                <div class="system-requirements">
                    <h3>Requerimientos del Sistema</h3>
                    
                    <div class="requirements-tabs">
                        <button class="req-tab active" onclick="showRequirements('minimum')">Mínimos</button>
                        <button class="req-tab" onclick="showRequirements('recommended')">Recomendados</button>
                    </div>
                    
                    @if($game->system_requirements)
                        <!-- Requerimientos Mínimos -->
                        <div id="minimum" class="requirements-content active">
                            @if(isset($game->system_requirements['minimum']))
                                @foreach($game->system_requirements['minimum'] as $key => $value)
                                    <div class="req-item">
                                        <span class="req-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                        <span class="req-value">{{ $value }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <!-- Requerimientos Recomendados -->
                        <div id="recommended" class="requirements-content">
                            @if(isset($game->system_requirements['recommended']))
                                @foreach($game->system_requirements['recommended'] as $key => $value)
                                    <div class="req-item">
                                        <span class="req-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                        <span class="req-value">{{ $value }}</span>
                                    </div>
                                @endforeach
                            @else
                                @foreach($game->system_requirements['minimum'] as $key => $value)
                                    <div class="req-item">
                                        <span class="req-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                        <span class="req-value">{{ $value }} (Mejorado)</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Juegos Relacionados -->
                <div class="related-games">
                    <h3>Juegos Relacionados</h3>
                    <div class="related-grid">
                        @if($relatedGames->count() > 0)
                            @foreach($relatedGames->take(4) as $related)
                                <a href="{{ route('game.show', $related->slug) }}" class="related-item">
                                    <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="related-image">
                                    <div class="related-title">{{ $related->title }}</div>
                                    <div class="related-price">S/ {{ number_format($related->price, 2) }}</div>
                                </a>
                            @endforeach
                        @else
                            <div style="grid-column: 1/-1; text-align: center; color: #ccc; padding: 20px;">
                                No hay juegos relacionados disponibles
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Reseñas -->
        <div class="reviews-section">
            <div class="reviews-header">
                <h3 class="reviews-title">Reseñas</h3>
                @auth
                    <button class="write-review-btn">Publica tu opinión</button>
                @endauth
            </div>

            <!-- Reseñas de ejemplo (por ahora estáticas) -->
            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">R</div>
                        <div>
                            <div class="reviewer-name">RainKald</div>
                            <div class="review-rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                            </div>
                        </div>
                    </div>
                    <div style="color: #999; font-size: 0.9em;">RECOMENDADO</div>
                </div>
                <p class="review-text">¡Jugué2u el mejor juego en aspecto o sea y combate aunque ahora el online está un poco muerto hay demasiados mods para hacer solo nunca te aburres</p>
            </div>

            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">N</div>
                        <div>
                            <div class="reviewer-name">Nixehalt</div>
                            <div class="review-rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span style="color: #666;">★</span>
                                <span style="color: #666;">★</span>
                                <span style="color: #666;">★</span>
                            </div>
                        </div>
                    </div>
                    <div style="color: #e74c3c; font-size: 0.9em;">NO RECOMENDADO</div>
                </div>
                <p class="review-text">lo compre hace un tiempo, me termine el modo historia, quize meterme en el multijugador online, no me tocaba con casi gente, y ahora bloquearán el juego en steam venezuela que hasta ya ni operech los nuevos dlc, mal servicio y soporte para la gente que compro el juego aqui y ahora los ignora y bloquea</p>
            </div>

            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">T</div>
                        <div>
                            <div class="reviewer-name">Totoro CR</div>
                            <div class="review-rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                            </div>
                        </div>
                    </div>
                    <div style="color: #999; font-size: 0.9em;">RECOMENDADO</div>
                </div>
                <p class="review-text">Casi 18 años desde que salió y lo disfruto como si fuera nuevo, aunque te saquen demasiados dlc's, en vez de que desisten hacer el verdadero 3.</p>
            </div>
        </div>
    </div>

    <script>
        function showRequirements(type) {
            // Ocultar todas las pestañas de contenido
            document.querySelectorAll('.requirements-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remover clase active de todos los tabs
            document.querySelectorAll('.req-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Mostrar el contenido seleccionado
            document.getElementById(type).classList.add('active');
            
            // Marcar el tab como activo
            event.target.classList.add('active');
        }
    </script>
</body>
</html>