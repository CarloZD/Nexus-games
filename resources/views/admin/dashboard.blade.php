<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Nexus Games</title>
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
</head>
<body>
    <!-- Header del Admin -->
    <header class="admin-header">
        <div class="admin-logo">
            <h1>🎮 NEXUS ADMIN <span class="admin-badge">ADMINISTRADOR</span></h1>
        </div>
        
        <div class="header-actions">
            <span>Hola, {{ $user->name ?? 'Admin' }}</span>
            <a href="{{ route('home') }}" class="btn btn-home">Ver Tienda</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </header>

    <div class="container">
        <!-- Bienvenida -->
        <div class="welcome-section">
            <h1 class="welcome-title">Panel de Administración</h1>
            <p>Gestiona tu tienda de videojuegos Nexus desde aquí</p>
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card games">
                <div class="stat-number games">{{ $stats['total_games'] ?? 0 }}</div>
                <div class="stat-label">Total de Juegos</div>
                <div class="stat-description">En el catálogo</div>
            </div>
            
            <div class="stat-card games">
                <div class="stat-number games">{{ $stats['active_games'] ?? 0 }}</div>
                <div class="stat-label">Juegos Activos</div>
                <div class="stat-description">Visibles en tienda</div>
            </div>
            
            <div class="stat-card games">
                <div class="stat-number games">{{ $stats['hidden_games'] ?? 0 }}</div>
                <div class="stat-label">Juegos Ocultos</div>
                <div class="stat-description">No visibles</div>
            </div>
            
            <div class="stat-card users">
                <div class="stat-number users">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="stat-label">Usuarios</div>
                <div class="stat-description">Registrados</div>
            </div>
            
            <div class="stat-card categories">
                <div class="stat-number categories">{{ $stats['total_categories'] ?? 0 }}</div>
                <div class="stat-label">Categorías</div>
                <div class="stat-description">Disponibles</div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <h2 class="section-title">Acciones Rápidas</h2>
        <div class="quick-actions">
            <a href="{{ route('admin.games') }}" class="action-card">
                <span class="action-icon">🎮</span>
                <div class="action-title">Gestionar Juegos</div>
                <div>Agregar, editar, ocultar</div>
            </a>
            
            <a href="#" class="action-card">
                <span class="action-icon">👥</span>
                <div class="action-title">Usuarios</div>
                <div>Gestionar usuarios</div>
            </a>
            
            <a href="#" class="action-card">
                <span class="action-icon">📂</span>
                <div class="action-title">Categorías</div>
                <div>Organizar géneros</div>
            </a>
            
            <a href="#" class="action-card">
                <span class="action-icon">⚙️</span>
                <div class="action-title">Configuración</div>
                <div>Ajustes del sistema</div>
            </a>
        </div>

        <!-- Juegos Recientes -->
        <div class="recent-section">
            <h3 class="section-title">Juegos Recientes</h3>
            <div class="recent-games">
                @if(isset($stats['recent_games']) && $stats['recent_games']->count() > 0)
                    @foreach($stats['recent_games'] as $game)
                        <div class="recent-game">
                            <div class="game-image">
                                {{ strtoupper(substr($game->title, 0, 3)) }}
                            </div>
                            <div class="game-info">
                                <div class="game-title">{{ $game->title }}</div>
                                <div class="game-meta">{{ $game->category->name ?? 'Sin categoría' }} • {{ $game->developer }} • S/ {{ number_format($game->price, 2) }}</div>
                            </div>
                            <span class="game-status {{ $game->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $game->is_active ? 'Activo' : 'Oculto' }}
                            </span>
                        </div>
                    @endforeach
                @else
                    <div class="no-games">
                        No hay juegos recientes para mostrar
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>