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
        <div class="logo" style="display:flex; align-items:center; gap:10px; height:48px;">
    <img src="{{ asset('img/logo.png') }}" alt="ConviveCloud"
         style="width:48px; height:48px; object-fit:contain; flex-shrink:0;">
    <strong style="font-size: 1.2rem; color: #38bdf8; line-height:1;">ConviveCloud</strong>
</div>

        <div class="user-menu" style="position: relative;">
    <div id="userToggle" style="cursor:pointer; display:flex; align-items:center; gap:6px; color:#e2e8f0;">
        <span>{{ Auth::user()->name ?? 'Usuario' }}</span>
        <i class="fa fa-angle-down"></i>
    </div>
    <div id="userDropdown" style="display:none; position:absolute; right:0; top:38px; background:#0f172a; border:1px solid #334155; border-radius:10px; min-width:180px; box-shadow:0 10px 30px rgba(0,0,0,0.35); z-index:1000;">
        <div style="padding:10px 12px; border-bottom:1px solid #334155; color:#cbd5e1; font-size:13px;">
            {{ Auth::user()->name ?? 'Usuario' }}
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" style="width:100%; background:none; border:none; color:#e2e8f0; text-align:left; padding:10px 12px; font-size:13px; cursor:pointer;">
                <i class="fa fa-sign-out"></i> Cerrar sesión
            </button>
        </form>
    </div>
</div>
    </header>

    <main class="content-wrapper">
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>\
    <script>
    $(function(){
        const $toggle = $('#userToggle');
        const $menu = $('#userDropdown');
        $toggle.on('click', function(){
            $menu.toggle();
        });
        $(document).on('click', function(e){
            if(!$(e.target).closest('.user-menu').length){
                $menu.hide();
            }
        });
    });
</script>

    @yield('scripts')
</body>
</html>