<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus - Gaming Store</title>
    <!-- Link al CSS externo -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>

    <!-- Hero Section -->
    <main class="hero">
        <h1>NEXUS</h1>
        <p>
            Tu destino definitivo para los mejores videojuegos. 
            Descubre, compra y conecta con una comunidad apasionada por el gaming. 
            Desde los últimos lanzamientos hasta los clásicos atemporales.
        </p>
        
        <div class="action-buttons">
            <a href="{{ route('login') }}" class="btn-primary"> Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="btn-secondary">Registrarse</a>
        </div>
    </main>

    <!-- Features Section -->
    <section class="features">
        <div class="feature-card">
            <div class="feature-icon">🛒</div>
            <h3>Tienda</h3>
            <p>
                Explora nuestro catálogo completo de videojuegos. 
                Encuentra los últimos lanzamientos y ofertas exclusivas 
                en todas las categorías gaming.
            </p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">💬</div>
            <h3>Foro</h3>
            <p>
                Únete a discusiones épicas sobre tus juegos favoritos. 
                Comparte estrategias, descubre secretos y conecta 
                con gamers de todo el mundo.
            </p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">👥</div>
            <h3>Comunidad</h3>
            <p>
                Forma parte de nuestra comunidad gaming. 
                Participa en eventos, torneos y actividades 
                exclusivas para miembros de Nexus.
            </p>
        </div>
    </section>

    <!-- Script JavaScript externo -->
    <script src="{{ asset('js/welcome.js') }}"></script>
</body>
</html>