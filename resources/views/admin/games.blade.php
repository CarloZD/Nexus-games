<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Juegos - Nexus Admin</title>
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
        
        .btn-dashboard {
            background: #5a4fcf;
            color: white;
        }
        
        .btn-dashboard:hover {
            background: #4a3fcf;
        }
        
        .btn-home {
            background: #27ae60;
            color: white;
        }
        
        .btn-home:hover {
            background: #219a52;
        }
        
        .btn-logout {
            background: #e74c3c;
            color: white;
        }
        
        .btn-logout:hover {
            background: #c0392b;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 2.5em;
            color: white;
        }
        
        .btn-primary {
            background: #e74c3c;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }
        
        .games-section {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 25px;
        }
        
        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .game-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }
        
        .game-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
        }
        
        .game-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .game-title {
            font-size: 1.3em;
            font-weight: bold;
            color: white;
            margin-bottom: 5px;
        }
        
        .game-developer {
            color: #ccc;
            font-size: 0.9em;
        }
        
        .game-status {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
            text-align: center;
        }
        
        .status-active {
            background: #27ae60;
            color: white;
        }
        
        .status-inactive {
            background: #e74c3c;
            color: white;
        }
        
        .game-info {
            margin-bottom: 15px;
        }
        
        .game-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9em;
        }
        
        .game-category {
            color: #5a4fcf;
            font-weight: 500;
        }
        
        .game-price {
            color: #27ae60;
            font-weight: bold;
        }
        
        .game-rating {
            background: #f39c12;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .game-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8em;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-edit {
            background: #3498db;
            color: white;
        }
        
        .btn-edit:hover {
            background: #2980b9;
        }
        
        .btn-toggle {
            background: #f39c12;
            color: white;
        }
        
        .btn-toggle:hover {
            background: #e67e22;
        }
        
        .btn-delete {
            background: #e74c3c;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c0392b;
        }
        
        .no-games {
            text-align: center;
            padding: 60px 20px;
            color: #ccc;
        }
        
        .no-games h3 {
            font-size: 2em;
            margin-bottom: 15px;
        }
        
        .no-games p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }
            
            .games-grid {
                grid-template-columns: 1fr;
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
            <h1>🎮 GESTIÓN DE JUEGOS</h1>
        </div>
        
        <div class="header-actions">
            <span>Hola, {{ auth()->user()->name }}</span>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-dashboard">Dashboard</a>
            <a href="{{ route('home') }}" class="btn btn-home">Ver Tienda</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </header>

    <div class="container">
        <!-- Header de la página -->
        <div class="page-header">
            <h1 class="page-title">Gestión de Juegos</h1>
            <button class="btn-primary" onclick="alert('Función de agregar juego en desarrollo')">
                ➕ Agregar Nuevo Juego
            </button>
        </div>

        <!-- Lista de juegos -->
        <div class="games-section">
            @if(isset($games) && $games->count() > 0)
                <div class="games-grid">
                    @foreach($games as $game)
                        <div class="game-card">
                            <div class="game-header">
                                <div>
                                    <div class="game-title">{{ $game->title }}</div>
                                    <div class="game-developer">{{ $game->developer }}</div>
                                </div>
                                <span class="game-status {{ $game->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $game->is_active ? 'Activo' : 'Oculto' }}
                                </span>
                            </div>
                            
                            <div class="game-info">
                                <div class="game-meta">
                                    <span class="game-category">{{ $game->category->name ?? 'Sin categoría' }}</span>
                                    <span class="game-price">S/ {{ number_format($game->price, 2) }}</span>
                                </div>
                                
                                <div class="game-meta">
                                    <span class="game-rating">{{ $game->age_rating }}</span>
                                    <span style="color: #ccc;">{{ $game->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="game-actions">
                                <button class="btn-sm btn-edit" onclick="alert('Editar {{ $game->title }}')">
                                    ✏️ Editar
                                </button>
                                <button class="btn-sm btn-toggle" onclick="toggleGame({{ $game->id }}, '{{ $game->title }}', {{ $game->is_active ? 'true' : 'false' }})">
                                    {{ $game->is_active ? '👁️ Ocultar' : '👁️‍🗨️ Mostrar' }}
                                </button>
                                <button class="btn-sm btn-delete" onclick="deleteGame({{ $game->id }}, '{{ $game->title }}')">
                                    🗑️ Eliminar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-games">
                    <h3>No hay juegos registrados</h3>
                    <p>Agrega el primer juego a tu catálogo</p>
                    <button class="btn-primary" onclick="alert('Función de agregar juego en desarrollo')">
                        Agregar Primer Juego
                    </button>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleGame(id, title, isActive) {
            const action = isActive ? 'ocultar' : 'mostrar';
            
            if (confirm(`¿Estás seguro de que quieres ${action} "${title}"?`)) {
                // Aquí iría la llamada AJAX al servidor
                alert(`Función para ${action} juego en desarrollo`);
                
                // Simular cambio visual
                console.log(`Toggle game ${id}: ${action}`);
            }
        }
        
        function deleteGame(id, title) {
            if (confirm(`¿Estás seguro de que quieres eliminar "${title}"? Esta acción no se puede deshacer.`)) {
                // Aquí iría la llamada AJAX al servidor
                alert('Función de eliminar juego en desarrollo');
                
                console.log(`Delete game ${id}`);
            }
        }
        
        // Mostrar notificación de éxito si es necesario
        @if(session('success'))
            alert('{{ session('success') }}');
        @endif
        
        @if(session('error'))
            alert('{{ session('error') }}');
        @endif
    </script>
</body>
</html>