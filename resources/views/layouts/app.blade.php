<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- CSS files -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
    @stack('css')
</head>
<body>
    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-md navbar-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-brand navbar-brand-autodark">
                    <a href="{{ url('/') }}">
                        @include('components.logo')
                    </a>
                </div>
                
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <span class="nav-link-icon">
                                    <i class="ti ti-home"></i>
                                </span>
                                <span class="nav-link-title">Inicio</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                                <span class="nav-link-icon">
                                    <i class="ti ti-package"></i>
                                </span>
                                <span class="nav-link-title">Productos</span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="#">
                                            Lista de Productos
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            Categorías
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            Inventario
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="nav-link-icon">
                                    <i class="ti ti-shopping-cart"></i>
                                </span>
                                <span class="nav-link-title">Ventas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="nav-link-icon">
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="nav-link-title">Clientes</span>
                            </a>
                        </li>
                        @canany(['ver-usuarios', 'ver-roles', 'ver-permisos', 'gestionar-configuracion'])
                        <li class="nav-item dropdown {{ request()->is('configuracion*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#navbar-config" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                                <span class="nav-link-icon">
                                    <i class="ti ti-settings"></i>
                                </span>
                                <span class="nav-link-title">Configuración</span>
                            </a>
                            <div class="dropdown-menu {{ request()->is('configuracion*') ? 'show' : '' }}">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        @can('ver-usuarios')
                                        <a class="dropdown-item {{ request()->is('configuracion/usuarios*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                                                <i class="ti ti-users"></i>
                                            </span>
                                            Usuarios
                                        </a>
                                        @endcan
                                        
                                        @can('ver-roles')
                                        <a class="dropdown-item {{ request()->is('configuracion/roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                                                <i class="ti ti-shield-lock"></i>
                                            </span>
                                            Roles
                                        </a>
                                        @endcan
                                        
                                        @can('ver-permisos')
                                        <a class="dropdown-item {{ request()->is('configuracion/permisos*') ? 'active' : '' }}" href="{{ route('permisos.index') }}">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                                                <i class="ti ti-key"></i>
                                            </span>
                                            Permisos
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endcanany
                    </ul>
                </div>
            </div>
        </aside>
        
        <div class="page-wrapper">
            <!-- Header -->
            <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
                <div class="container-xl">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <div>
                            <form action="./" method="get" autocomplete="off" novalidate>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-search"></i>
                                    </span>
                                    <input type="text" value="" class="form-control" placeholder="Buscar..." aria-label="Search in website">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="navbar-nav flex-row ms-auto">
                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                                <i class="ti ti-bell fs-2"></i>
                                <span class="badge bg-red badge-notification"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Notificaciones</h3>
                                    </div>
                                    <div class="list-group list-group-flush list-group-hoverable">
                                        <div class="list-group-item">
                                            <div class="text-secondary">No hay notificaciones nuevas.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu" aria-expanded="false">
                                <div class="d-none d-xl-block pe-2 text-end">
                                    <div class="fw-bold text-uppercase">{{ auth()->user()->name }}</div>
                                    <div class="mt-1 small text-uppercase text-info fw-bold" style="font-size: 0.65rem;">
                                        {{ auth()->user()->getRoleNames()->first() ?? 'Usuario' }}
                                    </div>
                                </div>
                                <span class="avatar avatar-sm rounded-circle fw-bold text-info border border-info border-2 bg-white" 
                                      style="font-size: 0.7rem;">
                                    {{ collect(explode(' ', auth()->user()->name))->map(fn($n) => $n[0])->take(2)->join('') }}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow-sm border-0 p-3" style="min-width: 200px;">
                                <div class="text-center mb-3">
                                    <div class="fw-bold fs-3">{{ auth()->user()->name }}</div>
                                    <div class="text-secondary small">{{ auth()->user()->email }}</div>
                                    <div class="mt-2 text-uppercase text-secondary fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                                        ROLE: {{ auth()->user()->getRoleNames()->first() ?? 'ADMINISTRADOR' }}
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="post" id="logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2">
                                        <i class="ti ti-power text-danger me-2 fs-2"></i>
                                        <span class="fs-3">Cerrar Sesión</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                </div>
            </header>

            <div class="page-body">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>
            
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; {{ date('Y') }}
                                    <a href="." class="link-secondary">Bodega App</a>.
                                    Todos los derechos reservados.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Libs JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('js')
    
    @if(request()->is('configuracion/usuarios*'))
        <script src="{{ asset('js/users.js') }}"></script>
    @endif
    @if(request()->is('configuracion/roles*'))
        <script src="{{ asset('js/roles.js') }}"></script>
    @endif

    <script>
        // Global SweetAlert Handler for Flash Messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Hecho!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                confirmButtonColor: '#206bc4'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d63939'
            });
        @endif
    </script>
</body>
</html>
