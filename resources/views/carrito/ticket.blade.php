@extends('layouts.app')

@section('content')
<div class="ticket-container">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="ticket-card">
                    <div class="ticket-header">
                        <div class="coffee-logo">
                            <i class="fas fa-mug-hot"></i>
                        </div>
                        <h2>¡Pedido Confirmado!</h2>
                        <p>Tu orden ha sido registrada exitosamente</p>
                    </div>

                    <div class="ticket-body">
                        <div class="ticket-info">
                            <div class="info-row">
                                <span>Folio:</span>
                                <strong>#{{ $venta->folio }}</strong>
                            </div>
                            <div class="info-row">
                                <span>Mesa:</span>
                                <strong class="mesa-destacada">{{ $venta->mesa }}</strong>
                            </div>
                            <div class="info-row">
                                <span>Fecha:</span>
                                <strong>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</strong>
                            </div>
                        </div>

                        <div class="ticket-productos">
                            <h5>Productos</h5>
                            @foreach($venta->productos as $producto)
                            <div class="producto-row">
                                <div class="producto-detalle">
                                    <span class="producto-nombre">{{ $producto['nombre'] }}</span>
                                    <span class="producto-cantidad">x{{ $producto['cantidad'] }}</span>
                                </div>
                                <span class="producto-precio">${{ number_format($producto['subtotal'], 2) }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="ticket-totales">
                            <div class="total-row">
                                <span>Total:</span>
                                <strong>${{ number_format($venta->total, 2) }}</strong>
                            </div>
                            <div class="total-row">
                                <span>Efectivo:</span>
                                <strong>${{ number_format($venta->efectivo_recibido, 2) }}</strong>
                            </div>
                            <div class="total-row cambio">
                                <span>Cambio:</span>
                                <strong>${{ number_format($venta->cambio, 2) }}</strong>
                            </div>
                        </div>

                        <div class="ticket-mensaje">
                            <i class="fas fa-bell"></i>
                            <p>El mesero llevará tu orden a la <strong>Mesa {{ $venta->mesa }}</strong></p>
                        </div>
                    </div>

                    <div class="ticket-footer">
                        <a href="{{ URL('/carrito') }}" class="btn-volver-inicio">
                            <i class="fas fa-home"></i> Volver al Inicio
                        </a>
                        <button onclick="window.print()" class="btn-imprimir">
                            <i class="fas fa-print"></i> Imprimir Ticket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.ticket-container {
    min-height: 100vh;
    background: linear-gradient(145deg, #faf0e6 0%, #f5e6d3 100%);
    padding: 20px 0;
    font-family: 'Poppins', sans-serif;
}

.ticket-card {
    background: white;
    border-radius: 30px;
    box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
    overflow: hidden;
    animation: slideIn 0.5s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.ticket-header {
    background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
    color: white;
    padding: 30px;
    text-align: center;
}

.coffee-logo {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2.5rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.ticket-header h2 {
    font-weight: 700;
    margin-bottom: 10px;
}

.ticket-header p {
    opacity: 0.9;
    margin: 0;
}

.ticket-body {
    padding: 30px;
}

.ticket-info {
    background: linear-gradient(145deg, #f8f4f0, #f0e8e0);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 25px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px dashed #e8d5c0;
}

.info-row:last-child {
    border-bottom: none;
}

.mesa-destacada {
    background: #8B4513;
    color: white;
    padding: 5px 15px;
    border-radius: 25px;
    font-size: 1.2rem;
}

.ticket-productos {
    margin-bottom: 25px;
}

.ticket-productos h5 {
    color: #5D4037;
    font-weight: 700;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #8B4513;
}

.producto-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #e8d5c0;
}

.producto-detalle {
    display: flex;
    align-items: center;
    gap: 10px;
}

.producto-nombre {
    font-weight: 600;
    color: #5D4037;
}

.producto-cantidad {
    color: #8B4513;
    font-size: 0.9rem;
    background: #f8f4f0;
    padding: 2px 8px;
    border-radius: 20px;
}

.producto-precio {
    font-weight: 600;
    color: #28a745;
}

.ticket-totales {
    background: #f8f4f0;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 25px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 1.1rem;
}

.total-row.cambio {
    border-top: 2px solid #8B4513;
    margin-top: 8px;
    padding-top: 15px;
    color: #ffc107;
    font-weight: 700;
}

.ticket-mensaje {
    background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    color: #2e7d32;
}

.ticket-mensaje i {
    font-size: 2rem;
    margin-bottom: 10px;
}

.ticket-mensaje p {
    margin: 0;
    font-weight: 500;
}

.ticket-footer {
    padding: 20px 30px;
    background: #f8f9fa;
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-volver-inicio, .btn-imprimir {
    padding: 12px 25px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-volver-inicio {
    background: linear-gradient(145deg, #6c757d, #5a6268);
    color: white;
}

.btn-imprimir {
    background: linear-gradient(135deg, #8B4513, #A0522D);
    color: white;
    border: none;
    cursor: pointer;
}

.btn-volver-inicio:hover, .btn-imprimir:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    color: white;
}

@media print {
    .ticket-footer, .btn-volver-inicio, .btn-imprimir {
        display: none;
    }
    
    .ticket-card {
        box-shadow: none;
        border: 1px solid #ddd;
    }
}
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection