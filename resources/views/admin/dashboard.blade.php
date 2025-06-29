<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Nexus</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            min-height: 100vh;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .welcome-text h1 {
            color: #333;
            margin-bottom: 5px;
        }
        
        .welcome-text p {
            color: #666;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #c0392b;
        }
        
        .content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .admin-badge {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border-left: 4px solid #e74c3c;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #e74c3c;
        }
        
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <div class="welcome-text">
                <h1>Panel de Administración</h1>
                <p>Bienvenido, {{ $user->name }}</p>
            </div>
            <div class="user-info">
                <span class="admin-badge">Administrador</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Cerrar Sesión</button>
                </form>
            </div>
        </div>
        
        <div class="content">
            <h2>Dashboard de Administrador</h2>
            <p>Desde aquí podrás gestionar usuarios, juegos, órdenes y más.</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_users'] }}</div>
                    <div class="stat-label">Usuarios Registrados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_admins'] }}</div>
                    <div class="stat-label">Administradores</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['recent_users']->count() }}</div>
                    <div class="stat-label">Usuarios Recientes</div>
                </div>
            </div>
            
            @if($stats['recent_users']->count() > 0)
            <div style="margin-top: 30px;">
                <h3>Usuarios Recientes</h3>
                <div style="margin-top: 15px;">
                    @foreach($stats['recent_users'] as $recent_user)
                        <div style="padding: 10px; border-bottom: 1px solid #eee;">
                            <strong>{{ $recent_user->name }}</strong> - {{ $recent_user->email }}
                            <small style="color: #666;">({{ $recent_user->created_at->diffForHumans() }})</small>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-top: 20px;">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>