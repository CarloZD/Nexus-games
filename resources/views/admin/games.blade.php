<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Juegos - Nexus Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin-games.css') }}">
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
                                    <span class="game-date">{{ $game->created_at->format('d/m/Y') }}</span>
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