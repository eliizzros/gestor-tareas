<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - TaskMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: #fafaf9;
            color: #1c1917;
            font-family: 'Space Grotesk', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navegación arriba del todo */
        .top-navbar {
            width: 100%;
            background-color: #ffffff;
            border-bottom: 1px solid #e7e5e4;
            padding: 1rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-links-left a {
            color: #57534e;
            text-decoration: none;
            font-weight: 600;
            margin-right: 1.75rem;
            font-size: 0.95rem;
            transition: color 0.15s;
        }
        .nav-links-left a:hover { color: #d97706; }

        .btn-sign-up {
            color: #1c1917;
            border: 1.5px solid #d6d3d1;
            background-color: #ffffff;
            padding: 0.45rem 1.1rem;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 0.6rem;
            transition: all 0.2s;
        }
        .btn-sign-up:hover {
            border-color: #a8a29e;
            background-color: #f5f5f4;
            color: #1c1917;
        }

        .btn-log-in {
            background-color: #d97706;
            color: #ffffff;
            padding: 0.5rem 1.25rem;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 3px 10px rgba(217, 119, 6, 0.25);
            transition: all 0.2s;
        }
        .btn-log-in:hover {
            background-color: #b45309;
            color: #ffffff;
        }

        /* Contenido Central Hero */
        .hero-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }
        .hero-card {
            background-color: #ffffff;
            border: 1px solid #e7e5e4;
            border-radius: 24px;
            padding: 3.5rem 4rem;
            max-width: 780px;
            width: 100%;
            box-shadow: 0 12px 30px -10px rgba(0,0,0,0.05);
        }
        .welcome-title {
            font-size: 3.8rem;
            font-weight: 700;
            color: #1c1917;
            line-height: 1.1;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }
        .welcome-desc {
            font-size: 1.15rem;
            color: #78716c;
            margin-bottom: 2.5rem;
            max-width: 520px;
        }
        .cta-group {
            display: flex;
            gap: 1rem;
        }
    </style>
</head>
<body>

    <!-- Navegación pegada arriba -->
    <header class="top-navbar">
        <nav class="nav-links-left">
            <a href="<?= base_url(); ?>">Home</a>
            <a href="?lang=en">English</a>
            <a href="?lang=es">Español</a>
        </nav>
        <div class="nav-actions-right">
            <a href="<?= base_url('register'); ?>" class="btn-sign-up">Sign up</a>
            <a href="<?= base_url('login'); ?>" class="btn-log-in">Log in</a>
        </div>
    </header>

    <!-- Sección de Bienvenida -->
    <main class="hero-section">
        <div class="hero-card">
            <h1 class="welcome-title">Welcome</h1>
            <p class="welcome-desc">Gestor independiente de actividades con arquitectura renovada.</p>
            
            <div class="cta-group">
                <a href="<?= base_url('login'); ?>" class="btn-log-in">Iniciar Sesión</a>
                <a href="<?= base_url('register'); ?>" class="btn-sign-up">Registrarse</a>
            </div>
        </div>
    </main>

</body>
</html>
