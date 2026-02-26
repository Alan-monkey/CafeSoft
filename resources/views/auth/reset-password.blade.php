@extends('layouts.app3')

@section('content')
<div class="reset-password-container">
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
                <div class="reset-card">
                    <!-- Logo y decoración -->
                    <div class="text-center mb-4">
                        <div class="logo-wrapper">
                            <i class="fas fa-key logo-icon"></i>
                            <div class="coffee-decoration">
                                <span>☕</span>
                                <span>☕</span>
                                <span>☕</span>
                            </div>
                        </div>
                        <h2 class="reset-title">Restablecer Contraseña</h2>
                        <p class="reset-subtitle">Ingresa tu nueva contraseña</p>
                    </div>

                    <!-- Formulario original - SIN MODIFICACIONES -->
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Nueva Contraseña
                            </label>
                            <div class="input-wrapper-modern">
                                <input id="password" type="password" 
                                       class="form-control-modern @error('password') is-invalid @enderror" 
                                       name="password" required 
                                       placeholder="••••••••">
                                <span class="focus-border"></span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback-modern" role="alert">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">
                                <i class="fas fa-check-circle me-2"></i>Confirmar Contraseña
                            </label>
                            <div class="input-wrapper-modern">
                                <input id="password-confirm" type="password" 
                                       class="form-control-modern" 
                                       name="password_confirmation" required 
                                       placeholder="••••••••">
                                <span class="focus-border"></span>
                            </div>
                        </div>

                        <!-- Requisitos de contraseña (decorativo) -->
                        <div class="password-hints mb-4">
                            <div class="hint-item" id="length-hint">
                                <i class="fas fa-circle"></i> Mínimo 8 caracteres
                            </div>
                            <div class="hint-item" id="uppercase-hint">
                                <i class="fas fa-circle"></i> Al menos una mayúscula
                            </div>
                            <div class="hint-item" id="number-hint">
                                <i class="fas fa-circle"></i> Al menos un número
                            </div>
                        </div>

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn-reset-modern">
                                <i class="fas fa-sync-alt me-2"></i>
                                Restablecer Contraseña
                                <span class="btn-overlay"></span>
                            </button>
                        </div>
                    </form>

                    <!-- Footer -->
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="back-to-login">
                            <i class="fas fa-arrow-left me-2"></i>
                            Volver al inicio de sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos generales */
    .reset-password-container {
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
    .reset-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        padding: 40px 35px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        z-index: 10;
        animation: fadeInUp 0.8s ease;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Logo */
    .logo-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
    }

    .logo-icon {
        font-size: 3.5rem;
        color: #8B4513;
        animation: rotate-slow 10s infinite linear;
    }

    .coffee-decoration span {
        display: inline-block;
        margin: 0 5px;
        font-size: 1.2rem;
        animation: bounce 2s ease infinite;
    }

    .coffee-decoration span:nth-child(2) { animation-delay: 0.2s; }
    .coffee-decoration span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes rotate-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .reset-title {
        color: #3E2723;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 5px;
    }

    .reset-subtitle {
        color: #6D4C41;
        font-size: 1rem;
        opacity: 0.8;
    }

    /* Labels */
    .form-label {
        color: #5D4037;
        font-weight: 600;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }

    .form-label i {
        color: #8B4513;
    }

    /* Inputs modernos */
    .input-wrapper-modern {
        position: relative;
    }

    .form-control-modern {
        width: 100%;
        padding: 16px 20px;
        border: 2px solid #E8D5C0;
        border-radius: 15px;
        font-size: 1rem;
        background: white;
        transition: all 0.3s ease;
        color: #3E2723;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.1);
        transform: translateY(-2px);
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

    /* Mensajes de error */
    .invalid-feedback-modern {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
        color: #dc3545;
        font-size: 0.9rem;
        animation: slideIn 0.3s ease;
        background: rgba(220, 53, 69, 0.1);
        padding: 10px 15px;
        border-radius: 10px;
    }

    .invalid-feedback-modern i {
        font-size: 1.1rem;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Pistas de contraseña */
    .password-hints {
        background: linear-gradient(145deg, #FFF9F0, #F5E6D3);
        border-radius: 15px;
        padding: 15px;
        border: 1px solid #E8D5C0;
    }

    .hint-item {
        color: #6D4C41;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .hint-item i {
        font-size: 0.7rem;
        color: #B2967D;
    }

    .hint-item.valid {
        color: #28a745;
    }

    .hint-item.valid i {
        color: #28a745;
        content: "\f00c";
    }

    /* Botón moderno */
    .btn-reset-modern {
        width: 100%;
        padding: 16px 25px;
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        border: none;
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
    }

    .btn-reset-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.4);
        background: linear-gradient(135deg, #9C4F1E 0%, #B45F2E 100%);
    }

    .btn-reset-modern:active {
        transform: translateY(-1px);
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

    .btn-reset-modern:hover .btn-overlay {
        width: 300px;
        height: 300px;
    }

    /* Link de retorno */
    .back-to-login {
        color: #8B4513;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        border-radius: 30px;
        background: rgba(139, 69, 19, 0.1);
    }

    .back-to-login:hover {
        color: #5D4037;
        background: rgba(139, 69, 19, 0.2);
        transform: translateX(-5px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .reset-card {
            padding: 30px 20px;
        }
        
        .coffee-cup {
            display: none;
        }
        
        .reset-title {
            font-size: 1.7rem;
        }
        
        .logo-icon {
            font-size: 2.8rem;
        }
    }

    /* Mantener clases originales de Bootstrap pero con estilos personalizados */
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

    /* Override de Bootstrap pero manteniendo funcionalidad */
    .form-control {
        /* Las clases originales se mantienen pero no se usan */
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    
    if (password) {
        password.addEventListener('input', function() {
            const value = this.value;
            
            // Actualizar hints visuales (solo decorativo)
            const hints = document.querySelectorAll('.hint-item');
            
            // Length hint
            if (value.length >= 8) {
                hints[0].classList.add('valid');
                hints[0].querySelector('i').className = 'fas fa-check-circle';
            } else {
                hints[0].classList.remove('valid');
                hints[0].querySelector('i').className = 'fas fa-circle';
            }
            
            // Uppercase hint
            if (/[A-Z]/.test(value)) {
                hints[1].classList.add('valid');
                hints[1].querySelector('i').className = 'fas fa-check-circle';
            } else {
                hints[1].classList.remove('valid');
                hints[1].querySelector('i').className = 'fas fa-circle';
            }
            
            // Number hint
            if (/[0-9]/.test(value)) {
                hints[2].classList.add('valid');
                hints[2].querySelector('i').className = 'fas fa-check-circle';
            } else {
                hints[2].classList.remove('valid');
                hints[2].querySelector('i').className = 'fas fa-circle';
            }
        });
    }
});
</script>

@endsection