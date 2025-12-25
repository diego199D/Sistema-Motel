<!DOCTYPE html>
<html lang="es" translate="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>@yield('titulo')</title>
</head>

<body>
    <header>
        <div class="header-usuario">
            <div class="hamburguesa" id="btn-menu">
                <span class="material-symbols-outlined" translate="no">menu</span>
            </div>
            <div class="usuario">
                <span class="material-symbols-outlined" translate="no">account_circle</span>
                <h3>Admin</h3>
            </div>
        </div>
    </header>
    <div class="contenedor">
        <aside>
            <div class="lateral">
                <h2>MOTEL MIL AMORES</h2>
                <div class="sidebar-item">
                    <span class="material-symbols-outlined" translate="no">speed</span>
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </div>
                <div class="sidebar-item">
                    <span class="material-symbols-outlined" translate="no">table_chart</span>
                    <a href="{{ route('planilla.index') }}">Planilla</a>
                </div>
                <div class="sidebar-item">
                    <span class="material-symbols-outlined" translate="no">work_history</span>
                    <a href="{{ route('planilla.historial') }}">Historial del dia</a>
                </div>
                <div class="sidebar-item">
                    <span class="material-symbols-outlined" translate="no">assignment_globe</span>
                    <a href="">Historial completo</a>
                </div>
                <div class="sidebar-item">
                    <span class="material-symbols-outlined" translate="no">bar_chart_4_bars</span>
                    <a href="">Reportes</a>
                </div>
                <div class="boton-cerrar-sesion">
                    <a href="">Cerrar Sesion</a>
                </div>
            </div>
        </aside>
        
        @yield('contenido')
    </div>
</body>

<script>
    const btnMenu = document.getElementById('btn-menu');
    const sidebar = document.querySelector('aside');

    btnMenu.addEventListener('click', () => {
        sidebar.classList.toggle('activo');
    });

    // Opcional: Cerrar si haces clic fuera del menú
    document.addEventListener('click', (event) => {
        if (!sidebar.contains(event.target) && !btnMenu.contains(event.target)) {
            sidebar.classList.remove('activo');
        }
    });
</script>


</html>