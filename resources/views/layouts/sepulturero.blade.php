{{-- resources/views/layouts/sepulturero.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'El Sepulturero Juan - Sistema de Gestión Funeraria')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS con Vite -->
    @vite(['resources/js/app.js'])
    @vite(['resources/css/app.css'])


</head>

<body>
    <nav class="navbar">
        <div class="nav-container">
            <!-- Logo con menú desplegable -->
            <div class="logo-container">
                <div class="logo-main">
                    <i class="fas fa-cross"></i>
                    <span>El Sepulturero Juan</span>
                    <i class="fas fa-chevron-down"></i>
                </div>

                <!-- Menú desplegable que aparece al hacer hover -->
                <div class="logo-dropdown-menu">
                    <div class="dropdown-header">MÓDULOS DEL SISTEMA</div>

                    <!-- Módulo Dashboard -->
                    @auth
                        <a href="{{ route('sepulturero.dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    @endauth

                    <!-- Módulo Usuarios (solo si tiene permiso) -->
                    @auth
                        @if (auth()->user()->tienePermiso('ver_usuarios'))
                            <a href="{{ route('admin.usuarios.index') }}">
                                <i class="fas fa-users"></i> Usuarios
                            </a>
                        @endif
                    @endauth

                    <!-- Módulo Ventas (Clientes + Contratos) -->
                    @auth
                        @if (auth()->user()->tienePermiso('ver_clientes') || auth()->user()->tienePermiso('ver_contratos'))
                            <div class="dropdown-header" style="margin-top: 0.5rem;">VENTAS</div>
                            @if (auth()->user()->tienePermiso('ver_clientes'))
                                <a href="{{ route('admin.clientes.index') }}">
                                    <i class="fas fa-user"></i> Clientes
                                </a>
                            @endif
                            @if (auth()->user()->tienePermiso('ver_contratos'))
                                <a href="{{ route('admin.contratos.index') }}">
                                    <i class="fas fa-file-contract"></i> Contratos
                                </a>
                            @endif
                        @endif
                    @endauth

                    <!-- Módulo Inhumaciones -->
                    @auth
                        @if (auth()->user()->tienePermiso('ver_inhumaciones'))
                            <div class="dropdown-header" style="margin-top: 0.5rem;">OPERACIONES</div>
                            <a href="{{ route('admin.inhumaciones.index') }}">
                                <i class="fas fa-dove"></i> Inhumaciones
                            </a>
                        @endif
                        @if (auth()->user()->tienePermiso('ver_espacios'))
                            <a href="{{ route('admin.espacios.index') }}">
                                <i class="fas fa-dove"></i> Espacios
                            </a>
                        @endif
                    @endauth

                    <!-- Módulo Pagos -->
                    @auth
                        @if (auth()->user()->tienePermiso('ver_pagos'))
                            <a href="{{ route('admin.pagos.index') }}">
                                <i class="fas fa-dollar-sign"></i> Pagos
                            </a>
                        @endif
                    @endauth

                    <!-- Separador y Reportes -->
                    @auth
                        @if (auth()->user()->tienePermiso('ver_reportes'))
                            <div class="dropdown-header" style="margin-top: 0.5rem;">REPORTES</div>
                            <a href="{{ route('admin.reportes.index') }}">
                                <i class="fas fa-chart-bar"></i> Reportes
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Menú de usuario / Autenticación -->
            @auth
                <div id="userInfoBtn" class="user-info-clickable">
                    <div class="user-info">
                        <span>{{ Auth::user()->name }}</span>
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    </div>
                </div>
            @else
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn-login-navbar">
                        <i class="fas fa-sign-in-alt"></i> Iniciar sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn-register-navbar">
                        <i class="fas fa-user-plus"></i> Registrarse
                    </a>
                </div>
            @endauth
        </div>
    </nav>

    <main class="main-content">
        @if (session('success'))
            <div class="alert alert-success"
                style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger"
                style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} El Sepulturero Juan - Sistema de Gestión Funeraria. Todos los derechos
            reservados.</p>
        <p style="margin-top: 0.5rem; font-size: 0.9rem;">Sistema de información para la gestión de contratos,
            inhumaciones, mantenimiento y ventas</p>
    </footer>

    @include('layouts.usuario-modal')
</body>

</html>
