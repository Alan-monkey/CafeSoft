@extends('layouts.app')

@section('content')
<div class="recovery-link-container">
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
            <div class="col-md-8 col-lg-7">
                <div class="recovery-card">
                    <!-- Header con animación -->
                    <div class="recovery-header">
                        <div class="icon-wrapper">
                            <i class="fas fa-envelope-open-text main-icon"></i>
                            <div class="coffee-decoration">
                                <span>☕</span>
                                <span>✉️</span>
                                <span>☕</span>
                            </div>
                        </div>
                        <h1 class="recovery-title">¡Enlace Generado!</h1>
                        <p class="recovery-subtitle">Tu enlace de recuperación está listo</p>
                    </div>

                    <!-- Card principal - SIN MODIFICAR ESTRUCTURA -->
                    <div class="card-modern">
                        <div class="card-header-modern">
                            <i class="fas fa-check-circle"></i> 
                            Enlace de Recuperación Generado
                        </div>

                        <div class="card-body-modern">
                            <!-- Alerta de éxito mejorada -->
                            <div class="success-alert">
                                <div class="success-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="success-content">
                                    <h5>¡Enlace de recuperación generado exitosamente!</h5>
                                    <p class="mb-0">Para el email: <strong class="email-highlight">{{ $email }}</strong></p>
                                </div>
                            </div>

                            <!-- Botón principal mejorado -->
                            <div class="action-section">
                                <h6 class="action-title">
                                    <i class="fas fa-mouse-pointer"></i>
                                    Haz clic en el botón para restablecer tu contraseña:
                                </h6>
                                <div class="d-grid gap-2">
                                    <a href="{{ $reset_link }}" class="btn-reset-link">
                                        <i class="fas fa-key"></i>
                                        Restablecer Contraseña Ahora
                                        <span class="btn-overlay"></span>
                                    </a>
                                </div>
                            </div>

                            <!-- Card de enlace mejorada -->
                            <div class="link-card">
                                <div class="link-card-header">
                                    <i class="fas fa-link"></i>
                                    Enlace Completo
                                </div>
                                <div class="link-card-body">
                                    <div class="input-group-modern">
                                        <input type="text" class="form-control-modern" id="resetLink" 
                                               value="{{ $reset_link }}" readonly>
                                        <button class="btn-copy" type="button" onclick="copyToClipboard(this)">
                                            <i class="fas fa-copy"></i>
                                            Copiar
                                        </button>
                                    </div>
                                    <div class="expiry-info">
                                        <i class="fas fa-clock"></i>
                                        <span>Este enlace expirará en <strong>1 hora</strong>. Puedes copiarlo y pegarlo en tu navegador.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Alerta de desarrollo mejorada -->
                            <div class="dev-alert">
                                <div class="dev-alert-icon">
                                    <i class="fas fa-code"></i>
                                </div>
                                <div class="dev-alert-content">
                                    <strong>Modo desarrollo:</strong>
                                    <span>En producción, este enlace se enviaría automáticamente al email <strong>{{ $email }}</strong>.</span>
                                </div>
                            </div>

                            <!-- Botones de acción mejorados -->
                            <div class="action-buttons">
                                <a href="{{ route('password.forgot') }}" class="btn-secondary-modern">
                                    <i class="fas fa-redo"></i>
                                    Generar Otro Enlace
                                </a>
                                <a href="{{ route('login') }}" class="btn-primary-modern">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Volver al Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos generales */
    .recovery-link-container {
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
        margin-bottom: 30px;
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
        font-size: 2.5rem;
        margin-bottom: 5px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .recovery-subtitle {
        color: #D9B382;
        font-size: 1.1rem;
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
        background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
        color: white;
        padding: 20px 30px;
        font-size: 1.3rem;
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
        padding: 35px;
    }

    /* Alerta de éxito */
    .success-alert {
        background: linear-gradient(145deg, #e8f5e9, #c8e6c9);
        border-left: 6px solid #2e7d32;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        display: flex;
        gap: 20px;
        align-items: center;
        animation: slideInLeft 0.5s ease;
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .success-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .success-icon i {
        font-size: 2rem;
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
        margin-bottom: 8px;
    }

    .email-highlight {
        background: #2e7d32;
        color: white;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 1rem;
        display: inline-block;
        margin-top: 5px;
    }

    /* Sección de acción */
    .action-section {
        background: linear-gradient(145deg, #fff9f0, #f5e6d3);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid #E8D5C0;
    }

    .action-title {
        color: #5D4037;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .btn-reset-link {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 18px 25px;
        border-radius: 15px;
        text-decoration: none;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
    }

    .btn-reset-link:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.4);
        color: white;
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

    .btn-reset-link:hover .btn-overlay {
        width: 300px;
        height: 300px;
    }

    /* Card de enlace */
    .link-card {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid #E8D5C0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .link-card-header {
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        padding: 15px 20px;
        border-bottom: 2px solid #E8D5C0;
        color: #5D4037;
        font-weight: 600;
    }

    .link-card-body {
        padding: 25px;
    }

    .input-group-modern {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .form-control-modern {
        flex: 1;
        padding: 15px 20px;
        border: 2px solid #E8D5C0;
        border-radius: 15px;
        font-size: 0.95rem;
        background: white;
        color: #3E2723;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
    }

    .btn-copy {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        border: none;
        padding: 15px 25px;
        border-radius: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-copy:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(139, 69, 19, 0.3);
    }

    .expiry-info {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #6c757d;
        font-size: 0.9rem;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .expiry-info i {
        color: #8B4513;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Alerta de desarrollo */
    .dev-alert {
        background: linear-gradient(145deg, #e1f5fe, #b3e5fc);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        gap: 15px;
        align-items: flex-start;
        border-left: 6px solid #0288d1;
        animation: slideInRight 0.5s ease;
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .dev-alert-icon {
        width: 40px;
        height: 40px;
        background: #0288d1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dev-alert-icon i {
        color: white;
        font-size: 1.3rem;
    }

    .dev-alert-content {
        color: #01579b;
        flex: 1;
    }

    .dev-alert-content strong {
        display: block;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    /* Botones de acción */
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn-secondary-modern {
        background: linear-gradient(145deg, #6c757d, #5a6268);
        color: white;
        padding: 15px 25px;
        border-radius: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        flex: 1;
        justify-content: center;
        font-weight: 500;
    }

    .btn-secondary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
        color: white;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 15px 25px;
        border-radius: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        flex: 1;
        justify-content: center;
        font-weight: 500;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(139, 69, 19, 0.3);
        color: white;
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
            font-size: 2rem;
        }
        
        .success-alert {
            flex-direction: column;
            text-align: center;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .input-group-modern {
            flex-direction: column;
        }
        
        .btn-copy {
            width: 100%;
            justify-content: center;
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

    .col-md-8 {
        padding: 0 15px;
    }
</style>

<!-- Font Awesome y Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Script de copiado mejorado -->
<script>
function copyToClipboard(button) {
    const copyText = document.getElementById("resetLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    
    navigator.clipboard.writeText(copyText.value)
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