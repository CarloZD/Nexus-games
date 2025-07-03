<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Biblioteca - Nexus</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
    <!-- Header Principal -->
    <header class="main-header">
        <nav class="nav-menu">
            <a href="{{ route('home') }}" class="nav-item">TIENDA</a>
            <a href="{{ route('library.index') }}" class="nav-item">BIBLIOTECA</a>
            <a href="#" class="nav-item">COMUNIDAD</a>
            <a href="{{ route('profile.index') }}" class="nav-item active">PERFIL</a>
        </nav>
        
        <div class="user-section">
            <div class="cart-icon">
                🛒
                <span class="cart-count">0</span>
            </div>
            <div class="nexus-logo">
                <span class="logo-text">NEXUS</span>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Perfil del Usuario -->
        <div class="user-profile">
            <div class="profile-avatar">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                         alt="Foto de perfil de {{ $user->name }}">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
                
                <!-- Botón de editar -->
                <a href="{{ route('profile.edit.custom') }}" class="edit-icon" title="Editar perfil">✏️</a>
            </div>
            
            <div class="profile-info">
                <h1 class="username">{{ strtoupper($user->name) }}</h1>
                
                <!-- Mostrar biografía si existe -->
                @if($user->bio)
                    <p class="user-bio">
                        "{{ $user->bio }}"
                    </p>
                @endif
                
                <!-- Botón especial para admin -->
                @if($user->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="admin-btn">
                        🎮 Panel de Administrador
                    </a>
                @endif

                <!-- BOTONES DE ACCIÓN - EDITAR Y CERRAR SESIÓN -->
                <div class="profile-actions">
                    <a href="{{ route('profile.edit.custom') }}" class="edit-profile-btn">
                        ✏️ Editar Perfil
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn" onclick="return confirm('¿Estás seguro de que quieres cerrar sesión?')">
                            🚪 Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="library-stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['total_games'] }}</div>
                    <div class="stat-label">JUEGOS</div>
                </div>
            </div>
        </div>

        <!-- Filtros y Opciones -->
        <div class="library-controls">
            <div class="view-options">
                <button class="view-btn active" data-view="grid">📱</button>
                <button class="view-btn" data-view="list">📋</button>
            </div>
            
            <div class="filter-options">
                <select class="filter-select">
                    <option value="all">Todos los juegos</option>
                    <option value="recent">Recientes</option>
                    <option value="favorites">Favoritos</option>
                    <option value="completed">Completados</option>
                </select>
                
                <input type="text" class="search-input" placeholder="Buscar en biblioteca...">
            </div>
        </div>

        <!-- Grid de Juegos -->
        <div class="games-library" id="gamesLibrary">
            @if($libraryGames->count() > 0)
                @foreach($libraryGames as $library)
                    <div class="library-game-card" data-status="{{ $library->status }}">
                        <div class="game-image-container">
                            <img src="{{ asset($library->game->image_url) }}" 
                                 alt="{{ $library->game->title }}" 
                                 class="library-game-image">
                            
                            @if($library->is_favorite)
                                <div class="favorite-badge">⭐</div>
                            @endif
                            
                            <div class="play-overlay">
                                <button class="play-btn">▶️ JUGAR</button>
                            </div>
                        </div>
                        
                        <div class="library-game-info">
                            <h3 class="library-game-title">{{ $library->game->title }}</h3>
                            <div class="library-game-meta">
                                <span class="hours-played">{{ $library->hours_played }}h jugadas</span>
                                <span class="status-badge status-{{ $library->status }}">
                                    {{ ucfirst($library->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="game-actions">
                            <button class="action-btn favorite" onclick="toggleFavorite({{ $library->id }})">
                                {{ $library->is_favorite ? '⭐' : '☆' }}
                            </button>
                            <button class="action-btn menu" onclick="showGameMenu({{ $library->id }})">
                                ⋮
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-library">
                    <div class="empty-icon">📚</div>
                    <h3>Tu biblioteca está vacía</h3>
                    <p>¡Explora nuestra tienda y agrega juegos a tu colección!</p>
                    <a href="{{ route('home') }}" class="browse-btn">Explorar Tienda</a>
                </div>
            @endif
        </div>

        <!-- Estadísticas Detalladas -->
        @if($libraryGames->count() > 0)
            <div class="detailed-stats">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">🎮</div>
                        <div class="stat-info">
                            <div class="stat-number">{{ $stats['total_games'] }}</div>
                            <div class="stat-label">Juegos en Biblioteca</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">⏱️</div>
                        <div class="stat-info">
                            <div class="stat-number">{{ $stats['hours_played'] }}h</div>
                            <div class="stat-label">Horas Jugadas</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-info">
                            <div class="stat-number">{{ $stats['favorites'] }}</div>
                            <div class="stat-label">Favoritos</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">✅</div>
                        <div class="stat-info">
                            <div class="stat-number">{{ $stats['completed'] }}</div>
                            <div class="stat-label">Completados</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Cambiar vista
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const view = this.dataset.view;
                const library = document.getElementById('gamesLibrary');
                
                if (view === 'list') {
                    library.classList.add('list-view');
                } else {
                    library.classList.remove('list-view');
                }
            });
        });

        // Filtrar juegos
        document.querySelector('.filter-select').addEventListener('change', function() {
            const filter = this.value;
            const games = document.querySelectorAll('.library-game-card');
            
            games.forEach(game => {
                if (filter === 'all') {
                    game.style.display = 'block';
                } else if (filter === 'favorites') {
                    game.style.display = game.querySelector('.favorite-badge') ? 'block' : 'none';
                } else if (filter === 'completed') {
                    game.style.display = game.dataset.status === 'completed' ? 'block' : 'none';
                } else {
                    game.style.display = 'block';
                }
            });
        });

        // Buscar juegos
        document.querySelector('.search-input').addEventListener('input', function() {
            const search = this.value.toLowerCase();
            const games = document.querySelectorAll('.library-game-card');
            
            games.forEach(game => {
                const title = game.querySelector('.library-game-title').textContent.toLowerCase();
                game.style.display = title.includes(search) ? 'block' : 'none';
            });
        });

        function toggleFavorite(libraryId) {
            alert('Función de favoritos en desarrollo');
        }

        function showGameMenu(libraryId) {
            alert('Menú del juego en desarrollo');
        }
    </script>
</body>
</html>