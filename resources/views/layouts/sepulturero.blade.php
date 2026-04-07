{{-- resources/views/layouts/sepulturero.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'El Sepulturero Juan - Sistema de Gestión Funeraria')</title>
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS con Vite -->
    @vite(['resources/css/sepulturero.css'])
    
    @stack('styles')
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-cross"></i>
                <span>El Sepulturero Juan</span>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('sepulturero.dashboard') }}" class="@yield('active_dashboard', '')"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="{{ route('sepulturero.contratos') }}" class="@yield('active_contratos', '')"><i class="fas fa-file-contract"></i> Contratos</a></li>
                <li><a href="{{ route('sepulturero.inhumaciones') }}" class="@yield('active_inhumaciones', '')"><i class="fas fa-tombstone"></i> Inhumaciones</a></li>
                <li><a href="{{ route('sepulturero.mantenimiento') }}" class="@yield('active_mantenimiento', '')"><i class="fas fa-tools"></i> Mantenimiento</a></li>
                <li><a href="{{ route('sepulturero.ventas') }}" class="@yield('active_ventas', '')"><i class="fas fa-chart-line"></i> Ventas</a></li>
                <li><a href="{{ route('sepulturero.clientes') }}" class="@yield('active_clientes', '')"><i class="fas fa-users"></i> Clientes</a></li>
            </ul>
            <div class="user-info">
                <span>{{ Auth::user()->name ?? 'Administrador' }}</span>
                <div class="user-avatar">
                    {{ substr(Auth::user()->name ?? 'AJ', 0, 2) }}
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} El Sepulturero Juan - Sistema de Gestión Funeraria. Todos los derechos reservados.</p>
        <p style="margin-top: 0.5rem; font-size: 0.9rem;">Sistema de información para la gestión de contratos, inhumaciones, mantenimiento y ventas</p>
    </footer>

    <!-- JavaScript con Vite -->
    @vite(['resources/js/sepulturero.js'])
    
    @stack('scripts')
</body>
</html>