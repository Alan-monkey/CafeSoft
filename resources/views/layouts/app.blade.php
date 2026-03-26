<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Café Sofft - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --cafe-oscuro: #8B4513;
            --cafe-medio: #A0522D;
            --cafe-claro: #D2691E;
            --beige: #F5F5DC;
            --crema: #FFF8DC;
            --marron: #5D4037;
            --dorado: #D4AF37;
            --gris-claro: #f8f9fa;
            --sombra-suave: 0 8px 30px rgba(0,0,0,0.12);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, var(--beige) 0%, var(--crema) 100%);
            color: var(--marron);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== LAYOUT CON SIDEBAR IZQUIERDO ===== */
        .layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR IZQUIERDO ===== */
        .sidebar-left {
            width: 280px;
            background: linear-gradient(145deg, var(--cafe-oscuro) 0%, var(--cafe-medio) 100%);
            box-shadow: 5px 0 30px rgba(0,0,0,0.2);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar-left.collapsed {
            width: 80px;
        }

        /* Logo en sidebar */
        .sidebar-brand {
            padding: 25px 20px;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: white;
        }

        .brand-icon {
            font-size: 2.5rem;
            color: var(--dorado);
            animation: rotate-slow 10s infinite linear;
            min-width: 50px;
            text-align: center;
        }

        .brand-text-sidebar {
            display: flex;
            flex-direction: column;
            transition: opacity 0.2s ease;
        }

        .sidebar-left.collapsed .brand-text-sidebar {
            display: none;
        }

        .brand-name-sidebar {
            font-weight: 700;
            font-size: 1.3rem;
            color: white;
            line-height: 1.2;
        }

        .brand-sub-sidebar {
            font-size: 0.75rem;
            color: var(--dorado);
            opacity: 0.9;
        }

        /* Perfil de usuario en sidebar */
        .sidebar-user {
            padding: 20px;
            background: rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-user:hover {
            background: rgba(0,0,0,0.2);
        }

        .user-avatar-sidebar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--dorado), #F4C542);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--cafe-oscuro);
            font-weight: 700;
            font-size: 1.3rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            min-width: 50px;
        }

        .user-info-sidebar {
            display: flex;
            flex-direction: column;
            color: white;
            transition: opacity 0.2s ease;
        }

        .sidebar-left.collapsed .user-info-sidebar {
            display: none;
        }

        .user-name-sidebar {
            font-weight: 600;
            font-size: 1rem;
        }

        .user-role-sidebar {
            font-size: 0.8rem;
            opacity: 0.8;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .user-role-sidebar i {
            color: var(--dorado);
        }

        /* Menú de navegación */
        .sidebar-menu {
            flex: 1;
            padding: 10px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 15px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            margin-bottom: 5px;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }

        .menu-item.active {
            background: linear-gradient(135deg, var(--dorado), #F4C542);
            color: var(--cafe-oscuro);
            font-weight: 600;
        }

        .menu-item i {
            font-size: 1.3rem;
            min-width: 30px;
            text-align: center;
        }

        .menu-text {
            transition: opacity 0.2s ease;
        }

        .sidebar-left.collapsed .menu-text {
            display: none;
        }

        /* Badge para notificaciones en el menú */
        .badge-menu {
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            margin-left: auto;
            min-width: 18px;
            text-align: center;
            animation: pulse 2s infinite;
        }

        .sidebar-left.collapsed .badge-menu {
            position: absolute;
            top: 5px;
            right: 5px;
            margin-left: 0;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Footer del sidebar */
        .sidebar-footer {
            padding: 20px;
            border-top: 2px solid rgba(255,255,255,0.1);
        }

        .logout-btn-sidebar {
            width: 100%;
            padding: 12px;
            background: rgba(220,53,69,0.2);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn-sidebar:hover {
            background: #dc3545;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220,53,69,0.3);
        }

        .sidebar-left.collapsed .logout-btn-sidebar span {
            display: none;
        }

        /* Botón para colapsar/expandir */
        .sidebar-toggle {
            position: absolute;
            right: -15px;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            border: 2px solid var(--cafe-oscuro);
            color: var(--cafe-oscuro);
            z-index: 1001;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: var(--cafe-oscuro);
            color: white;
            transform: translateY(-50%) scale(1.1);
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            margin-left: 280px;
            transition: margin-left 0.3s ease;
            width: calc(100% - 280px);
        }

        .main-content.expanded {
            margin-left: 80px;
            width: calc(100% - 80px);
        }

        /* Elementos decorativos de café */
        .coffee-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .coffee-bean {
            position: absolute;
            width: 20px;
            height: 10px;
            background: var(--cafe-oscuro);
            border-radius: 50%;
            opacity: 0.1;
            animation: float 15s infinite linear;
        }

        .bean-1 {
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .bean-2 {
            top: 30%;
            right: 10%;
            animation-delay: 3s;
        }

        .bean-3 {
            bottom: 20%;
            left: 15%;
            animation-delay: 6s;
        }

        .bean-4 {
            bottom: 40%;
            right: 5%;
            animation-delay: 9s;
        }

        .bean-5 {
            top: 60%;
            left: 8%;
            animation-delay: 12s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.1;
            }
            50% {
                opacity: 0.2;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0.1;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar-left {
                left: -280px;
            }
            
            .sidebar-left.mobile-open {
                left: 0;
            }
            
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            .footer {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            .mobile-menu-toggle {
                display: block;
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                background: var(--cafe-oscuro);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                box-shadow: 0 4px 10px rgba(0,0,0,0.2);
                z-index: 1002;
                cursor: pointer;
                border: 2px solid var(--dorado);
            }
        }

        /* Resto de estilos originales */
        .inicio {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 3rem 1rem;
        }

        .inicio .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 1200px;
            width: 100%;
        }

        @media (min-width: 768px) {
            .inicio .content {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .inicio .text {
                flex: 1;
                text-align: left;
                padding-right: 3rem;
            }

            .inicio img {
                max-width: 45%;
                height: auto;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(139, 69, 19, 0.2);
            }
        }

        .inicio img:hover {
            transform: scale(1.03);
            transition: transform 0.3s ease;
        }

        .inicio h1 {
            color: var(--cafe-oscuro);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .inicio p {
            font-size: 1.1rem;
            line-height: 1.7;
            color: var(--marron);
            margin-bottom: 2rem;
        }

        .inicio button {
            padding: 12px 30px;
            background: linear-gradient(135deg, var(--cafe-oscuro) 0%, var(--cafe-medio) 100%);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(139, 69, 19, 0.3);
        }

        .inicio button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(139, 69, 19, 0.4);
        }

        .services {
            padding: 4rem 1rem;
            text-align: center;
            background: rgba(139, 69, 19, 0.05);
            border-radius: 15px;
            margin: 2rem 0;
        }

        .services h2 {
            color: var(--cafe-oscuro);
            margin-bottom: 1.5rem;
            font-weight: 700;
            font-size: 2.2rem;
        }

        .services p {
            color: var(--marron);
            margin-bottom: 3rem;
            font-size: 1.1rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .gallery-item {
            text-align: center;
            max-width: 300px;
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-item img:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .gallery-description {
            margin-top: 15px;
            font-size: 1rem;
            color: var(--marron);
            font-weight: 500;
        }

        .additional-info {
            padding: 4rem 2rem;
            background: linear-gradient(135deg, var(--cafe-claro) 0%, var(--cafe-medio) 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(139, 69, 19, 0.2);
            margin: 2rem 0;
            position: relative;
            overflow: hidden;
        }

        .list .list-group-item {
            color: var(--beige);
            background-color: rgba(93, 64, 55, 0.7);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 8px;
            margin-bottom: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .list .list-group-item:hover {
            background-color: rgba(93, 64, 55, 0.9);
            transform: translateX(5px);
        }

        .footer {
            background: linear-gradient(135deg, var(--cafe-oscuro) 0%, var(--marron) 100%);
            color: var(--beige);
            padding: 2rem 1rem;
            text-align: center;
            margin-left: 280px;
            width: calc(100% - 280px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .footer.expanded {
            margin-left: 80px;
            width: calc(100% - 80px);
        }

        .map-container {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Botón móvil */
        .mobile-menu-toggle {
            display: none;
        }
        /* Mejoras para móvil */
/* Botón móvil - CORREGIDO */
.mobile-menu-toggle {
    display: none !important;
    position: fixed;
    bottom: 30px; /* Aumentado de 20px a 30px */
    left: 65%;
    transform: translateX(-50%);
    width: 45px; /* Ligeramente más grande */
    height: 45px;
    background: linear-gradient(135deg, var(--cafe-oscuro), var(--cafe-medio));
    color: white;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
    font-size: 2rem; /* Ícono más grande */
    box-shadow: 0 6px 25px rgba(139, 69, 19, 0.5);
    z-index: 1002;
    cursor: pointer;
    border: 3px solid var(--dorado);
    transition: all 0.3s ease;
    animation: pulse-mobile 2s infinite;
    top: 15px; /* Asegura que el botón esté en la parte inferior */
}

.mobile-menu-toggle:hover {
    transform: translateX(-50%) scale(1.1) rotate(90deg);
    box-shadow: 0 8px 30px rgba(212, 175, 55, 0.6);
}

@keyframes pulse-mobile {
    0%, 100% { transform: translateX(-50%) scale(1); }
    50% { transform: translateX(-50%) scale(1.05); }
}

/* Overlay para móvil */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(3px);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.sidebar-overlay.active {
    display: block;
    opacity: 1;
}

/* Responsive mejorado - CORREGIDO */
@media (max-width: 768px) {
    .sidebar-left {
        left: -280px;
        box-shadow: none;
        transition: left 0.3s ease, box-shadow 0.3s ease;
    }
    
    .sidebar-left.mobile-open {
        left: 0;
        box-shadow: 5px 0 30px rgba(0, 0, 0, 0.3);
    }
    
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }
    
    .footer {
        margin-left: 0 !important;
        width: 100% !important;
    }
    
    /* Mostrar botón móvil SOLO en móvil */
    .mobile-menu-toggle {
        display: flex !important;
    }
    
    .sidebar-overlay.active {
        display: block;
    }
    
    /* Ocultar botón de colapsar en móvil */
    .sidebar-toggle {
        display: none;
    }
    
    /* Ajustes para mejor usabilidad en móvil */
    .menu-item {
        padding: 15px 20px;
        font-size: 1.1rem;
    }
    
    .sidebar-user {
        padding: 15px 20px;
    }
    
    .brand-name-sidebar {
        font-size: 1.4rem;
    }
}

/* Animación para el botón cuando el menú está abierto */
.mobile-menu-toggle.open {
    background: linear-gradient(135deg, #dc3545, #c82333);
    transform: translateX(-50%) rotate(90deg);
    border-color: white;
    animation: none;
}
    </style>
  </head>
  <body>
    <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
    <i class="fas fa-bars"></i>
</div>

    <!-- Elementos decorativos de café -->
    <div class="coffee-elements">
        <div class="coffee-bean bean-1"></div>
        <div class="coffee-bean bean-2"></div>
        <div class="coffee-bean bean-3"></div>
        <div class="coffee-bean bean-4"></div>
        <div class="coffee-bean bean-5"></div>
    </div>

    @php
        use App\Models\Inventario;
        
        $usuario = Auth::guard('usuarios')->user();
        $nombreUsuario = $usuario ? $usuario->nombre ?? 'Usuario' : 'Invitado';
        $emailUsuario = $usuario ? $usuario->email ?? '' : '';
        $iniciales = '';
        if ($usuario && isset($usuario->nombre)) {
            $nombres = explode(' ', $usuario->nombre);
            foreach ($nombres as $n) {
                if (!empty($n)) $iniciales .= strtoupper(substr($n, 0, 1));
            }
        }
        if (empty($iniciales)) $iniciales = 'U';
        $rol = ($usuario && $usuario->user_tipo == '0') ? 'Empleado' : 'Cliente';
        
        // Contar productos con bajo stock para el badge
        $bajo_stock_count = 0;
        if ($usuario && $usuario->user_tipo == '0') {
            try {
                $bajo_stock_count = Inventario::whereRaw('stock_actual <= stock_minimo')->count();
            } catch (\Exception $e) {
                $bajo_stock_count = 0;
            }
        }
    @endphp

    <div class="layout-wrapper">
        <!-- Sidebar Izquierdo -->
        <div class="sidebar-left" id="sidebar">
            <!-- Botón para colapsar/expandir (solo desktop) -->
            <div class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-chevron-left" id="toggleIcon"></i>
            </div>

            <!-- Logo -->
            <div class="sidebar-brand">
                <a href="#" class="brand-link">
                    <div class="brand-icon">
                        <i class="fas fa-coffee"></i>
                    </div>
                    <div class="brand-text-sidebar">
                        <span class="brand-name-sidebar">Café Sofft</span>
                        <span class="brand-sub-sidebar">Sistema de Gestión</span>
                    </div>
                </a>
            </div>

            @if($usuario)
            <!-- Perfil de usuario -->
            <div class="sidebar-user">
                <div class="user-avatar-sidebar">
                    {{ $iniciales }}
                </div>
                <div class="user-info-sidebar">
                    <span class="user-name-sidebar">{{ $nombreUsuario }}</span>
                    <span class="user-role-sidebar">
                        <i class="fas fa-crown"></i> {{ $rol }}
                    </span>
                </div> 
            </div>
            @endif

            <!-- Menú de navegación -->
            <div class="sidebar-menu">
                @if ($usuario && $usuario->user_tipo == '0')
                    <!-- Menú Empleado -->
                    <a href="{{ URL('/libros/inicio') }}" class="menu-item {{ request()->is('libros/inicio') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span class="menu-text">Inicio</span>
                    </a>
                    <a href="/productos/crear" class="menu-item {{ request()->is('productos/crear') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i>
                        <span class="menu-text">Crear Producto</span>
                    </a>
                    <a href="{{ route('ventas.index') }}" class="menu-item {{ request()->is('ventas') ? 'active' : '' }}">
    <i class="fas fa-receipt"></i>
    <span class="menu-text">Ver Ventas</span>
</a>
                    <a href="/productos/leer" class="menu-item {{ request()->is('productos/leer') ? 'active' : '' }}">
                        <i class="fas fa-list"></i>
                        <span class="menu-text">Ver Productos</span>
                    </a>
                    
                    <!-- ===== NUEVA OPCIÓN DE INVENTARIO PARA EMPLEADOS ===== -->
                    <a href="/inventario" class="menu-item {{ request()->is('inventario') ? 'active' : '' }}">
                        <i class="fas fa-warehouse"></i>
                        <span class="menu-text">Inventario</span>
                        @if($bajo_stock_count > 0)
                            <span class="badge-menu">{{ $bajo_stock_count }}</span>
                        @endif
                    </a>
                    
                    <a href="/productos/eliminar" class="menu-item {{ request()->is('productos/eliminar') ? 'active' : '' }}">
                        <i class="fas fa-trash-alt"></i>
                        <span class="menu-text">Eliminar Productos</span>
                    </a>
                    <a href="{{ URL('/libros/registrarse') }}" class="menu-item {{ request()->is('libros/registrarse') ? 'active' : '' }}">
                        <i class="fas fa-user-plus"></i>
                        <span class="menu-text">Registrar Usuario</span>
                    </a>
                    <a href="{{ URL('/carrito') }}" class="menu-item {{ request()->is('carrito') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="menu-text">Carrito de Compras</span>
                    </a>
                    <a href="{{ URL('/backups') }}" class="menu-item {{ request()->is('backups') ? 'active' : '' }}">
                        <i class="fas fa-database"></i>
                        <span class="menu-text">Respaldos</span>
                    </a>
                @elseif($usuario)
                    <!-- Menú Cliente -->
                    <a href="/productos/leer" class="menu-item {{ request()->is('productos/leer') ? 'active' : '' }}">
                        <i class="fas fa-list"></i>
                        <span class="menu-text">Ver Productos</span>
                    </a>
                    
                    <!-- ===== NUEVA OPCIÓN DE INVENTARIO PARA CLIENTE (SOLO VER) ===== -->
                    <a href="/inventario/cliente" class="menu-item {{ request()->is('inventario/cliente') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i>
                        <span class="menu-text">Disponibilidad</span>
                    </a>
                    
                    <a href="{{ URL('/carrito') }}" class="menu-item {{ request()->is('carrito') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="menu-text">Carrito de Compras</span>
                    </a>
                @else
                    <!-- Menú Invitado -->
                    <a href="{{ route('login') }}" class="menu-item">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="menu-text">Iniciar Sesión</span>
                    </a>
                    <a href="/productos/leer" class="menu-item">
                        <i class="fas fa-list"></i>
                        <span class="menu-text">Ver Productos</span>
                    </a>
                    
                @endif
            </div>

            @if($usuario)
<!-- Footer con logout -->
<div class="sidebar-footer">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout-btn-sidebar" type="submit">
            <i class="fas fa-sign-out-alt"></i>
            <span>Cerrar sesión</span>
        </button>
    </form>
</div>
@endif
        </div>

        <!-- Contenido principal -->
        <div class="main-content" id="mainContent">
            <!-- Botón móvil (solo visible en mobile) -->
            <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </div>

            <div class="container">
                @yield('content')
                
                <!-- Sección de bienvenida -->
                <section class="inicio">
                    <div class="content">
                        <div class="text">
                            <h1>Bienvenido a Café Sofft</h1>
                            <p>Disfruta de la mejor experiencia en gestión de cafetería con nuestro sistema integral. Desde el control de inventario hasta la gestión de pedidos, tenemos todo lo que necesitas para hacer crecer tu negocio.</p>
                            <button>Descubre Más</button>
                        </div>
                        <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Café Sofft">
                    </div>
                </section>

                <!-- Sección de servicios -->
                <section class="services">
                    <h2>Nuestros Servicios</h2>
                    <p>Ofrecemos una amplia gama de servicios para gestionar eficientemente tu cafetería y brindar la mejor experiencia a tus clientes.</p>
                    <div class="grid">
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Gestión de Inventario">
                            <p class="gallery-description">Gestión de Inventario</p>
                        </div>
                        <div class="gallery-item">
                            <img src="https://images.unsplash.com/photo-1511537190424-bbbab87ac5eb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Control de Pedidos">
                            <p class="gallery-description">Control de Pedidos</p>
                        </div>
                    </div>
                </section>

                <!-- Información adicional -->
                <section class="additional-info">
                    <h2>Características del Sistema</h2>
                    <div class="list">
                        <div class="list-group">
                            <div class="list-group-item">
                                <i class="fas fa-check-circle me-2"></i> Gestión completa de productos
                            </div>
                            <div class="list-group-item">
                                <i class="fas fa-check-circle me-2"></i> Control de inventario en tiempo real
                            </div>
                            <div class="list-group-item">
                                <i class="fas fa-check-circle me-2"></i> Sistema de pedidos eficiente
                            </div>
                            <div class="list-group-item">
                                <i class="fas fa-check-circle me-2"></i> Reportes y análisis detallados
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Footer -->
            <footer class="footer" id="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Universidad Tecnológica del Valle de Toluca</h5>
                            <p class="mb-1">Carretera del Departamento del D.F. km 7.5</p>
                            <p class="mb-1">Col. Santa María Atarasquillo, Lerma, Estado de México. C.P. 52044</p>
                            <p class="mb-3"><i class="fas fa-phone"></i> Tel: 728 6884444 / 728 6884396</p>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="map-container" style="border-radius: 8px; overflow: hidden; height: 200px;">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3765.625098134897!2d-99.51218892501902!3d19.301549242124833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cd8b6c84e08f25%3A0xf4083c2c5bf022f9!2sUniversidad%20Tecnol%C3%B3gica%20del%20Valle%20de%20Toluca!5e0!3m2!1ses!2smx!4v1749770800000!5m2!1ses!2smx" 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="row">
                        <div class="col-12 text-center">
                            <p class="mb-0 text-muted">
                                &copy; {{ date('Y') }} Sistema de Gestión. Proyecto Académico.
                            </p>
                            <small class="text-muted">
                                Desarrollado como parte de las actividades académicas de la UTVT.
                            </small>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    
    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const footer = document.getElementById('footer');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (!sidebar || !mainContent || !footer || !toggleIcon) return;
        
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
        footer.classList.toggle('expanded');
        
        if (sidebar.classList.contains('collapsed')) {
            toggleIcon.classList.remove('fa-chevron-left');
            toggleIcon.classList.add('fa-chevron-right');
        } else {
            toggleIcon.classList.remove('fa-chevron-right');
            toggleIcon.classList.add('fa-chevron-left');
        }
    }

    function toggleMobileMenu() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const mobileBtn = document.querySelector('.mobile-menu-toggle');
        
        // Validar que todos los elementos existan
        if (!sidebar || !overlay || !mobileBtn) return;
        
        sidebar.classList.toggle('mobile-open');
        overlay.classList.toggle('active');
        mobileBtn.classList.toggle('open');
        
        // Cambiar ícono del botón
        const icon = mobileBtn.querySelector('i');
        if (icon) {
            if (sidebar.classList.contains('mobile-open')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
                // Prevenir scroll del body
                document.body.style.overflow = 'hidden';
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
                document.body.style.overflow = '';
            }
        }
    }

    // Cerrar sidebar con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const mobileBtn = document.querySelector('.mobile-menu-toggle');
            
            if (!sidebar || !overlay || !mobileBtn) return;
            
            if (window.innerWidth <= 768 && sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                mobileBtn.classList.remove('open');
                
                const icon = mobileBtn.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
                document.body.style.overflow = '';
            }
        }
    });

    // Prevenir scroll del body cuando el menú móvil está abierto
    document.addEventListener('touchmove', function(e) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (window.innerWidth <= 768 && sidebar && sidebar.classList.contains('mobile-open')) {
            if (overlay && overlay.classList.contains('active')) {
                e.preventDefault();
            }
        }
    }, { passive: false });

    // Ajustar al cambiar tamaño de ventana
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const mobileBtn = document.querySelector('.mobile-menu-toggle');
        
        if (!sidebar || !overlay || !mobileBtn) return;
        
        if (window.innerWidth > 768) {
            if (sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                
                const icon = mobileBtn.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
                mobileBtn.classList.remove('open');
                document.body.style.overflow = '';
            }
        }
    });

    // Inicialización: asegurar que el overlay existe
    document.addEventListener('DOMContentLoaded', function() {
        // Crear overlay si no existe
        if (!document.querySelector('.sidebar-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            overlay.onclick = toggleMobileMenu;
            document.body.appendChild(overlay);
        }
    });
</script>
    
    @stack('scripts')  
</body>
</html>