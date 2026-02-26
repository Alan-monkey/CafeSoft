@extends ('layouts.app2')
@section('content')
<div class="login-container">
    <!-- Elementos decorativos de café - TAZAS BLANCAS -->
    <div class="coffee-elements">
        <!-- Tazas blancas múltiples -->
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

        <!-- Granos de café giratorios -->
        <div class="coffee-bean bean-1"></div>
        <div class="coffee-bean bean-2"></div>
        <div class="coffee-bean bean-3"></div>
        <div class="coffee-bean bean-4"></div>
        <div class="coffee-bean bean-5"></div>
        <div class="coffee-bean bean-6"></div>
        
        <!-- Partículas flotantes (efecto de café) -->
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>

    <div class="login-wrapper">
        <div class="login-card glass-effect">
            <!-- Header con logo de cafetería -->
            <div class="login-header">
                <div class="logo">
                    <div class="logo-container">
                        <i class="fas fa-coffee"></i>
                        <i class="fas fa-heart heart-icon"></i>
                    </div>
                    <h1>Café <span class="highlight">Sofft</span></h1>
                </div>
                <p class="welcome-text">Bienvenido de nuevo</p>
                <div class="coffee-beans-decoration">
                    <span>☕</span>
                    <span>☕</span>
                    <span>☕</span>
                </div>
            </div>

            <!-- Formulario de login -->
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-input" placeholder="Correo electrónico" required>
                        <div class="input-focus-effect"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Contraseña" required>
                        <div class="input-focus-effect"></div>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-checkbox">
                        <input type="checkbox" name="remember">
                        <span class="checkmark"></span>
                        Recordarme
                    </label>
                    <a href="{{ route('password.forgot') }}" class="forgot-link">
                        <i class="fas fa-question-circle"></i> ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Iniciar Sesión</span>
                    <div class="btn-ripple"></div>
                </button>
            </form>

            <!-- Mensajes de error -->
            @if ($errors->any())
            <div class="error-alert">
                <i class="fas fa-exclamation-circle"></i>
                <div class="error-content">
                    <h4>Error de acceso</h4>
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="error-progress"></div>
            </div>
            @endif

            <!-- Footer del login -->
            <div class="login-footer">
                <p>¿Primera vez aquí?</p>
                <a href="#" class="footer-link">
                    <i class="fas fa-phone-alt"></i>
                    Contáctanos
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .login-container {
        min-height: 100vh;
        background: linear-gradient(145deg, #1a0f0a 0%, #2d1e15 50%, #3b2a20 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        font-family: 'Poppins', 'Segoe UI', sans-serif;
    }

    /* Elementos decorativos de café */
    .coffee-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    /* TAZAS BLANCAS - Múltiples y animadas */
    .coffee-cup {
        position: absolute;
        animation: float-cup 8s ease-in-out infinite;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3));
    }

    .cup-1 {
        top: 15%;
        left: 5%;
        transform: scale(0.9);
        animation-delay: 0s;
    }

    .cup-2 {
        bottom: 20%;
        right: 8%;
        transform: scale(0.8) rotate(-10deg);
        animation-delay: 2s;
    }

    .cup-3 {
        top: 40%;
        right: 15%;
        transform: scale(0.7) rotate(15deg);
        animation-delay: 4s;
    }

    .cup-4 {
        bottom: 30%;
        left: 10%;
        transform: scale(0.6) rotate(-5deg);
        animation-delay: 6s;
    }

    .white-cup {
        background: linear-gradient(145deg, #ffffff, #f0f0f0) !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .white-handle {
        border-color: #f0f0f0 !important;
        border-right: 8px solid #ffffff !important;
        filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.1));
    }

    .cup-top {
        width: 80px;
        height: 20px;
        background: #6F4E37;
        border-radius: 50%;
        position: relative;
        z-index: 2;
        background: linear-gradient(145deg, #ffffff, #e0e0e0);
    }

    .cup-body {
        width: 70px;
        height: 60px;
        background: linear-gradient(135deg, #6F4E37 0%, #8B5A2B 100%);
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

    .s1 {
        width: 15px;
        height: 15px;
        top: -25px;
        left: 20px;
        animation-delay: 0s;
    }

    .s2 {
        width: 12px;
        height: 12px;
        top: -35px;
        left: 32px;
        animation-delay: 0.5s;
    }

    .s3 {
        width: 10px;
        height: 10px;
        top: -30px;
        left: 45px;
        animation-delay: 1s;
    }

    @keyframes steam-animation {
        0%, 100% {
            transform: translateY(0) scale(1);
            opacity: 0.6;
        }
        50% {
            transform: translateY(-20px) scale(1.2);
            opacity: 0.2;
        }
    }

    @keyframes float-cup {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        50% {
            transform: translateY(-20px) rotate(2deg);
        }
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

    .bean-1 {
        top: 10%;
        left: 20%;
        animation-delay: 0s;
        width: 25px;
        height: 12px;
    }

    .bean-2 {
        top: 70%;
        left: 85%;
        animation-delay: 3s;
        width: 18px;
        height: 9px;
    }

    .bean-3 {
        top: 50%;
        left: 15%;
        animation-delay: 6s;
        width: 22px;
        height: 11px;
    }

    .bean-4 {
        top: 80%;
        left: 40%;
        animation-delay: 9s;
        width: 20px;
        height: 10px;
    }

    .bean-5 {
        top: 30%;
        left: 90%;
        animation-delay: 12s;
        width: 28px;
        height: 14px;
    }

    .bean-6 {
        top: 90%;
        left: 60%;
        animation-delay: 15s;
        width: 15px;
        height: 8px;
    }

    @keyframes float-bean {
        0% {
            transform: translateY(0) rotate(45deg) scale(1);
            opacity: 0.4;
        }
        100% {
            transform: translateY(-100vh) rotate(405deg) scale(0.5);
            opacity: 0;
        }
    }

    /* Partículas flotantes */
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
        0% {
            transform: translateY(0) scale(1);
            opacity: 0.3;
        }
        100% {
            transform: translateY(-100vh) scale(0);
            opacity: 0;
        }
    }

    /* Contenedor principal del login */
    .login-wrapper {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 450px;
        padding: 20px;
        animation: fadeInUp 0.8s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        padding: 45px 35px;
        box-shadow: 
            0 25px 50px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    /* Header del login */
    .login-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .logo {
        margin-bottom: 15px;
    }

    .logo-container {
        position: relative;
        display: inline-block;
    }

    .logo i {
        font-size: 3.5rem;
        color: #8B4513;
        animation: rotate-slow 10s infinite linear;
    }

    .heart-icon {
        position: absolute;
        bottom: 0;
        right: -10px;
        font-size: 1.2rem !important;
        color: #ff6b6b !important;
        animation: heartbeat 1.5s ease infinite !important;
    }

    @keyframes rotate-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    .logo h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #3E2723;
        margin: 10px 0 5px;
    }

    .highlight {
        color: #8B4513;
        position: relative;
        display: inline-block;
    }

    .highlight::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #8B4513, transparent);
        animation: underline-pulse 2s infinite;
    }

    @keyframes underline-pulse {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 1; }
    }

    .welcome-text {
        color: #6D4C41;
        font-size: 1.1rem;
        margin: 10px 0 5px;
        opacity: 0.8;
        animation: fadeIn 2s ease;
    }

    .coffee-beans-decoration {
        margin-top: 10px;
        font-size: 1.5rem;
        animation: bounce 2s ease infinite;
    }

    .coffee-beans-decoration span {
        display: inline-block;
        margin: 0 5px;
        animation: rotate-bean 3s infinite;
    }

    .coffee-beans-decoration span:nth-child(2) { animation-delay: 0.2s; }
    .coffee-beans-decoration span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes rotate-bean {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(15deg); }
    }

    /* Formulario */
    .login-form {
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 18px;
        color: #8B4513;
        font-size: 1.2rem;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .form-input {
        width: 100%;
        padding: 18px 18px 18px 50px;
        border: 2px solid #E8D5C0;
        border-radius: 15px;
        font-size: 1rem;
        background: white;
        transition: all 0.3s ease;
        color: #3E2723;
        position: relative;
        z-index: 1;
    }

    .form-input:focus {
        outline: none;
        border-color: #8B4513;
        transform: translateY(-2px);
    }

    .input-focus-effect {
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #8B4513, #C97C5D);
        transition: all 0.3s ease;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .form-input:focus ~ .input-focus-effect {
        width: 100%;
    }

    .form-input::placeholder {
        color: #B2967D;
        transition: all 0.3s ease;
    }

    .form-input:focus::placeholder {
        opacity: 0.5;
        transform: translateX(10px);
    }

    /* Opciones del formulario */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .remember-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #5D4037;
        cursor: pointer;
        position: relative;
        padding-left: 28px;
    }

    .remember-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: white;
        border: 2px solid #E8D5C0;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .remember-checkbox:hover input ~ .checkmark {
        border-color: #8B4513;
    }

    .remember-checkbox input:checked ~ .checkmark {
        background-color: #8B4513;
        border-color: #8B4513;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .remember-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    .remember-checkbox .checkmark:after {
        left: 5px;
        top: 2px;
        width: 4px;
        height: 8px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .forgot-link {
        color: #8B4513;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .forgot-link:hover {
        color: #5D4037;
        transform: translateX(5px);
    }

    /* Botón de login */
    .login-btn {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        border: none;
        border-radius: 15px;
        font-size: 1.2rem;
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

    .login-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.4);
        background: linear-gradient(135deg, #9C4F1E 0%, #B45F2E 100%);
    }

    .login-btn:active {
        transform: translateY(-1px);
    }

    .btn-ripple {
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

    .login-btn:hover .btn-ripple {
        width: 300px;
        height: 300px;
    }

    /* Alertas de error */
    .error-alert {
        background: linear-gradient(135deg, #FF6B6B 0%, #FF5252 100%);
        color: white;
        padding: 18px;
        border-radius: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        animation: slideInError 0.5s ease;
        position: relative;
        overflow: hidden;
    }

    .error-alert i {
        font-size: 1.5rem;
        animation: shake 0.5s ease;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .error-content h4 {
        margin: 0 0 5px 0;
        font-size: 1rem;
        font-weight: 600;
    }

    .error-list {
        margin: 0;
        padding-left: 18px;
        font-size: 0.9rem;
    }

    .error-list li {
        margin-bottom: 3px;
    }

    .error-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: rgba(255,255,255,0.5);
        animation: progress 5s linear forwards;
    }

    @keyframes progress {
        from { width: 100%; }
        to { width: 0%; }
    }

    @keyframes slideInError {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Footer del login */
    .login-footer {
        text-align: center;
        padding-top: 25px;
        border-top: 2px solid #E8D5C0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .login-footer p {
        color: #6D4C41;
        margin: 0;
        font-size: 0.95rem;
    }

    .footer-link {
        color: white;
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        text-decoration: none;
        font-weight: 600;
        padding: 12px 25px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        margin: 0 auto;
    }

    .footer-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(139, 69, 19, 0.3);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .login-wrapper {
            padding: 15px;
        }
        
        .login-card {
            padding: 30px 20px;
        }
        
        .coffee-cup {
            display: none;
        }
        
        .logo h1 {
            font-size: 2rem;
        }
        
        .form-options {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .footer-link {
            padding: 10px 20px;
        }
    }

    /* Animaciones adicionales */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 0.8; }
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
</style>

<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@endsection