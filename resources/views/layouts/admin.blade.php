{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    {{-- CSS --}}
    @vite(['resources/css/adminlte-cementerio.css', 'resources/js/app.js'])
    
    {{-- Font Awesome (opcional, para iconos) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        {{-- SIDEBAR --}}
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">🌿</div>
                <h3>Cementerio Paz</h3>
                <small>Sistema de Gestión</small>
            </div>
            
            <ul class="sidebar-nav">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                
                {{-- Registros --}}
                <li class="nav-item has-submenu {{ request()->routeIs('cementerio.*') ? 'open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-book"></i>
                        <span class="nav-text">Registros</span>
                    </a>
                    <ul class="submenu">
                        <li class="nav-item">
                            <a href="{{ route('cementerio.registro') }}" class="nav-link">
                                <i class="fas fa-plus"></i>
                                <span class="nav-text">Nuevo registro</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"> {{-- route('cementerio.lista') --}}
                                <i class="fas fa-list"></i>
                                <span class="nav-text">Lista de difuntos</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                {{-- Mapa --}}
                <li class="nav-item">
                    <a href="#{{-- route('cementerio.mapa') --}}" class="nav-link {{ request()->routeIs('cementerio.mapa') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="nav-text">Mapa del cementerio</span>
                        <span class="nav-badge">Nuevo</span>
                    </a>
                </li>
                
                {{-- Consultas --}}
                <li class="nav-item">
                    <a href="{{ route('cementerio.consultas') }}" class="nav-link {{ request()->routeIs('cementerio.consultas') ? 'active' : '' }}">
                        <i class="fas fa-search"></i>
                        <span class="nav-text">Consultas</span>
                    </a>
                </li>
                
                {{-- Mantenimiento --}}
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link">
                        <i class="fas fa-tools"></i>
                        <span class="nav-text">Mantenimiento</span>
                    </a>
                    <ul class="submenu">
                        <li class="nav-item">
                            <a href="#{{-- route('mantenimiento.programar') --}}" class="nav-link">
                                <i class="fas fa-calendar"></i>
                                Programar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#{{-- route('mantenimiento.historial') --}}" class="nav-link">
                                <i class="fas fa-history"></i>
                                Historial
                            </a>
                        </li>
                    </ul>
                </li>
                
                {{-- Reportes --}}
                <li class="nav-item">
                    <a href="#{{-- route('reportes') --}}" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span class="nav-text">Reportes</span>
                    </a>
                </li>
                
                {{-- Configuración --}}
                <li class="nav-item">
                    <a href="#{{-- route('configuracion') --}}" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span class="nav-text">Configuración</span>
                    </a>
                </li>
            </ul>
        </aside>
        
        {{-- CONTENIDO PRINCIPAL --}}
        <div class="content-wrapper" id="contentWrapper">
            {{-- NAVBAR --}}
            <nav class="navbar">
                <div class="navbar-left">
                    <button class="btn-toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="breadcrumb">
                        @section('breadcrumb')
                            <a href="{{ url('/') }}">Inicio</a>
                            @hasSection('page')
                                <span>/</span>
                                <span>@yield('page')</span>
                            @endif
                        @show
                    </div>
                </div>
                
                <div class="navbar-right">
                    {{-- Notificaciones --}}
                    <div class="nav-icon">
                        <i class="far fa-bell"></i>
                        <span class="badge-notification">3</span>
                    </div>
                    
                    {{-- Mensajes --}}
                    <div class="nav-icon">
                        <i class="far fa-envelope"></i>
                    </div>
                    
                    {{-- Usuario --}}
                    <div class="user-menu">
                        <div class="user-avatar">
                            <span>AD</span>
                        </div>
                        <div class="user-info">
                            <span class="user-name">Admin User</span>
                            <span class="user-role">Administrador</span>
                        </div>
                        <div class="dropdown-menu">
                            <a href="#{{-- route('perfil') --}}" class="dropdown-item">
                                <i class="fas fa-user"></i> Mi perfil
                            </a>
                            <a href="#{{-- route('configuracion') --}}" class="dropdown-item">
                                <i class="fas fa-cog"></i> Configuración
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" style="width:100%">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            
            {{-- MAIN CONTENT --}}
            <main class="main-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
            
            {{-- FOOTER --}}
            <footer class="footer">
                <p>&copy; {{ date('Y') }} Cementerio Jardín de la Paz. Todos los derechos reservados.</p>
            </footer>
        </div>
    </div>
    
    {{-- JavaScript --}}
    <script src="{{ asset('js/admin-cemeterio.js') }}"></script>
    @stack('scripts')
</body>
</html>