@extends('layouts.app')

@section('content')
<div class="detalle-container">
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

    <div class="container py-4">
        <!-- Header estilo inventario con botón volver -->
        <div class="detalle-header">
            <div class="header-icon">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="header-title">
                <h4><i class="fas fa-ticket-alt"></i> Detalle de Venta</h4>
                <p>Información completa de la operación</p>
            </div>
            <div class="coffee-decoration-header">
                <span>🧾</span>
                <span>☕</span>
                <span>📄</span>
            </div>
            <a href="{{ route('ventas.index') }}" class="btn-volver">
                <i class="fas fa-arrow-left me-1"></i> Volver al historial
            </a>
        </div>

        <!-- Tarjeta principal -->
        <div class="detalle-card">
            <div class="row g-4">
                <!-- Columna izquierda: Detalle de operación y productos -->
                <div class="col-lg-7">
                    <div class="info-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0" style="color: #5D4037;">
                                <i class="fas fa-clipboard-list me-2" style="color: #8B4513;"></i>Detalle de Operación
                            </h5>
                            <span class="badge-estado {{ strtolower($venta->estado ?? 'pendiente') }}">
                                {{ $venta->estado ?? 'PENDIENTE' }}
                            </span>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <label class="text-muted small d-block">Fecha de Emisión</label>
                                <span class="fw-bold">
                                    {{ $venta->created_at ? $venta->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </span>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small d-block">Número de Mesa</label>
                                <span class="mesa-badge">Mesa #{{ $venta->mesa }}</span>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small d-block">Folio Interno</label>
                                <span class="folio-badge">#{{ str_pad($venta->id, 8, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small d-block">Atendido por</label>
                                <span class="fw-bold">Sistema CaféSoft</span>
                            </div>
                        </div>

                        <hr class="my-4" style="border-top: 1px dashed #d9b382; opacity: 0.5;">

                        <h5 class="fw-bold mb-3" style="color: #5D4037;">
                            <i class="fas fa-coffee me-2" style="color: #8B4513;"></i>Productos Consumidos
                        </h5>
                        <div class="table-responsive">
                            <table class="table productos-table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Cant.</th>
                                        <th class="text-end">Precio</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($venta->productos as $p)
                                    <tr>
                                        <td class="fw-bold">{{ $p['nombre'] }}</td>
                                        <td class="text-center">{{ $p['cantidad'] }}</td>
                                        <td class="text-end">${{ number_format($p['precio'], 2) }}</td>
                                        <td class="text-end fw-bold">${{ number_format($p['cantidad'] * $p['precio'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha: Ticket estilo recibo -->
                <div class="col-lg-5">
                    <div class="ticket-card">
                        <div class="ticket-header">
                            <h5 class="fw-bold mb-0">CAFÉSOFT</h5>
                            <small class="d-block">Lerma, Estado de México</small>
                            <small>RFC: UT-VALLE-12345</small>
                        </div>

                        <div class="ticket-info">
                            <div class="d-flex justify-content-between small">
                                <span>Ticket: #{{ $venta->id }}</span>
                                <span>Mesa: {{ $venta->mesa }}</span>
                            </div>
                        </div>

                        <div class="ticket-items">
                            @foreach($venta->productos as $p)
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>{{ $p['cantidad'] }}x {{ substr($p['nombre'], 0, 20) }}</span>
                                <span>${{ number_format($p['cantidad'] * $p['precio'], 2) }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="ticket-total">
                            <div class="d-flex justify-content-between fw-bold h5">
                                <span>TOTAL</span>
                                <span>${{ number_format($venta->total, 2) }}</span>
                            </div>
                        </div>

                        <div class="ticket-footer">
                            <p class="small mb-0">¡Gracias por tu visita!</p>
                            <small>Vuelve pronto a CaféSoft</small>
                        </div>

                        <button class="btn-imprimir" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Imprimir Recibo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== Mismos estilos decorativos que en inventario/ventas ===== */
    .detalle-container {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(145deg, #faf0e6 0%, #f5e6d3 100%);
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        padding: 20px 0;
        overflow-x: hidden;
    }

    /* Elementos decorativos (copiados) */
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
    }

    .cup-1 { top: 30px; left: 30px; transform: scale(0.7); }
    .cup-2 { bottom: 30px; right: 30px; transform: scale(0.7) rotate(-10deg); }
    .cup-3 { top: 50%; right: 40px; transform: scale(0.6) translateY(-50%); }

    .white-cup { background: linear-gradient(145deg, #ffffff, #f8f8f8) !important; }
    .white-handle { border-color: #f0f0f0 !important; border-right: 6px solid #ffffff !important; }

    .cup-top { width: 60px; height: 15px; border-radius: 50%; background: linear-gradient(145deg, #ffffff, #f0f0f0); }
    .cup-body { width: 50px; height: 45px; border-radius: 0 0 25px 25px; background: linear-gradient(145deg, #ffffff, #f5f5f5); top: -7px; position: relative; }
    .cup-handle { width: 18px; height: 30px; border: 5px solid #f0f0f0; border-left: none; border-radius: 0 15px 15px 0; position: absolute; right: -15px; top: 10px; }

    .steam { position: absolute; background: rgba(255,255,255,0.5); border-radius: 50%; animation: steam 3s infinite; }
    .s1 { width: 10px; height: 10px; top: -15px; left: 15px; }
    .s2 { width: 8px; height: 8px; top: -20px; left: 25px; animation-delay: 0.5s; }
    .s3 { width: 6px; height: 6px; top: -18px; left: 35px; animation-delay: 1s; }

    @keyframes steam {
        0%,100% { transform: translateY(0) scale(1); opacity: 0.5; }
        50% { transform: translateY(-10px) scale(1.2); opacity: 0.2; }
    }

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

    .particle {
        position: absolute;
        width: 3px;
        height: 3px;
        background: rgba(139,69,19,0.2);
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

    /* Header estilo inventario */
    .detalle-header {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
        border-radius: 30px 30px 0 0;
        z-index: 10;
        flex-wrap: wrap;
    }

    .detalle-header::after {
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
        display: inline-block;
    }

    @keyframes bounce {
        0%,100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .btn-volver {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(5px);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        padding: 10px 20px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-volver:hover {
        background: #D4AF37;
        border-color: #D4AF37;
        color: #2c1a0b;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Tarjeta principal */
    .detalle-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 0 0 30px 30px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        z-index: 10;
        position: relative;
    }

    /* Info card (izquierda) */
    .info-card {
        background: #fefcf9;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        border: 1px solid rgba(139, 69, 19, 0.1);
        height: 100%;
    }

    .badge-estado {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-estado.completada {
        background: #28a745;
        color: white;
    }

    .badge-estado.pendiente {
        background: #ffc107;
        color: #212529;
    }

    .badge-estado.cancelada {
        background: #dc3545;
        color: white;
    }

    .mesa-badge {
        background: #f0e4d5;
        color: #8B4513;
        padding: 5px 12px;
        border-radius: 30px;
        font-weight: 500;
    }

    .folio-badge {
        background: #8B4513;
        color: white;
        padding: 5px 12px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-block;
    }

    /* Tabla de productos */
    .productos-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 5px;
    }

    .productos-table thead th {
        background: #f8f4f0;
        color: #5D4037;
        padding: 10px;
        font-weight: 600;
        border-radius: 10px;
        font-size: 0.9rem;
    }

    .productos-table tbody tr {
        background: #fefcf9;
        border-radius: 10px;
    }

    .productos-table tbody td {
        padding: 10px;
        border-bottom: 1px solid #f0e4d5;
    }

    /* Ticket card (derecha) */
    .ticket-card {
        background: #fefcf9;
        border-radius: 5px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        border: 1px solid rgba(139, 69, 19, 0.1);
        border-top: 8px solid #8B4513 !important;
        max-width: 350px;
        margin: 0 auto;
    }

    .ticket-header {
        text-align: center;
        margin-bottom: 15px;
    }

    .ticket-header h5 {
        color: #8B4513;
        font-weight: 700;
    }

    .ticket-header small {
        color: #6b4f3a;
        font-size: 0.8rem;
    }

    .ticket-info {
        border-top: 1px dashed #d9b382;
        border-bottom: 1px dashed #d9b382;
        padding: 10px 0;
        margin-bottom: 15px;
    }

    .ticket-items {
        margin-bottom: 15px;
    }

    .ticket-total {
        border-top: 1px dashed #d9b382;
        padding-top: 10px;
        margin-top: 10px;
    }

    .ticket-total .h5 {
        color: #8B4513;
        font-weight: 700;
    }

    .ticket-footer {
        text-align: center;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #f0e4d5;
    }

    .ticket-footer p {
        color: #8B4513;
        font-weight: 500;
    }

    .btn-imprimir {
        background: linear-gradient(145deg, #8B4513, #A0522D);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 50px;
        font-weight: 600;
        width: 100%;
        margin-top: 20px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-imprimir:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
    }

    /* Estilo para impresión */
    @media print {
        body * { visibility: hidden; }
        .ticket-card, .ticket-card * { visibility: visible; }
        .ticket-card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: 100%;
            box-shadow: none;
            border: none;
        }
        .btn-imprimir { display: none; }
        .detalle-header, .info-card, .coffee-elements { display: none; }
    }

    /* Responsividad */
    @media (max-width: 768px) {
        .coffee-cup {
            display: none;
        }

        .detalle-header {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .coffee-decoration-header {
            margin: 0 auto;
        }

        .btn-volver {
            width: 100%;
            justify-content: center;
        }

        .detalle-card {
            padding: 20px;
        }

        .ticket-card {
            max-width: 100%;
        }
    }
</style>

<!-- Fonts & Icons (si no están en layouts.app) -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection