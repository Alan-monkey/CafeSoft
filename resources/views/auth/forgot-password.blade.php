@extends('layouts.app3')

@section('content')
<div class="password-recovery-container">
    <!-- Elementos decorativos de café - TAZAS BLANCAS -->
    <div class="coffee-elements">
        <div class="coffee-cup cup-1">
            <div class="cup-top white-cup"></div>
            <div class="cup-body white-cup"></div>
            <div class="cup-handle white-handle"></div>
            <div class="steam s1"></div>
            <div class="steam s2"></div>
            <div class="steam s3"></div>
        </div>
        <div class="coffee-cup cup-2">
            <div class="cup-top white-cup"></div>
            <div class="cup-body white-cup"></div>
            <div class="cup-handle white-handle"></div>
            <div class="steam s1"></div>
            <div class="steam s2"></div>
            <div class="steam s3"></div>
        </div>
        <div class="coffee-cup cup-3">
            <div class="cup-top white-cup"></div>
            <div class="cup-body white-cup"></div>
            <div class="cup-handle white-handle"></div>
            <div class="steam s1"></div>
            <div class="steam s2"></div>
            <div class="steam s3"></div>
        </div>
        <div class="coffee-cup cup-4">
            <div class="cup-top white-cup"></div>
            <div class="cup-body white-cup"></div>
            <div class="cup-handle white-handle"></div>
            <div class="steam s1"></div>
            <div class="steam s2"></div>
            <div class="steam s3"></div>
        </div>
        <div class="coffee-bean bean-1"></div>
        <div class="coffee-bean bean-2"></div>
        <div class="coffee-bean bean-3"></div>
        <div class="coffee-bean bean-4"></div>
        <div class="coffee-bean bean-5"></div>
        <div class="coffee-bean bean-6"></div>
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="recovery-card">
                    <!-- Header animado -->
                    <div class="recovery-header">
                        <div class="icon-wrapper">
                            <i class="fas fa-key main-icon"></i>
                            <div class="coffee-decoration">
                                <span>☕</span>
                                <span>🔐</span>
                                <span>☕</span>
                            </div>
                        </div>
                        <h1 class="recovery-title">Recuperar Contraseña</h1>
                        <p class="recovery-subtitle">¿Olvidaste tu contraseña? No te preocupes</p>
                    </div>

                    <!-- Card principal - SIN MODIFICAR ESTRUCTURA -->
                    <div class="card-modern">
                        <div class="card-header-modern">
                            <i class="fas fa-lock"></i> Recuperar Contraseña
                        </div>

                        <div class="card-body-modern">
                            {{-- Mostrar enlace generado - MISMA CONDICIÓN --}}
                            @if (isset($show_link) && $show_link)
                                <!-- Enlace generado - Diseño mejorado -->
                                <div class="success-alert">
                                    <div class="success-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="success-content">
                                        <h5><i class="fas fa-check-circle"></i> ¡Enlace generado exitosamente!</h5>
                                        <p>Para: <strong class="email-highlight">{{ $email }}</strong></p>
                                    </div>
                                </div>
                                
                                <div class="action-section">
                                    <div class="mt-3">
                                        <a href="{{ $reset_link }}" class="btn-primary-lg">
                                            <i class="fas fa-key"></i> Restablecer Contraseña
                                            <span class="btn-overlay"></span>
                                        </a>
                                        
                                        <div class="mt-4">
                                            <label class="form-label-modern">
                                                <i class="fas fa-copy"></i> O copia este enlace:
                                            </label>
                                            <div class="input-group-modern">
                                                <input type="text" class="form-control-modern" 
                                                       value="{{ $reset_link }}" readonly id="linkInput">
                                                <button class="btn-copy-modern" type="button" onclick="copyLink(this)">
                                                    <i class="fas fa-copy"></i>
                                                    Copiar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="divider-modern">
                                <div class="text-center">
                                    <a href="{{ route('password.forgot') }}" class="btn-secondary-modern">
                                        <i class="fas fa-redo"></i> Generar otro enlace
                                    </a>
                                </div>
                            @else
                                {{-- Formulario normal - MISMO FORMULARIO --}}
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    
                                    @if (session('success'))
                                        <div class="success-message">
                                            <i class="fas fa-check-circle"></i>
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    
                                    @if ($errors->any())
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <div>
                                                @foreach ($errors->all() as $error)
                                                    <p>{{ $error }}</p>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-4">
                                        <label for="email" class="form-label-modern">
                                            <i class="fas fa-envelope"></i> Email
                                        </label>
                                        <div class="input-wrapper-modern">
                                            <input id="email" type="email" 
                                                   class="form-control-modern @error('email') is-invalid @enderror" 
                                                   name="email" value="{{ old('email') }}" 
                                                   required autofocus
                                                   placeholder="tucorreo@ejemplo.com">
                                            <span class="focus-border"></span>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback-modern" role="alert">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="d-grid gap-3">
                                        <button type="submit" class="btn-primary-modern">
                                            <i class="fas fa-envelope"></i>
                                            Generar Enlace de Recuperación
                                            <span class="btn-overlay"></span>
                                        </button>
                                        <a href="{{ route('login') }}" class="btn-link-modern">
                                            <i class="fas fa-arrow-left"></i>
                                            Volver al Login
                                        </a>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Footer decorativo -->
                    <div class="recovery-footer">
                        <span>☕</span> Café Sofft - Siempre contigo <span>☕</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos generales */
    .password-recovery-container {
        min-height: 100vh;
        background: linear-gradient(145deg, #1a0f0a 0%, #2d1e15 50%, #3b2a20 100%);
        position: relative;
        overflow: hidden;
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        display: flex;
        align-items: center;
    }

    /* Elementos decorativos - TAZAS BLANCAS */
    .coffee-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .coffee-cup {
        position: absolute;
        animation: float-cup 8s ease-in-out infinite;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3));
    }

    .cup-1 { top: 10%; left: 5%; transform: scale(0.8); animation-delay: 0s; }
    .cup-2 { bottom: 15%; right: 8%; transform: scale(0.7) rotate(-10deg); animation-delay: 2s; }
    .cup-3 { top: 30%; right: 12%; transform: scale(0.6) rotate(15deg); animation-delay: 4s; }
    .cup-4 { bottom: 25%; left: 10%; transform: scale(0.5) rotate(-5deg); animation-delay: 6s; }

    .white-cup {
        background: linear-gradient(145deg, #ffffff, #f0f0f0) !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .white-handle {
        border-color: #f0f0f0 !important;
        border-right: 8px solid #ffffff !important;
    }

    .cup-top {
        width: 80px;
        height: 20px;
        border-radius: 50%;
        position: relative;
        z-index: 2;
        background: linear-gradient(145deg, #ffffff, #e0e0e0);
    }

    .cup-body {
        width: 70px;
        height: 60px;
        border-radius: 0 0 35px 35px;
        position: relative;
        top: -10px;
        background: linear-gradient(145deg, #ffffff, #f5f5f5);
    }

    .cup-handle {
        width: 25px;
        height: 40px;
        border: 8px solid #6F4E37;
        border-left: none;
        border-radius: 0 20px 20px 0;
        position: absolute;
        right: -20px;
        top: 15px;
        border-color: #f0f0f0;
    }

    .steam {
        position: absolute;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        animation: steam-animation 3s infinite ease-in-out;
    }

    .s1 { width: 15px; height: 15px; top: -25px; left: 20px; animation-delay: 0s; }
    .s2 { width: 12px; height: 12px; top: -35px; left: 32px; animation-delay: 0.5s; }
    .s3 { width: 10px; height: 10px; top: -30px; left: 45px; animation-delay: 1s; }

    @keyframes steam-animation {
        0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
        50% { transform: translateY(-20px) scale(1.2); opacity: 0.2; }
    }

    @keyframes float-cup {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(2deg); }
    }

    /* Granos de café */
    .coffee-bean {
        position: absolute;
        width: 20px;
        height: 10px;
        background: #8B4513;
        border-radius: 50%;
        opacity: 0.4;
        animation: float-bean 15s infinite linear;
        transform: rotate(45deg);
    }

    .bean-1 { top: 10%; left: 20%; animation-delay: 0s; width: 25px; height: 12px; }
    .bean-2 { top: 70%; left: 85%; animation-delay: 3s; width: 18px; height: 9px; }
    .bean-3 { top: 50%; left: 15%; animation-delay: 6s; width: 22px; height: 11px; }
    .bean-4 { top: 80%; left: 40%; animation-delay: 9s; width: 20px; height: 10px; }
    .bean-5 { top: 30%; left: 90%; animation-delay: 12s; width: 28px; height: 14px; }
    .bean-6 { top: 90%; left: 60%; animation-delay: 15s; width: 15px; height: 8px; }

    @keyframes float-bean {
        0% { transform: translateY(0) rotate(45deg) scale(1); opacity: 0.4; }
        100% { transform: translateY(-100vh) rotate(405deg) scale(0.5); opacity: 0; }
    }

    /* Partículas */
    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        animation: particle-float 10s infinite linear;
    }

    .particle-1 { top: 30%; left: 10%; animation-delay: 0s; }
    .particle-2 { top: 60%; left: 80%; animation-delay: 2.5s; }
    .particle-3 { top: 20%; left: 95%; animation-delay: 5s; }
    .particle-4 { top: 80%; left: 20%; animation-delay: 7.5s; }
    .particle-5 { top: 40%; left: 40%; animation-delay: 3.2s; }

    @keyframes particle-float {
        0% { transform: translateY(0) scale(1); opacity: 0.3; }
        100% { transform: translateY(-100vh) scale(0); opacity: 0; }
    }

    /* Tarjeta principal */
    .recovery-card {
        position: relative;
        z-index: 10;
        animation: fadeInUp 0.8s ease;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header */
    .recovery-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .icon-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
    }

    .main-icon {
        font-size: 4rem;
        color: #8B4513;
        animation: float 3s ease-in-out infinite;
    }

    .coffee-decoration {
        margin-top: 10px;
    }

    .coffee-decoration span {
        display: inline-block;
        margin: 0 8px;
        font-size: 1.5rem;
        animation: bounce 2s ease infinite;
    }

    .coffee-decoration span:nth-child(2) { animation-delay: 0.3s; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .recovery-title {
        color: #fff;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 5px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .recovery-subtitle {
        color: #D9B382;
        font-size: 1rem;
        opacity: 0.9;
    }

    /* Card moderna */
    .card-modern {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .card-header-modern {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 18px 25px;
        font-size: 1.2rem;
        font-weight: 600;
        position: relative;
        overflow: hidden;
    }

    .card-header-modern::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2));
        transform: skewX(-20deg) translateX(100px);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { transform: skewX(-20deg) translateX(100px); }
        20% { transform: skewX(-20deg) translateX(-200px); }
        100% { transform: skewX(-20deg) translateX(-200px); }
    }

    .card-body-modern {
        padding: 30px;
    }

    /* Estilos para cuando se muestra el enlace */
    .success-alert {
        background: linear-gradient(145deg, #e8f5e9, #c8e6c9);
        border-left: 6px solid #2e7d32;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 25px;
        display: flex;
        gap: 15px;
        align-items: center;
        animation: slideInLeft 0.5s ease;
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .success-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .success-icon i {
        font-size: 1.8rem;
        color: white;
        animation: scaleCheck 0.5s ease;
    }

    @keyframes scaleCheck {
        0% { transform: scale(0); }
        80% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .success-content h5 {
        color: #1b5e20;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .email-highlight {
        background: #2e7d32;
        color: white;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        display: inline-block;
        margin-top: 5px;
    }

    .action-section {
        background: linear-gradient(145deg, #fff9f0, #f5e6d3);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .btn-primary-lg {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 15px;
        text-decoration: none;
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
        width: 100%;
    }

    .btn-primary-lg:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.4);
        color: white;
    }

    /* Input group moderno */
    .input-group-modern {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .form-control-modern {
        flex: 1;
        padding: 12px 15px;
        border: 2px solid #E8D5C0;
        border-radius: 12px;
        font-size: 0.9rem;
        background: white;
        color: #3E2723;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
    }

    .btn-copy-modern {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-copy-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(139, 69, 19, 0.3);
    }

    .divider-modern {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, #E8D5C0, transparent);
        margin: 25px 0;
    }

    .btn-secondary-modern {
        background: linear-gradient(145deg, #6c757d, #5a6268);
        color: white;
        padding: 12px 25px;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-secondary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
        color: white;
    }

    /* Estilos del formulario */
    .form-label-modern {
        color: #5D4037;
        font-weight: 600;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .input-wrapper-modern {
        position: relative;
    }

    .form-control-modern {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #E8D5C0;
        border-radius: 15px;
        font-size: 1rem;
        background: white;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #8B4513;
    }

    .form-control-modern.is-invalid {
        border-color: #dc3545;
        animation: shake 0.3s ease;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .focus-border {
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, #8B4513, #C97C5D);
        transition: all 0.3s ease;
        transform: translateX(-50%);
        border-radius: 3px;
    }

    .form-control-modern:focus ~ .focus-border {
        width: 100%;
    }

    .invalid-feedback-modern {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
        color: #dc3545;
        font-size: 0.9rem;
        animation: slideIn 0.3s ease;
        background: rgba(220, 53, 69, 0.1);
        padding: 8px 12px;
        border-radius: 10px;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .success-message {
        background: linear-gradient(145deg, #d4edda, #c3e6cb);
        color: #155724;
        padding: 15px 20px;
        border-radius: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-left: 6px solid #28a745;
        animation: slideIn 0.5s ease;
    }

    .error-message {
        background: linear-gradient(145deg, #f8d7da, #f5c6cb);
        color: #721c24;
        padding: 15px 20px;
        border-radius: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border-left: 6px solid #dc3545;
        animation: slideIn 0.5s ease;
    }

    .error-message p {
        margin-bottom: 5px;
    }

    .error-message p:last-child {
        margin-bottom: 0;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        border: none;
        padding: 15px 20px;
        border-radius: 15px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .btn-primary-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.4);
    }

    .btn-link-modern {
        color: #8B4513;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px;
    }

    .btn-link-modern:hover {
        color: #5D4037;
        transform: translateX(-5px);
    }

    .btn-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.5s, height 0.5s;
    }

    .btn-primary-modern:hover .btn-overlay,
    .btn-primary-lg:hover .btn-overlay {
        width: 300px;
        height: 300px;
    }

    /* Footer */
    .recovery-footer {
        text-align: center;
        margin-top: 25px;
        color: #D9B382;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .recovery-footer span {
        margin: 0 10px;
        font-size: 1.2rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.1); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body-modern {
            padding: 25px 20px;
        }
        
        .coffee-cup {
            display: none;
        }
        
        .recovery-title {
            font-size: 1.7rem;
        }
        
        .main-icon {
            font-size: 3rem;
        }
        
        .input-group-modern {
            flex-direction: column;
        }
        
        .btn-copy-modern {
            width: 100%;
            justify-content: center;
        }
        
        .success-alert {
            flex-direction: column;
            text-align: center;
        }
    }

    /* Mantener clases originales */
    .container {
        position: relative;
        z-index: 10;
    }

    .row {
        margin: 0;
    }

    .col-md-6 {
        padding: 0 15px;
    }
</style>

<!-- Font Awesome y Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Script de copiado mejorado -->
<script>
function copyLink(button) {
    const input = document.getElementById('linkInput');
    input.select();
    input.setSelectionRange(0, 99999);
    
    navigator.clipboard.writeText(input.value)
        .then(() => {
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check"></i> Copiado!';
            button.style.background = 'linear-gradient(135deg, #28a745, #218838)';
            
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.style.background = 'linear-gradient(135deg, #8B4513 0%, #A0522D 100%)';
            }, 2000);
        })
        .catch(err => {
            alert('Error al copiar: ' + err);
        });
}
</script>
@endsection