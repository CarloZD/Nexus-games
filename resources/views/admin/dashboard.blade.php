<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Nexus Games</title>
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
        
        .admin-header {
            background: rgba(0, 0, 0, 0.9);
            padding: 15px 20px;
            border-bottom: 2px solid #e74c3c;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-logo h1 {
            color: #e74c3c;
            font-size: 1.8em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .admin-badge {
            background: #e74c3c;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.7em;
            font-weight: bold;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-home {
            background: #5a4fcf;
            color: white;
        }
        
        .btn-home:hover {
            background: #4a3fcf;
        }
        
        .btn-logout {
            background: #e74c3c;
            color: white;
        }
        
        .btn-logout:hover {
            background: #c0392b;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        
        .welcome-section {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .welcome-title {
            font-size: 2em;
            margin-bottom: 10px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 25px;
            border-left: 4px solid #e74c3c;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card.games { border-left-color: #5a4fcf; }
        .stat-card.users { border-left-color: #27ae60; }
        .stat-card.categories { border-left-color: #f39c12; }
        
        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 10px;
        }
        
        .stat-number.games { color: #5a4fcf; }
        .stat-number.users { color: #27ae60; }
        .stat-number.categories { color: #f39c12; }
        
        .stat-label {
            color: #ccc;
            font-size: 1.1em;
            margin-bottom: 5px;
        }
        
        .stat-description {
            color: #999;
            font-size: 0.9em;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 40px;
        }
        
        .action-card {
            background: rgba(231, 76, 60, 0.1);
            border: 2px solid #e74c3c;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: white;
            transition: all 0.3s;
        }
        
        .action-card:hover {
            background: rgba(231, 76, 60, 0.2);
            transform: translateY(-3px);
        }
        
        .action-icon {
            font-size: 2.5em;
            margin-bottom: 10px;
            display: block;
        }
        
        .action-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .recent-section {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 25px;
        }
        
        .section-title {
            color: white;
            font-size: 1.4em;
            margin-bottom: 20px;
            border-bottom: 2px solid #e74c3c;
            padding-bottom: 10px;
        }
        
        .recent-games {
            display: grid;
            gap: 15px;
        }
        
        .recent-game {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 8px;
        }
        
        .game-image {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9em;
        }
        
        .game-info {
            flex: 1;
        }
        
        .game-title {
            color: white;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .game-meta {
            color: #ccc;
            font-size: 0.9em;
        }
        
        .game-status {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .status-active {
            background: #27ae60;
            color: white;
        }
        
        .status-inactive {
            background: #e74c3c;
            color: white;
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .header-actions {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
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
                    <div style="text-align: center; color: #ccc; padding: 20px;">
                        No hay juegos recientes para mostrar
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>