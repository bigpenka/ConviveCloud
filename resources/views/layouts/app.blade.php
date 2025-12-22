<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConviveCloud - @yield('htmlheader_title', 'Dashboard')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* CONFIGURACIÓN GLOBAL DEL TEMA OSCURO */
        body {
            background-color: #0f172a; /* Fondo ultra oscuro */
            color: #f1f5f9;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        /* Barra Superior (Navbar) */
        .main-header {
            background-color: #1e293b;
            border-bottom: 1px solid #334155;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Contenedor de contenido */
        .content-wrapper {
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }

        /* Personalización de Tarjetas para todo el sistema */
        .card {
            background-color: #1e293b !important;
            border: 1px solid #334155 !important;
            border-radius: 12px !important;
            color: #f1f5f9 !important;
        }

        /* Inputs y Tablas globales */
        .table { color: #cbd5e1; }
        .table thead th { background-color: #334155; border: none; color: white; }
        .table td { border-top: 1px solid #334155; }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="logo">
            <strong style="font-size: 1.2rem; color: #38bdf8;">ConviveCloud</strong>
        </div>
        <div class="user-menu">
            <span>{{ Auth::user()->name ?? 'Usuario' }} <i class="fa fa-angle-down"></i></span>
        </div>
    </header>

    <main class="content-wrapper">
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>