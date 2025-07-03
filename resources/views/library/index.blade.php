<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Nexus</title>
    <link rel="stylesheet" href="{{ asset('css/library.css') }}">
</head>
<body>
    <!-- Header Principal -->
    <header class="main-header">
        <!-- Nivel Superior -->
        <div class="header-top">
            <nav class="main-nav">
                <a href="{{ route('home') }}" class="nav-item">TIENDA</a>
                <a href="{{ route('library.index') }}" class="nav-item active">BIBLIOTECA</a>
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
        
        <!-- Nivel Inferior con Búsqueda -->
        <div class="header-bottom">
            <div class="header-search-full">
                <form action="#" method="GET" class="search-form-header">
                    <input type="text" 
                           name="q" 
                           class="search-input-header" 
                           placeholder="BUSCAR"
                           autocomplete="off"
                           id="librarySearch">
                    <button type="submit" class="search-btn-header">🔍</button>
                </form>
            </div>
        </div>
    </header>

    <div class="library-container">
        <!-- Sidebar Izquierda -->
        <aside class="library-sidebar">
            <!-- Página Principal -->
            <div class="sidebar-section">
                <button class="sidebar-item active" data-filter="all">
                    🏠 Página principal
                </button>
            </div>

            <!-- Lista de Juegos -->
            <div class="sidebar-section">
                <div class="sidebar-games-list">
                    @if($libraryGames->count() > 0)
                        @foreach($libraryGames as $library)
                            <div class="sidebar-game" data-game-id="{{ $library->game->id }}">
                                <img src="{{ asset($library->game->image_url) }}" 
                                     alt="{{ $library->game->title }}" 
                                     class="sidebar-game-icon">
                                <span class="sidebar-game-title">{{ $library->game->title }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="no-games-sidebar">
                            <p>No hay juegos en tu biblioteca</p>
                        </div>
                    @endif
                </div>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <main class="library-main">
            @if($libraryGames->count() > 0)
                <!-- Grid de Juegos Estilo Steam -->
                <div class="games-steam-grid" id="gamesGrid">
                    @foreach($libraryGames as $library)
                        <div class="steam-game-card" 
                             data-status="{{ $library->status }}" 
                             data-favorite="{{ $library->is_favorite ? 'true' : 'false' }}"
                             data-title="{{ strtolower($library->game->title) }}">
                            
                            <div class="steam-game-image">
                                <img src="{{ asset($library->game->image_url) }}" 
                                     alt="{{ $library->game->title }}" 
                                     class="game-cover">
                                
                                <!-- Overlay de información al hover -->
                                <div class="game-overlay">
                                    <div class="game-overlay-content">
                                        <h3 class="overlay-title">{{ $library->game->title }}</h3>
                                        <p class="overlay-developer">{{ $library->game->developer }}</p>
                                        <div class="overlay-meta">
                                            <span class="overlay-hours">{{ $library->hours_played }}h jugadas</span>
                                            <span class="overlay-category">{{ $library->game->category->name }}</span>
                                        </div>
                                        <div class="overlay-actions">
                                            <button class="overlay-btn play-btn">▶️ JUGAR</button>
                                            <button class="overlay-btn menu-btn" onclick="toggleGameMenu({{ $library->id }})">⋮</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Badge de favorito -->
                                @if($library->is_favorite)
                                    <div class="favorite-badge">⭐</div>
                                @endif
                                
                                <!-- Badge de estado -->
                                <div class="status-indicator status-{{ $library->status }}"></div>
                            </div>
                            
                            <!-- Menú contextual -->
                            <div class="context-menu" id="menu-{{ $library->id }}">
                                <button onclick="toggleFavorite({{ $library->id }})">
                                    {{ $library->is_favorite ? '💔 Quitar de favoritos' : '❤️ Agregar a favoritos' }}
                                </button>
                                <button onclick="changeStatus({{ $library->id }})">🏷️ Cambiar estado</button>
                                <button onclick="addHours({{ $library->id }})">⏱️ Registrar horas</button>
                                <button onclick="viewDetails({{ $library->game->id }})">📋 Ver detalles</button>
                                <hr>
                                <button onclick="removeGame({{ $library->id }})" class="danger">🗑️ Eliminar de biblioteca</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado vacío -->
                <div class="empty-library-steam">
                    <div class="empty-content">
                        <div class="empty-icon">📚</div>
                        <h2>Tu biblioteca está vacía</h2>
                        <p>¡Explora nuestra tienda y agrega juegos a tu colección!</p>
                        <a href="{{ route('home') }}" class="explore-btn">Explorar Tienda</a>
                    </div>
                </div>
            @endif
        </main>
    </div>

    <script>
        // Búsqueda en biblioteca
        document.getElementById('librarySearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const gameCards = document.querySelectorAll('.steam-game-card');
            
            gameCards.forEach(card => {
                const title = card.dataset.title;
                if (title.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Sidebar game selection
        document.querySelectorAll('.sidebar-game').forEach(game => {
            game.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-game').forEach(g => g.classList.remove('active'));
                this.classList.add('active');
                
                // Scroll to game in main area
                const gameId = this.dataset.gameId;
                const targetCard = document.querySelector(`.steam-game-card[data-game-id="${gameId}"]`);
                if (targetCard) {
                    targetCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    // Highlight briefly
                    targetCard.style.boxShadow = '0 0 20px #5a4fcf';
                    setTimeout(() => {
                        targetCard.style.boxShadow = '';
                    }, 2000);
                }
            });
        });

        // Funciones del menú contextual
        function toggleGameMenu(libraryId) {
            // Cerrar otros menús abiertos
            document.querySelectorAll('.context-menu').forEach(menu => {
                if (menu.id !== `menu-${libraryId}`) {
                    menu.classList.remove('show');
                }
            });
            
            const menu = document.getElementById(`menu-${libraryId}`);
            menu.classList.toggle('show');
        }

        function toggleFavorite(libraryId) {
            alert(`Función de favoritos en desarrollo para game ${libraryId}`);
            toggleGameMenu(libraryId);
        }

        function changeStatus(libraryId) {
            const newStatus = prompt('Nuevo estado (playing, completed, not_played, abandoned):');
            if (newStatus) {
                alert(`Cambiar estado a "${newStatus}" para game ${libraryId}`);
            }
            toggleGameMenu(libraryId);
        }

        function addHours(libraryId) {
            const hours = prompt('¿Cuántas horas jugaste?');
            if (hours && !isNaN(hours)) {
                alert(`Agregar ${hours} horas al game ${libraryId}`);
            }
            toggleGameMenu(libraryId);
        }

        function viewDetails(gameId) {
            window.open(`/juego/${gameId}`, '_blank');
        }

        function removeGame(libraryId) {
            if (confirm('¿Estás seguro de que quieres eliminar este juego de tu biblioteca?')) {
                alert(`Eliminar game ${libraryId} de la biblioteca`);
            }
            toggleGameMenu(libraryId);
        }

        // Cerrar menús al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.context-menu') && !e.target.closest('.menu-btn')) {
                document.querySelectorAll('.context-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });

        // Filtro de página principal
        document.querySelector('.sidebar-item').addEventListener('click', function() {
            document.querySelectorAll('.steam-game-card').forEach(card => {
                card.style.display = 'block';
            });
            document.getElementById('librarySearch').value = '';
        });
    </script>
</body>
</html>