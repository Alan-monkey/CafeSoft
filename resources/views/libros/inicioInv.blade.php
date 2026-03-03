@extends('layouts.app')
@section('content')

<div class="coffee-master">
    <!-- Hero Section Épico -->
    <div class="hero-epic">
        <div class="hero-bg-pattern"></div>
        <div class="container-fluid px-4 px-lg-5">
            <div class="row min-vh-100 align-items-center">
                <div class="col-lg-6 hero-text-col">
                    @if ($user)
                    <div class="welcome-chip">
                        <span class="chip-glow"></span>
                        <i class="fas fa-crown me-2"></i> Bienvenido de vuelta
                    </div>
                    <h1 class="hero-title">{{ $user->nombre }}</h1>
                    <div class="hero-role-badge">
                        <i class="fas fa-id-card me-2"></i>
                        {{ $user->user_tipo == '0' ? 'Empleado del Sistema' : 'Miembro Premium' }}
                    </div>
                    @else
                    <div class="welcome-chip">
                        <i class="fas fa-seedling me-2"></i> Invitado
                    </div>
                    <h1 class="hero-title">Bienvenido a CoffeSoft</h1>
                    @endif
                    <p class="hero-description">
                        La plataforma definitiva para transformar la gestión de tu cafetería.
                        Control total, análisis en tiempo real y una experiencia diseñada para amantes del café.
                    </p>
                    <div class="hero-cta-group">
                        <button class="cta-primary">
                            <i class="fas fa-rocket me-2"></i> Comenzar ahora
                        </button>
                        <button class="cta-secondary">
                            <i class="fas fa-play-circle me-2"></i> Ver demo
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 hero-visual-col">
                    <div class="coffee-showcase">
                        <div class="floating-card card-1">
                            <i class="fas fa-chart-line"></i>
                            <span>+45% ventas</span>
                        </div>
                        <div class="floating-card card-2">
                            <i class="fas fa-users"></i>
                            <span>128 clientes</span>
                        </div>
                        <div class="floating-card card-3">
                            <i class="fas fa-clock"></i>
                            <span>tiempo real</span>
                        </div>
                        <div class="main-cup">
                            <div class="steam-animation"></div>
                            <i class="fas fa-mug-hot"></i>
                        </div>
                        <div class="beans-spread">
                            <span></span><span></span><span></span><span></span><span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-bottom-wave">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white" />
            </svg>
        </div>
    </div>

    <!-- Sección Métricas / Stats -->
    <div class="metrics-section">
        <div class="container">
            <div class="metrics-grid">
                <div class="metric-item">
                    <div class="metric-value">150+</div>
                    <div class="metric-label">Cafeterías activas</div>
                </div>
                <div class="metric-item">
                    <div class="metric-value">12k</div>
                    <div class="metric-label">Pedidos gestionados</div>
                </div>
                <div class="metric-item">
                    <div class="metric-value">99.9%</div>
                    <div class="metric-label">Uptime garantizado</div>
                </div>
                <div class="metric-item">
                    <div class="metric-value">24/7</div>
                    <div class="metric-label">Soporte técnico</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Features - Premium Cards -->
    <div class="features-premium">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Todo lo que necesitas</span>
                <h2 class="section-title-modern">Gestiona tu cafetería <span class="text-gradient">como un experto</span></h2>
                <p class="section-subtitle-modern">Herramientas profesionales para el negocio del café</p>
            </div>
            <div class="features-grid-premium">
                <div class="feature-card-premium">
                    <div class="card-icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <h3>Gestión de Pedidos</h3>
                    <p>Sistema inteligente que organiza, prioriza y optimiza cada orden en tiempo real.</p>
                    <div class="card-stats">
                        <span><i class="fas fa-bolt"></i> 2.5s procesamiento</span>
                    </div>
                </div>
                <div class="feature-card-premium">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>CRM Especializado</h3>
                    <p>Historial completo, preferencias y programa de lealtad para tus clientes.</p>
                    <div class="card-stats">
                        <span><i class="fas fa-heart"></i> 89% retención</span>
                    </div>
                </div>
                <div class="feature-card-premium">
                    <div class="card-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3>Analytics Avanzado</h3>
                    <p>Reportes dinámicos, predicción de ventas y análisis de tendencias.</p>
                    <div class="card-stats">
                        <span><i class="fas fa-chart-line"></i> +35% eficiencia</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Showcase Visual - Galería Profesional -->
    <div class="showcase-moderno">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="showcase-text">
                        <span class="showcase-tag">Interfaz moderna</span>
                        <h2>Diseñado para <span class="text-gradient">resultados</span></h2>
                        <p>Paneles intuitivos, visualización de datos en tiempo real y una experiencia fluida en todos tus dispositivos.</p>
                        <ul class="showcase-list">
                            <li><i class="fas fa-check-circle"></i> Dashboard personalizable</li>
                            <li><i class="fas fa-check-circle"></i> Modo oscuro / claro</li>
                            <li><i class="fas fa-check-circle"></i> Actualizaciones en vivo</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="showcase-grid">
                        <div class="showcase-item large">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Dashboard">
                            <div class="showcase-overlay">
                                <span>Panel principal</span>
                            </div>
                        </div>
                        <div class="showcase-item small">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1115&q=80" alt="Analytics">
                            <div class="showcase-overlay">
                                <span>Analytics</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Final con modal incluido -->
    <div class="cta-final">
        <div class="container">
            <div class="cta-card">
                <h2>¿Listo para transformar tu cafetería?</h2>
                <p>Únete a cientos de dueños que ya confían en CoffeSoft</p>
                
            </div>
        </div>
    </div>

    <!-- Modal Mejorado -->
    <div class="modal fade premium-modal" id="backupModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-shield-alt me-2"></i>Respaldo seguro
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="modal-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <p class="modal-text">Generaremos un respaldo completo de la base de datos</p>
                    <div class="modal-features">
                        <span><i class="fas fa-check"></i> MongoDB</span>
                        <span><i class="fas fa-check"></i> Comprimido</span>
                        <span><i class="fas fa-check"></i> Encriptado</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn" onclick="window.location.href='/backup/mongo'">
                        <i class="fas fa-download me-2"></i> Descargar ahora
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== ESTILOS PREMIUM ===== */
    .coffee-master {
        background: #faf7f2;
        overflow-x: hidden;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    /* Hero Épico */
    .hero-epic {
        position: relative;
        background: linear-gradient(145deg, #4a2c1a 0%, #6b3f1f 100%);
        min-height: 100vh;
        color: white;
        overflow: hidden;
    }

    .hero-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(circle at 30% 40%, rgba(210, 175, 55, 0.15) 0%, transparent 30%),
            radial-gradient(circle at 70% 60%, rgba(210, 175, 55, 0.1) 0%, transparent 35%);
        pointer-events: none;
    }

    .welcome-chip {
        display: inline-flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1.5rem;
        border-radius: 40px;
        font-size: 0.95rem;
        border: 1px solid rgba(255, 215, 0, 0.3);
        margin-bottom: 1.5rem;
        position: relative;
    }

    .chip-glow {
        position: absolute;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(255, 215, 0, 0.3) 0%, transparent 70%);
        filter: blur(10px);
        top: 0;
        left: 0;
    }

    .hero-title {
        font-size: clamp(3rem, 8vw, 5rem);
        font-weight: 800;
        line-height: 1.1;
        background: linear-gradient(to right, #fff, #f5e6b3);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .hero-role-badge {
        background: rgba(210, 175, 55, 0.2);
        backdrop-filter: blur(8px);
        padding: 0.75rem 2rem;
        border-radius: 60px;
        display: inline-block;
        border: 1px solid rgba(255, 215, 0, 0.4);
        margin-bottom: 2rem;
    }

    .hero-description {
        font-size: 1.2rem;
        line-height: 1.7;
        opacity: 0.9;
        max-width: 500px;
        margin-bottom: 2.5rem;
    }

    .hero-cta-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .cta-primary {
        background: #D4AF37;
        color: #2c1a0b;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px -5px rgba(212, 175, 55, 0.4);
    }

    .cta-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -5px rgba(212, 175, 55, 0.6);
    }

    .cta-secondary {
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: 0.3s;
    }

    .cta-secondary:hover {
        border-color: #D4AF37;
        background: rgba(255, 255, 255, 0.05);
    }

    /* Coffee Showcase 3D */
    .coffee-showcase {
        position: relative;
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .main-cup {
        width: 150px;
        height: 150px;
        background: linear-gradient(145deg, #d7b686, #b38b5a);
        border-radius: 50% 50% 40% 40%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: #4a2c1a;
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.4), inset 0 -5px 10px rgba(0, 0, 0, 0.2);
        position: relative;
        animation: float-main 6s ease-in-out infinite;
    }

    .steam-animation {
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 20px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        filter: blur(8px);
        animation: steam-rise 3s infinite;
    }

    .floating-card {
        position: absolute;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: #4a2c1a;
        font-weight: 600;
        animation: float 5s ease-in-out infinite;
    }

    .card-1 {
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .card-2 {
        top: 50%;
        right: 5%;
        animation-delay: 1s;
    }

    .card-3 {
        bottom: 20%;
        left: 15%;
        animation-delay: 2s;
    }

    .beans-spread span {
        position: absolute;
        width: 30px;
        height: 15px;
        background: #3e2a1b;
        border-radius: 50%;
        opacity: 0.2;
        filter: blur(3px);
    }

    .beans-spread span:nth-child(1) {
        top: 70%;
        right: 20%;
        transform: rotate(30deg);
    }

    .beans-spread span:nth-child(2) {
        top: 30%;
        left: 5%;
        transform: rotate(-20deg);
    }

    .beans-spread span:nth-child(3) {
        bottom: 10%;
        right: 30%;
        transform: rotate(45deg);
    }

    /* Metrics */
    .metrics-section {
        padding: 3rem 0;
        background: white;
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        text-align: center;
    }

    .metric-value {
        font-size: 2.8rem;
        font-weight: 800;
        color: #8B4513;
        line-height: 1.2;
    }

    .metric-label {
        color: #6b4f3a;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    /* Features Premium */
    .features-premium {
        padding: 5rem 0;
        background: #faf7f2;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-tag {
        background: rgba(139, 69, 19, 0.1);
        color: #8B4513;
        padding: 0.3rem 1.2rem;
        border-radius: 30px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .section-title-modern {
        font-size: 2.8rem;
        font-weight: 700;
        color: #3e2e24;
    }

    .text-gradient {
        background: linear-gradient(135deg, #8B4513, #D4AF37);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .features-grid-premium {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        max-width: 1100px;
        margin: 0 auto;
    }

    .feature-card-premium {
        background: white;
        padding: 2.5rem 2rem;
        border-radius: 40px;
        box-shadow: 0 20px 40px -10px rgba(93, 64, 55, 0.2);
        transition: 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.02);
    }

    .feature-card-premium:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 50px -10px #8B4513;
    }

    .card-icon {
        font-size: 3rem;
        color: #D4AF37;
        margin-bottom: 1.5rem;
    }

    .card-stats {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #eee;
        color: #8B4513;
        font-weight: 600;
    }

    /* Showcase grid */
    .showcase-moderno {
        padding: 5rem 0;
        background: white;
    }

    .showcase-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }

    .showcase-item {
        border-radius: 30px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
    }

    .showcase-item img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: 0.5s;
    }

    .showcase-item:hover img {
        transform: scale(1.05);
    }

    .showcase-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        color: white;
        padding: 2rem 1rem 1rem;
    }

    /* CTA Final */
    .cta-final {
        padding: 4rem 0;
        background: #faf7f2;
    }

    .cta-card {
        background: linear-gradient(135deg, #8B4513, #a85e2c);
        color: white;
        padding: 4rem 2rem;
        border-radius: 80px;
        text-align: center;
        box-shadow: 0 30px 50px -10px #8B4513;
    }

    .cta-glow {
        background: #D4AF37;
        border: none;
        padding: 1.2rem 3rem;
        border-radius: 60px;
        font-weight: 700;
        font-size: 1.2rem;
        color: #2c1a0b;
        transition: 0.3s;
        box-shadow: 0 0 25px #D4AF37;
    }

    .cta-glow:hover {
        transform: scale(1.05);
        box-shadow: 0 0 35px #D4AF37;
    }

    /* Modal Premium */
    .premium-modal .modal-content {
        border-radius: 40px;
        border: none;
        background: white;
    }

    .modal-icon {
        font-size: 4rem;
        color: #D4AF37;
        margin: 1rem 0;
    }

    .modal-features {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin: 1.5rem 0;
    }

    .modal-features span {
        background: #f0e8de;
        padding: 0.3rem 1rem;
        border-radius: 30px;
        font-size: 0.9rem;
    }

    .modal-btn {
        background: #8B4513;
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 40px;
        font-weight: 600;
        width: 100%;
    }

    /* Animaciones */
    @keyframes float-main {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-15px);
        }
    }

    @keyframes steam-rise {
        0% {
            opacity: 0;
            transform: translateX(-50%) scale(0.5);
        }

        50% {
            opacity: 0.8;
            transform: translateX(-50%) translateY(-20px) scale(1);
        }

        100% {
            opacity: 0;
            transform: translateX(-50%) translateY(-40px) scale(1.5);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    @media (max-width: 768px) {
        .metrics-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .features-grid-premium {
            grid-template-columns: 1fr;
        }

        .hero-cta-group {
            justify-content: center;
        }
    }
</style>

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection