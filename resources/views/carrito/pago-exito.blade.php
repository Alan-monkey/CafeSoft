@extends('layouts.app')

@section('content')
<div class="pago-exitoso-container">
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
        <div class="coffee-bean bean-1"></div>
        <div class="coffee-bean bean-2"></div>
        <div class="coffee-bean bean-3"></div>
        <div class="coffee-bean bean-4"></div>
        <div class="coffee-bean bean-5"></div>
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <!-- Tarjeta principal con estilo glassmorphism -->
                <div class="exito-card">
                    <div class="exito-card-header">
                        <div class="header-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="header-title">
                            <h4><i class="fas fa-coffee"></i> ¡Pago Exitoso!</h4>
                            <p>Gracias por su compra</p>
                        </div>
                        <div class="coffee-decoration-header">
                            <span>☕</span>
                            <span>✓</span>
                            <span>☕</span>
                        </div>
                    </div>

                    <div class="exito-card-body">
                        <!-- Icono de éxito animado -->
                        <div class="success-animation">
                            <div class="success-circle">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <!-- Mensaje de éxito -->
                        <h3 class="success-title">¡Gracias por su preferencia!</h3>
                        <p class="success-subtitle">Su compra ha sido procesada exitosamente.</p>

                        <!-- Detalles del pago -->
                        <div class="detalles-pago">
                            <h5><i class="fas fa-receipt"></i> Detalles del Pago</h5>
                            
                            <div class="detalle-item">
                                <span class="detalle-label">Total de la compra:</span>
                                <span class="detalle-valor total">${{ number_format($total, 2) }}</span>
                            </div>
                            
                            <div class="detalle-item">
                                <span class="detalle-label">Efectivo recibido:</span>
                                <span class="detalle-valor efectivo">${{ number_format($efectivo, 2) }}</span>
                            </div>
                            
                            <div class="detalle-item">
                                <span class="detalle-label">Cambio entregado:</span>
                                <span class="detalle-valor cambio">${{ number_format($cambio, 2) }}</span>
                            </div>
                        </div>

                        <!-- Ticket descargado -->
                        <div class="ticket-info">
                            <div class="ticket-icon">
                                <i class="fas fa-download"></i>
                            </div>
                            <div class="ticket-text">
                                <strong>El ticket se ha descargado automáticamente.</strong>
                                <span>Si no se descargó, haga clic en el botón abajo.</span>
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="action-buttons-row">
                            <a href="{{ route('productos.leer') }}" class="btn-seguir-comprando">
                                <i class="fas fa-shopping-bag"></i> Seguir Comprando
                                <span class="btn-overlay"></span>
                            </a>
                            
                            <a href="{{ route('carrito.descargar-ticket') }}" 
                               class="btn-descargar-ticket" 
                               id="descargarBtn">
                                <i class="fas fa-download"></i> Descargar Ticket
                                <span class="btn-overlay"></span>
                            </a>
                        </div>
                        
                        <!-- Fecha y hora -->
                        <div class="fecha-info">
                            <i class="fas fa-clock"></i> 
                            {{ now()->format('d/m/Y H:i:s') }}
                        </div>
                    </div>

                    <!-- Footer con información de contacto -->
                    <div class="exito-card-footer">
                        <div class="contacto-info">
                            <div class="contacto-item">
                                <i class="fas fa-phone-alt"></i>
                                <span>01-800-COMPRAS</span>
                            </div>
                            <div class="contacto-item">
                                <i class="fas fa-envelope"></i>
                                <span>contacto@tienda.com</span>
                            </div>
                        </div>
                        <div class="coffee-beans-footer">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.onload = function() {
    // Descargar automáticamente después de 1.5 segundos
    setTimeout(function() {
        window.location.href = "{{ route('carrito.descargar-ticket') }}";
    }, 1500);
    
    // Manejar clic en botón de descarga
    const descargarBtn = document.getElementById('descargarBtn');
    if (descargarBtn) {
        descargarBtn.addEventListener('click', function(e) {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Descargando...';
            this.classList.add('downloading');
        });
    }
};
</script>

<style>
    /* ===== ESTILOS GENERALES (mismos que las demás páginas) ===== */
    .pago-exitoso-container {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(145deg, #faf0e6 0%, #f5e6d3 100%);
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        padding: 20px 0;
        overflow-x: hidden;
    }

    /* ===== ELEMENTOS DECORATIVOS - TAZAS BLANCAS ===== */
    .coffee-elements {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
    }

    .coffee-cup {
        position: absolute;
        opacity: 0.15;
        filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1));
    }

    .cup-1 {
        top: 30px;
        left: 30px;
        transform: scale(0.7);
    }

    .cup-2 {
        bottom: 30px;
        right: 30px;
        transform: scale(0.7) rotate(-10deg);
    }

    .cup-3 {
        top: 50%;
        right: 40px;
        transform: scale(0.6) translateY(-50%);
    }

    .white-cup {
        background: linear-gradient(145deg, #ffffff, #f8f8f8) !important;
    }

    .white-handle {
        border-color: #f0f0f0 !important;
        border-right: 6px solid #ffffff !important;
    }

    .cup-top {
        width: 60px;
        height: 15px;
        border-radius: 50%;
        background: linear-gradient(145deg, #ffffff, #f0f0f0);
    }

    .cup-body {
        width: 50px;
        height: 45px;
        border-radius: 0 0 25px 25px;
        background: linear-gradient(145deg, #ffffff, #f5f5f5);
        top: -7px;
        position: relative;
    }

    .cup-handle {
        width: 18px;
        height: 30px;
        border: 5px solid #f0f0f0;
        border-left: none;
        border-radius: 0 15px 15px 0;
        position: absolute;
        right: -15px;
        top: 10px;
    }

    .steam {
        position: absolute;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        animation: steam 3s infinite;
    }

    .s1 { width: 10px; height: 10px; top: -15px; left: 15px; }
    .s2 { width: 8px; height: 8px; top: -20px; left: 25px; animation-delay: 0.5s; }
    .s3 { width: 6px; height: 6px; top: -18px; left: 35px; animation-delay: 1s; }

    @keyframes steam {
        0%, 100% { transform: translateY(0) scale(1); opacity: 0.5; }
        50% { transform: translateY(-10px) scale(1.2); opacity: 0.2; }
    }

    /* Granos de café */
    .coffee-bean {
        position: absolute;
        width: 15px;
        height: 7px;
        background: #8B4513;
        border-radius: 50%;
        opacity: 0.1;
        animation: float 20s infinite linear;
        transform: rotate(45deg);
    }

    .bean-1 { top: 15%; left: 5%; animation-delay: 0s; }
    .bean-2 { bottom: 20%; right: 5%; animation-delay: 5s; }
    .bean-3 { top: 40%; left: 8%; animation-delay: 8s; }
    .bean-4 { bottom: 30%; right: 8%; animation-delay: 12s; }
    .bean-5 { top: 70%; left: 3%; animation-delay: 15s; }

    @keyframes float {
        from { transform: translateY(0) rotate(45deg); opacity: 0.1; }
        to { transform: translateY(-100vh) rotate(405deg); opacity: 0; }
    }

    /* Partículas */
    .particle {
        position: absolute;
        width: 3px;
        height: 3px;
        background: rgba(139, 69, 19, 0.2);
        border-radius: 50%;
        animation: particle-float 15s infinite linear;
    }

    .particle-1 { top: 20%; left: 15%; animation-delay: 0s; }
    .particle-2 { top: 60%; right: 10%; animation-delay: 5s; }
    .particle-3 { top: 80%; left: 20%; animation-delay: 10s; }

    @keyframes particle-float {
        from { transform: translateY(0) scale(1); opacity: 0.3; }
        to { transform: translateY(-100vh) scale(0); opacity: 0; }
    }

    /* ===== TARJETA PRINCIPAL ===== */
    .exito-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
        position: relative;
        z-index: 10;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.3);
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

    /* Header de la tarjeta */
    .exito-card-header {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
    }

    .exito-card-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
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

    .header-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .header-title h4 {
        margin: 0;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .header-title p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    .coffee-decoration-header {
        margin-left: auto;
        font-size: 1.5rem;
    }

    .coffee-decoration-header span {
        margin: 0 5px;
        animation: bounce 2s infinite;
    }

    .coffee-decoration-header span:nth-child(2) { animation-delay: 0.3s; }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    /* Cuerpo de la tarjeta */
    .exito-card-body {
        padding: 35px;
    }

    /* Footer de la tarjeta */
    .exito-card-footer {
        padding: 20px 30px;
        background: #f8f9fa;
        border-top: 2px dashed #e8d5c0;
    }

    .contacto-info {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .contacto-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #5D4037;
    }

    .contacto-item i {
        color: #8B4513;
    }

    .coffee-beans-footer {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .coffee-beans-footer span {
        width: 12px;
        height: 18px;
        background: var(--cafe-medio);
        border-radius: 50%;
        transform: rotate(45deg);
        animation: bounce-footer 2s infinite;
        display: inline-block;
        opacity: 0.5;
    }

    .coffee-beans-footer span:nth-child(2) { animation-delay: 0.2s; }
    .coffee-beans-footer span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes bounce-footer {
        0%, 100% { transform: rotate(45deg) translateY(0); }
        50% { transform: rotate(45deg) translateY(-5px); }
    }

    /* Animación de éxito */
    .success-animation {
        display: flex;
        justify-content: center;
        margin-bottom: 25px;
    }

    .success-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #28a745, #218838);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
        animation: pulse-success 2s infinite;
    }

    @keyframes pulse-success {
        0%, 100% { transform: scale(1); box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3); }
        50% { transform: scale(1.1); box-shadow: 0 15px 35px rgba(40, 167, 69, 0.5); }
    }

    .success-title {
        color: #28a745;
        font-weight: 700;
        text-align: center;
        margin-bottom: 5px;
        font-size: 1.8rem;
    }

    .success-subtitle {
        color: #6c757d;
        text-align: center;
        margin-bottom: 30px;
    }

    /* Detalles del pago */
    .detalles-pago {
        background: linear-gradient(145deg, #f8f4f0, #f0e8e0);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .detalles-pago h5 {
        color: #5D4037;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detalles-pago h5 i {
        color: #8B4513;
    }

    .detalle-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e8d5c0;
    }

    .detalle-item:last-child {
        border-bottom: none;
    }

    .detalle-label {
        color: #5D4037;
        font-weight: 500;
    }

    .detalle-valor {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .detalle-valor.total {
        color: #28a745;
    }

    .detalle-valor.efectivo {
        color: #17a2b8;
    }

    .detalle-valor.cambio {
        color: #ffc107;
    }

    /* Ticket info */
    .ticket-info {
        background: linear-gradient(145deg, #e8f4fd, #d1e7ff);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
        border-left: 6px solid #17a2b8;
    }

    .ticket-icon {
        width: 50px;
        height: 50px;
        background: #17a2b8;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .ticket-text {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .ticket-text strong {
        color: #0c5460;
        margin-bottom: 3px;
    }

    .ticket-text span {
        color: #0c5460;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* Botones de acción */
    .action-buttons-row {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .btn-seguir-comprando, .btn-descargar-ticket {
        flex: 1;
        padding: 14px 20px;
        border: none;
        border-radius: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .btn-seguir-comprando {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
    }

    .btn-descargar-ticket {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .btn-seguir-comprando:hover, .btn-descargar-ticket:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        color: white;
    }

    .btn-descargar-ticket.downloading {
        opacity: 0.8;
        cursor: not-allowed;
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

    .btn-seguir-comprando:hover .btn-overlay,
    .btn-descargar-ticket:hover .btn-overlay {
        width: 300px;
        height: 300px;
    }

    /* Fecha */
    .fecha-info {
        text-align: center;
        color: #6c757d;
        font-size: 0.9rem;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .fecha-info i {
        margin-right: 5px;
        color: #8B4513;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .coffee-cup {
            display: none;
        }
        
        .exito-card-header {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        
        .coffee-decoration-header {
            margin: 0 auto;
        }
        
        .exito-card-body {
            padding: 25px;
        }
        
        .action-buttons-row {
            flex-direction: column;
        }
        
        .contacto-info {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }
        
        .ticket-info {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@endsection