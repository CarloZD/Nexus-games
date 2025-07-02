<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $game->title }} - Nexus</title>
    <link rel="stylesheet" href="{{ asset('css/game-detail.css') }}">
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
            <a href="{{ route('home') }}">Inicio</a> / 
            <a href="{{ route('category.show', $game->category->slug) }}">{{ $game->category->name }}</a> / 
            <span>{{ $game->title }}</span>
        </div>

        <!-- Layout Principal -->
        <div class="game-layout">
            <!-- Lado Izquierdo -->
            <div class="game-main">
                <div class="game-header">
                    <img src="{{ asset($game->image_url) }}" alt="{{ $game->title }}" class="game-image-main">
                    
                    <div class="game-info">
                        <h1 class="game-title">{{ strtoupper($game->title) }}</h1>
                        <p class="game-description">{{ $game->description }}</p>
                        
                        <div class="game-category">{{ strtoupper($game->category->name) }}</div>
                        <div class="availability-badge">YA DISPONIBLE</div>
                        
                        @auth
                            <button class="add-to-cart-btn">Agregar al Carrito</button>
                        @else
                            <a href="{{ route('login') }}" class="add-to-cart-btn login-btn">
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
                                <img src="{{ asset($screenshot) }}" alt="Screenshot" class="screenshot-item">
                            @endforeach
                        @else
                            @for($i = 1; $i <= 4; $i++)
                                <img src="{{ asset($game->image_url) }}" alt="Screenshot {{ $i }}" class="screenshot-item">
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
<!-- Juegos Relacionados -->
                <div class="related-games">
                    <h3>Juegos Relacionados</h3>
                    <div class="related-grid">
                        @if($relatedGames->count() > 0)
                            @foreach($relatedGames->take(4) as $related)
                                <a href="{{ route('game.show', $related->slug) }}" class="related-item">
                                    <img src="{{ asset($related->image_url) }}" alt="{{ $related->title }}" class="related-image">
                                    <div class="related-info">
                                        <div class="related-title">{{ $related->title }}</div>
                                        <div class="related-price">S/ {{ number_format($related->price, 2) }}</div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="no-related">
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

            <!-- Reseñas de ejemplo -->
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
                    <div class="review-status recommended">RECOMENDADO</div>
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
                                <span class="star-empty">★</span>
                                <span class="star-empty">★</span>
                                <span class="star-empty">★</span>
                            </div>
                        </div>
                    </div>
                    <div class="review-status not-recommended">NO RECOMENDADO</div>
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
                    <div class="review-status recommended">RECOMENDADO</div>
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