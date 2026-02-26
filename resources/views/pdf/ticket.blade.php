<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Compra - {{ $pedido['numero_pedido'] }}</title>
    <style>
        /* Reset y estilos base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Courier New', monospace;
            font-size: 13px;
            width: 80mm;
            min-height: 100vh;
            margin: 0 auto;
            padding: 10px 8px;
            background: #faf7f2;
            color: #2c1810;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Tarjeta principal del ticket (efecto papel) */
        .ticket-card {
            background: white;
            border-radius: 24px 24px 16px 16px;
            padding: 20px 16px;
            box-shadow: 
                0 10px 25px -8px rgba(0,0,0,0.2),
                inset 0 2px 0 rgba(255,255,255,0.8);
            border: 1px solid rgba(139, 69, 19, 0.15);
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        /* Decoración superior tipo café */
        .ticket-header {
            text-align: center;
            margin-bottom: 16px;
            position: relative;
        }

        .brand-icon {
            font-size: 32px;
            line-height: 1;
            margin-bottom: 6px;
            filter: drop-shadow(0 4px 6px rgba(139, 69, 19, 0.2));
        }

        .brand-name {
            font-weight: 800;
            font-size: 22px;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
            line-height: 1.2;
        }

        .brand-slogan {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #A0522D;
            opacity: 0.7;
            margin-top: 2px;
        }

        .store-details {
            background: rgba(212, 175, 55, 0.08);
            border-radius: 30px;
            padding: 8px 12px;
            margin-top: 12px;
            font-size: 10px;
            color: #5D4037;
            display: flex;
            flex-direction: column;
            gap: 3px;
            border: 1px dashed rgba(139, 69, 19, 0.2);
        }

        .store-details i {
            color: #D4AF37;
            margin-right: 4px;
        }

        /* Línea divisoria decorativa */
        .divider {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 16px 0;
            color: #D4AF37;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #8B4513, #D4AF37, #8B4513, transparent);
        }

        .divider-icon {
            font-size: 14px;
        }

        /* Info del ticket */
        .ticket-info-grid {
            background: #fcf9f5;
            border-radius: 18px;
            padding: 12px;
            margin-bottom: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            border: 1px solid rgba(139, 69, 19, 0.1);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-label {
            color: #8B4513;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .info-value {
            font-weight: 700;
            color: #2c1810;
            background: white;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        /* Tabla de productos */
        .products-title {
            font-weight: 700;
            color: #8B4513;
            margin-bottom: 10px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table th {
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            color: #A0522D;
            padding-bottom: 6px;
            border-bottom: 1px dashed rgba(139, 69, 19, 0.2);
        }

        .products-table td {
            padding: 6px 0;
            border-bottom: 1px dotted rgba(139, 69, 19, 0.1);
        }

        .product-name {
            font-weight: 600;
            color: #2c1810;
        }

        .product-qty {
            color: #8B4513;
            font-size: 11px;
            display: block;
        }

        .product-price {
            font-weight: 700;
            color: #2c1810;
            text-align: right;
        }

        /* Totales */
        .totals-section {
            margin: 16px 0 12px;
            padding: 12px;
            background: linear-gradient(145deg, #fff, #fcf9f5);
            border-radius: 20px;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
        }

        .total-row.final {
            border-top: 2px solid #8B4513;
            margin-top: 6px;
            padding-top: 10px;
            font-weight: 800;
            font-size: 16px;
            color: #8B4513;
        }

        .total-label {
            font-weight: 600;
            color: #5D4037;
        }

        .total-value {
            font-weight: 700;
            background: rgba(139, 69, 19, 0.1);
            padding: 4px 12px;
            border-radius: 40px;
        }

        /* Método de pago */
        .payment-info {
            display: flex;
            justify-content: space-between;
            background: #e8e0d5;
            padding: 8px 12px;
            border-radius: 40px;
            margin: 12px 0;
            font-size: 11px;
            font-weight: 600;
        }

        /* Mensaje de agradecimiento */
        .thank-you-message {
            text-align: center;
            margin: 20px 0 12px;
            position: relative;
        }

        .thank-you-message span {
            background: linear-gradient(135deg, #8B4513, #D2691E);
            color: white;
            padding: 8px 24px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.5px;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
            border: 1px solid #D4AF37;
        }

        /* Footer */
        .ticket-footer {
            text-align: center;
            margin-top: 16px;
            font-size: 9px;
            color: #5D4037;
            opacity: 0.7;
        }

        .footer-icons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 12px 0 6px;
            color: #D4AF37;
            font-size: 14px;
        }

        .barcode {
            font-family: 'Libre Barcode 39', cursive;
            font-size: 28px;
            color: #2c1810;
            margin: 8px 0;
            letter-spacing: 2px;
        }

        /* Efecto de sombra tipo ticket */
        .ticket-card::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 5%;
            width: 90%;
            height: 10px;
            background: rgba(0,0,0,0.1);
            filter: blur(5px);
            border-radius: 50%;
            z-index: -1;
        }

        /* Responsive */
        @media print {
            body { background: white; }
            .ticket-card { box-shadow: none; border: 1px solid #ccc; }
        }
    </style>
    <!-- Fonts e iconos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Libre+Barcode+39&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="ticket-card">
        <!-- HEADER CAFETERO -->
        <div class="ticket-header">
            <div class="brand-icon">
                <i class="fas fa-mug-hot" style="color: #8B4513;"></i>
                <i class="fas fa-seedling" style="color: #D4AF37; font-size: 20px; margin-left: -8px;"></i>
            </div>
            <h1 class="brand-name">COFFESOFT</h1>
            <div class="brand-slogan">SPECIALTY COFFEE · SINCE 2024</div>
            
            <div class="store-details">
                <span><i class="fas fa-map-pin"></i> Av. Principal #123, San Ángel, CDMX</span>
                <span><i class="fas fa-phone-alt"></i> 555-1234 · RFC: XXXX010101XXX</span>
                <span><i class="fas fa-clock"></i> Ticket: {{ $pedido['numero_pedido'] }}</span>
            </div>
        </div>

        <!-- INFO DEL TICKET CON ESTILO -->
        <div class="ticket-info-grid">
            <div class="info-row">
                <span class="info-label"><i class="far fa-calendar-alt" style="margin-right: 4px;"></i> FECHA</span>
                <span class="info-value">{{ $pedido['fecha'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-user-tie"></i> CAJERO</span>
                <span class="info-value">{{ $usuario->nombre ?? 'Sistema' }}</span>
            </div>
        </div>

        <!-- DETALLE DE PRODUCTOS -->
        <div class="products-title">
            <i class="fas fa-receipt"></i> DETALLE DE COMPRA
        </div>

        <table class="products-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="text-align: center;">Cant</th>
                    <th style="text-align: right;">Importe</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrito as $id => $item)
                <tr>
                    <td>
                        <span class="product-name">{{ $item['nombre'] }}</span>
                    </td>
                    <td style="text-align: center;">
                        <span class="product-qty">x{{ $item['cantidad'] }}</span>
                    </td>
                    <td class="product-price">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- SECCIÓN DE TOTALES -->
        <div class="totals-section">
            <div class="total-row">
                <span class="total-label">SUBTOTAL</span>
                <span class="total-value">${{ number_format($total, 2) }}</span>
            </div>
            <div class="total-row">
                <span class="total-label">IVA (16%)</span>
                <span class="total-value">${{ number_format($total * 0.16, 2) }}</span>
            </div>
            <div class="total-row final">
                <span class="total-label">TOTAL</span>
                <span class="total-value">${{ number_format($total * 1.16, 2) }}</span>
            </div>
        </div>

        <!-- MÉTODO DE PAGO Y CAMBIO -->
        <div class="payment-info">
            <span><i class="fas fa-money-bill-wave"></i> EFECTIVO</span>
            <span>${{ number_format($efectivo, 2) }}</span>
        </div>
        
        <div class="payment-info" style="background: #f5e6d3; margin-top: -5px;">
            <span><i class="fas fa-undo-alt"></i> CAMBIO</span>
            <span style="font-weight: 800; color: #8B4513;">${{ number_format($cambio, 2) }}</span>
        </div>

        <!-- DIVISOR CON CAFÉ -->
        <div class="divider">
            <span class="divider-line"></span>
            <span class="divider-icon"><i class="fas fa-coffee"></i></span>
            <span class="divider-line"></span>
        </div>

        <!-- AGRADECIMIENTO CAFETERO -->
        <div class="thank-you-message">
            <span>☕ ¡GRACIAS POR SU COMPRA! ☕</span>
        </div>

        <!-- FOOTER CON CÓDIGO DE BARRAS -->
        <div class="barcode">
            *{{ $pedido['numero_pedido'] }}*
        </div>

        <div class="ticket-footer">
            <div class="footer-icons">
                <i class="fas fa-truck"></i>
                <i class="fas fa-mug-saucer"></i>
                <i class="fas fa-heart"></i>
            </div>
            <p>** Ticket válido como comprobante fiscal **</p>
            <p>Conserve este ticket para cualquier aclaración</p>
            <p>--------------------------------</p>
            <p style="font-weight: 600;">Powered by Laravel POS · Café Sofft</p>
            <p style="font-size: 8px; margin-top: 5px;">#{{ $pedido['numero_pedido'] }} | {{ date('H:i:s') }}</p>
        </div>
    </div>

    <!-- Script opcional para impresión automática -->
    <script>
        window.onload = function() {
            // Pequeño retraso para asegurar renderizado
            setTimeout(function() {
                window.print();
            }, 100);
        };
    </script>
</body>
</html>