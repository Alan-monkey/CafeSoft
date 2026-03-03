@extends('layouts.app')
@section('content')

<div class="carrito-container">
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
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <!-- Tarjeta principal -->
                <div class="carrito-card">
                    <div class="carrito-header">
                        <div class="header-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="header-title">
                            <h4><i class="fas fa-coffee"></i> Carrito de Compras</h4>
                            <p>Revisa tus productos antes de pagar</p>
                        </div>
                        <div class="coffee-decoration-header">
                            <span>🛒</span>
                            <span>☕</span>
                            <span>💰</span>
                        </div>
                    </div>

                    <div class="carrito-body">
                        <!-- Alertas -->
                        @if(session('success'))
                            <div class="alert-modern alert-success-modern mb-4">
                                <i class="fas fa-check-circle"></i>
                                <div class="alert-content">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert-modern alert-error-modern mb-4">
                                <i class="fas fa-exclamation-circle"></i>
                                <div class="alert-content">
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif

                        @if(empty($carrito))
                            <!-- ===== CARRITO VACÍO ===== -->
                            <div class="empty-cart">
                                <div class="empty-cart-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <h3>Tu carrito está vacío</h3>
                                <p>Agrega algunos productos deliciosos para continuar</p>
                                <a href="/inicio" class="btn-ver-productos">
                                    <i class="fas fa-coffee"></i> Ver Productos
                                </a>
                            </div>

                            <!-- ===== PRODUCTOS SUGERIDOS (CUANDO CARRITO VACÍO) ===== -->
                            <div class="productos-sugeridos mt-5">
                                <div class="seccion-header">
                                    <div class="header-decoration">
                                        <i class="fas fa-mug-hot"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-mug-hot"></i>
                                    </div>
                                    <h3>Productos disponibles</h3>
                                    <p>Comienza a llenar tu carrito con nuestras delicias</p>
                                </div>

                                <div class="productos-grid">
                                    @foreach($productos as $producto)
                                        @php
                                            $inventario = \App\Models\Inventario::where('producto_id', $producto->_id)->first();
                                            $stock = $inventario ? $inventario->stock_actual : 0;
                                        @endphp
                                        
                                        @if($stock > 0)
                                            <div class="producto-card-sugerido">
                                                <div class="producto-imagen-sugerido">
                                                    @if($producto->imagen)
                                                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                                                    @else
                                                        <div class="sugerido-placeholder">
                                                            <i class="fas fa-coffee"></i>
                                                        </div>
                                                    @endif
                                                    @if($stock < 10)
                                                        <span class="badge-stock-bajo">¡Últimos {{ $stock }}!</span>
                                                    @endif
                                                </div>
                                                <div class="producto-info-sugerido">
                                                    <h5>{{ $producto->nombre }}</h5>
                                                    <p class="sugerido-descripcion">{{ Str::limit($producto->descripcion, 50) }}</p>
                                                    <div class="sugerido-footer">
                                                        <span class="sugerido-precio">${{ number_format($producto->precio, 2) }}</span>
                                                        <form action="{{ route('carrito.agregar', $producto->_id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn-agregar-sugerido" title="Agregar al carrito">
                                                                <i class="fas fa-cart-plus"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- ===== TABLA DE PRODUCTOS EN CARRITO ===== -->
                            <div class="table-responsive">
                                <table class="table carrito-table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach($carrito as $id => $item)
                                            @php 
                                                $subtotal = $item['precio'] * $item['cantidad'];
                                                $total += $subtotal;
                                            @endphp
                                            <tr class="producto-row">
                                                <td data-label="Producto">
                                                    <div class="producto-info">
                                                        @if(!empty($item['imagen']))
                                                            <img src="{{ asset('storage/' . $item['imagen']) }}" 
                                                                 alt="{{ $item['nombre'] }}" 
                                                                 class="producto-img">
                                                        @else
                                                            <div class="producto-img-placeholder">
                                                                <i class="fas fa-coffee"></i>
                                                            </div>
                                                        @endif
                                                        <div class="producto-detalles">
                                                            <span class="producto-nombre">{{ $item['nombre'] }}</span>
                                                            @if(isset($item['stock_disponible']))
                                                                <small class="stock-info">
                                                                    <i class="fas fa-boxes"></i> 
                                                                    Disponible: {{ $item['stock_disponible'] }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-label="Precio">
                                                    <span class="precio-cell">${{ number_format($item['precio'], 2) }}</span>
                                                </td>
                                                <td data-label="Cantidad">
                                                    <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="cantidad-form">
                                                        @csrf
                                                        <div class="cantidad-control">
                                                            <button type="button" class="btn-cantidad disminuir" onclick="disminuirCantidad(this)">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" 
                                                                   min="1" max="99" class="input-cantidad" readonly>
                                                            <button type="button" class="btn-cantidad aumentar" onclick="aumentarCantidad(this)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <button type="submit" class="btn-actualizar" style="display: none;">Actualizar</button>
                                                    </form>
                                                </td>
                                                <td data-label="Subtotal">
                                                    <span class="subtotal-cell">${{ number_format($subtotal, 2) }}</span>
                                                </td>
                                                <td data-label="Acciones">
                                                    <div class="acciones-cell">
                                                        <a href="{{ route('carrito.eliminar', $id) }}" 
                                                           class="btn-eliminar"
                                                           onclick="return confirm('¿Eliminar este producto del carrito?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="total-row">
                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                            <td colspan="2">
                                                <span class="total-cell">${{ number_format($total, 2) }}</span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- ===== ACCIONES DEL CARRITO ===== -->
                            <div class="carrito-actions">
                                <div class="actions-left">
                                    <a href="{{ route('carrito.vaciar') }}" class="btn-vaciar" 
                                       onclick="return confirm('¿Vaciar todo el carrito?')">
                                        <i class="fas fa-trash-alt"></i> Vaciar Carrito
                                    </a>
                                </div>
                                <div class="actions-right">
                                    <a href="/inicio" class="btn-seguir">
                                        <i class="fas fa-plus-circle"></i> Seguir Comprando
                                    </a>
                                    <a href="{{ route('carrito.mostrar-pago') }}" class="btn-pagar">
                                        <i class="fas fa-credit-card"></i> Proceder al Pago
                                    </a>
                                </div>
                            </div>

                            <!-- ===== RESUMEN DEL CARRITO ===== -->
                            <div class="carrito-resumen">
                                <div class="resumen-item">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="resumen-item">
                                    <span>Envío:</span>
                                    <span class="text-success">Gratis</span>
                                </div>
                                <div class="resumen-item total">
                                    <span>Total a pagar:</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <!-- ===== PRODUCTOS DESTACADOS PARA AGREGAR MÁS ===== -->
                            <div class="productos-destacados mt-5">
                                <div class="seccion-header">
                                    <div class="header-decoration">
                                        <i class="fas fa-coffee"></i>
                                        <i class="fas fa-plus-circle"></i>
                                        <i class="fas fa-coffee"></i>
                                    </div>
                                    <h3>¿Quieres agregar más productos?</h3>
                                    <p>Selecciona de nuestros productos destacados</p>
                                </div>

                                <div class="productos-grid-mini">
                                    @foreach($productos as $producto)
                                        @php
                                            // Verificar si ya está en el carrito
                                            $enCarrito = isset($carrito[$producto->_id]);
                                            // Obtener inventario
                                            $inventario = \App\Models\Inventario::where('producto_id', $producto->_id)->first();
                                            $stock = $inventario ? $inventario->stock_actual : 0;
                                        @endphp
                                        
                                        @if(!$enCarrito && $stock > 0)
                                            <div class="producto-mini-card">
                                                <div class="producto-mini-imagen">
                                                    @if($producto->imagen)
                                                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                                                    @else
                                                        <div class="mini-placeholder">
                                                            <i class="fas fa-coffee"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="producto-mini-info">
                                                    <h5>{{ $producto->nombre }}</h5>
                                                    <span class="mini-precio">${{ number_format($producto->precio, 2) }}</span>
                                                    <small class="mini-stock">
                                                        <i class="fas fa-boxes"></i> {{ $stock }} disponibles
                                                    </small>
                                                    <form action="{{ route('carrito.agregar', $producto->_id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-agregar-mini">
                                                            <i class="fas fa-cart-plus"></i> Agregar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="ver-mas-container text-center mt-4">
                                    <a href="/inicio" class="btn-ver-mas">
                                        <i class="fas fa-eye"></i> Ver todos los productos
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Footer con decoración -->
                    <div class="carrito-footer">
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

<!-- Script para manejar cantidades -->
<script>
function disminuirCantidad(btn) {
    const form = btn.closest('.cantidad-form');
    const input = form.querySelector('.input-cantidad');
    let valor = parseInt(input.value);
    if (valor > 1) {
        input.value = valor - 1;
        form.submit();
    }
}

function aumentarCantidad(btn) {
    const form = btn.closest('.cantidad-form');
    const input = form.querySelector('.input-cantidad');
    let valor = parseInt(input.value);
    if (valor < 99) {
        input.value = valor + 1;
        form.submit();
    }
}

// Auto-submit cuando cambia la cantidad manualmente
document.querySelectorAll('.input-cantidad').forEach(input => {
    input.addEventListener('change', function() {
        if (this.value >= 1 && this.value <= 99) {
            this.closest('form').submit();
        }
    });
});
</script>

<style>
    /* ===== MOBILE-FIRST: ESTILOS GENERALES ===== */
    .carrito-container {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(145deg, #faf0e6 0%, #f5e6d3 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        padding: 10px;
        overflow-x: hidden;
    }

    /* ===== ELEMENTOS DECORATIVOS - OCULTOS EN MÓVIL ===== */
    .coffee-elements {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
        display: none; /* Oculto por defecto en móvil */
    }

    /* Mostrar decoraciones solo en desktop */
    @media (min-width: 1024px) {
        .coffee-elements {
            display: block;
        }
    }

    .coffee-cup {
        position: absolute;
        opacity: 0.1;
        filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1));
    }

    .cup-1 { top: 30px; left: 30px; transform: scale(0.5); }
    .cup-2 { bottom: 30px; right: 30px; transform: scale(0.5) rotate(-10deg); }
    .cup-3 { top: 50%; right: 40px; transform: scale(0.4) translateY(-50%); }

    .white-cup { background: linear-gradient(145deg, #ffffff, #f8f8f8) !important; }
    .white-handle { border-color: #f0f0f0 !important; border-right: 6px solid #ffffff !important; }

    .cup-top { width: 60px; height: 15px; border-radius: 50%; background: linear-gradient(145deg, #ffffff, #f0f0f0); }
    .cup-body { width: 50px; height: 45px; border-radius: 0 0 25px 25px; background: linear-gradient(145deg, #ffffff, #f5f5f5); top: -7px; position: relative; }
    .cup-handle { width: 18px; height: 30px; border: 5px solid #f0f0f0; border-left: none; border-radius: 0 15px 15px 0; position: absolute; right: -15px; top: 10px; }

    .steam {
        position: absolute;
        background: rgba(255,255,255,0.5);
        border-radius: 50%;
        animation: steam 3s infinite;
    }

    .s1 { width: 10px; height: 10px; top: -15px; left: 15px; }
    .s2 { width: 8px; height: 8px; top: -20px; left: 25px; animation-delay: 0.5s; }
    .s3 { width: 6px; height: 6px; top: -18px; left: 35px; animation-delay: 1s; }

    @keyframes steam {
        0%,100% { transform: translateY(0) scale(1); opacity: 0.5; }
        50% { transform: translateY(-10px) scale(1.2); opacity: 0.2; }
    }

    .coffee-bean, .particle {
        position: absolute;
        opacity: 0.08;
    }

    .coffee-bean {
        width: 12px;
        height: 6px;
        background: #8B4513;
        border-radius: 50%;
        animation: float 20s infinite linear;
        transform: rotate(45deg);
    }

    .bean-1 { top: 15%; left: 5%; animation-delay: 0s; }
    .bean-2 { bottom: 20%; right: 5%; animation-delay: 5s; }
    .bean-3 { top: 40%; left: 8%; animation-delay: 8s; }
    .bean-4 { bottom: 30%; right: 8%; animation-delay: 12s; }
    .bean-5 { top: 70%; left: 3%; animation-delay: 15s; }

    @keyframes float {
        from { transform: translateY(0) rotate(45deg); opacity: 0.08; }
        to { transform: translateY(-100vh) rotate(405deg); opacity: 0; }
    }

    .particle {
        width: 3px;
        height: 3px;
        background: rgba(139,69,19,0.15);
        border-radius: 50%;
        animation: particle-float 15s infinite linear;
    }

    .particle-1 { top: 20%; left: 15%; animation-delay: 0s; }
    .particle-2 { top: 60%; right: 10%; animation-delay: 5s; }
    .particle-3 { top: 80%; left: 20%; animation-delay: 10s; }

    @keyframes particle-float {
        from { transform: translateY(0) scale(1); opacity: 0.2; }
        to { transform: translateY(-100vh) scale(0); opacity: 0; }
    }

    /* ===== TARJETA PRINCIPAL - MOBILE FIRST ===== */
    .carrito-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.1);
        position: relative;
        z-index: 10;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.3);
        animation: fadeInUp 0.6s ease;
        margin: 0;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Desktop */
    @media (min-width: 768px) {
        .carrito-card {
            border-radius: 24px;
            box-shadow: 0 8px 24px rgba(139, 69, 19, 0.12);
        }
    }

    /* ===== HEADER - MOBILE OPTIMIZED ===== */
    .carrito-header {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
    }

    .carrito-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1));
        transform: skewX(-20deg) translateX(100px);
        animation: shine 4s infinite;
    }

    @keyframes shine {
        0% { transform: skewX(-20deg) translateX(100px); }
        20% { transform: skewX(-20deg) translateX(-200px); }
        100% { transform: skewX(-20deg) translateX(-200px); }
    }

    .header-icon {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .header-title h4 {
        margin: 0;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .header-title p {
        margin: 4px 0 0;
        opacity: 0.9;
        font-size: 0.85rem;
    }

    .coffee-decoration-header {
        font-size: 1.25rem;
        margin: 0;
    }

    .coffee-decoration-header span {
        margin: 0 4px;
        animation: bounce 2s infinite;
        display: inline-block;
    }

    @keyframes bounce {
        0%,100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    /* Desktop header */
    @media (min-width: 768px) {
        .carrito-header {
            flex-direction: row;
            text-align: left;
            padding: 20px 24px;
            gap: 16px;
        }

        .header-icon {
            width: 56px;
            height: 56px;
            font-size: 1.75rem;
        }

        .header-title h4 {
            font-size: 1.5rem;
        }

        .header-title p {
            font-size: 0.9rem;
        }

        .coffee-decoration-header {
            margin-left: auto;
            font-size: 1.5rem;
        }
    }

    /* ===== CUERPO - MOBILE PADDING ===== */
    .carrito-body {
        padding: 16px;
    }

    @media (min-width: 768px) {
        .carrito-body {
            padding: 24px;
        }
    }

    @media (min-width: 1024px) {
        .carrito-body {
            padding: 32px;
        }
    }

    /* ===== TABLA - MOBILE FIRST (CARDS EN MÓVIL) ===== */
    .carrito-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* Ocultar thead en móvil */
    .carrito-table thead {
        display: none;
    }

    /* Convertir filas en cards en móvil */
    .carrito-table tbody tr {
        display: block;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 12px;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .carrito-table tbody tr:active {
        transform: scale(0.98);
    }

    .carrito-table tbody td {
        display: block;
        padding: 8px 0;
        border: none;
        text-align: left;
    }

    .carrito-table tbody td:before {
        content: attr(data-label);
        font-weight: 600;
        color: #8B4513;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 4px;
    }

    .carrito-table tbody td[data-label="Producto"]:before,
    .carrito-table tbody td[data-label="Acciones"]:before {
        display: none;
    }

    /* Desktop: Mostrar como tabla normal */
    @media (min-width: 768px) {
        .carrito-table {
            border-spacing: 0 10px;
        }

        .carrito-table thead {
            display: table-header-group;
        }

        .carrito-table thead th {
            background: #f8f4f0;
            color: #5D4037;
            font-weight: 600;
            padding: 14px;
            border: none;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 12px;
        }

        .carrito-table tbody tr {
            display: table-row;
            padding: 0;
            margin: 0;
            border-radius: 16px;
        }

        .carrito-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(139,69,19,0.12);
        }

        .carrito-table tbody td {
            display: table-cell;
            padding: 16px 12px;
            vertical-align: middle;
        }

        .carrito-table tbody td:before {
            display: none;
        }

        .carrito-table tbody td:first-child {
            border-radius: 16px 0 0 16px;
        }

        .carrito-table tbody td:last-child {
            border-radius: 0 16px 16px 0;
        }
    }

    /* Producto info - MOBILE OPTIMIZED */
    .producto-info {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .producto-img {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 2px solid white;
        flex-shrink: 0;
    }

    .producto-img-placeholder {
        width: 60px;
        height: 60px;
        background: linear-gradient(145deg, #f0e4d5, #e8d5c0);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8B4513;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .producto-img,
        .producto-img-placeholder {
            width: 70px;
            height: 70px;
            border-radius: 14px;
        }

        .producto-img-placeholder {
            font-size: 2rem;
        }
    }

    .producto-detalles {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
        min-width: 0;
    }

    .producto-nombre {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    @media (min-width: 768px) {
        .producto-nombre {
            font-size: 1.05rem;
        }
    }

    .stock-info {
        color: #27ae60;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Precios - MOBILE OPTIMIZED */
    .precio-cell {
        font-weight: 600;
        color: #8B4513;
        font-size: 1rem;
    }

    .subtotal-cell {
        font-weight: 700;
        color: #27ae60;
        font-size: 1.1rem;
    }

    .total-cell {
        font-size: 1.2rem;
        font-weight: 700;
        color: #8B4513;
        background: linear-gradient(145deg, #fff3e0, #ffe9d4);
        padding: 6px 16px;
        border-radius: 50px;
        display: inline-block;
    }

    @media (min-width: 768px) {
        .precio-cell {
            font-size: 1.05rem;
        }

        .subtotal-cell {
            font-size: 1.15rem;
        }

        .total-cell {
            font-size: 1.3rem;
            padding: 8px 20px;
        }
    }

    /* Control de cantidad - MOBILE OPTIMIZED (BOTONES MÁS GRANDES) */
    .cantidad-control {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f8f4f0;
        border-radius: 50px;
        padding: 4px;
        width: fit-content;
    }

    .btn-cantidad {
        width: 40px;
        height: 40px;
        border: none;
        background: white;
        color: #8B4513;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        font-size: 1rem;
        flex-shrink: 0;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-cantidad:active {
        transform: scale(0.95);
        background: #8B4513;
        color: white;
    }

    @media (min-width: 768px) {
        .btn-cantidad {
            width: 36px;
            height: 36px;
        }

        .btn-cantidad:hover {
            background: #8B4513;
            color: white;
            transform: scale(1.05);
        }

        .btn-cantidad:active {
            transform: scale(0.98);
        }
    }

    .input-cantidad {
        width: 45px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.1rem;
    }

    .input-cantidad:focus {
        outline: none;
    }

    /* Botón eliminar - MOBILE OPTIMIZED */
    .btn-eliminar {
        color: #e74c3c;
        font-size: 1.4rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #fee;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-eliminar:active {
        transform: scale(0.95);
        background: #e74c3c;
        color: white;
    }

    @media (min-width: 768px) {
        .btn-eliminar {
            width: auto;
            height: auto;
            background: transparent;
            font-size: 1.3rem;
        }

        .btn-eliminar:hover {
            color: #c0392b;
            transform: scale(1.15);
        }
    }

    /* ===== ACCIONES DEL CARRITO - MOBILE FIRST ===== */
    .carrito-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 2px dashed #e8d5c0;
    }

    .actions-left, .actions-right {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
    }

    /* Desktop: Layout horizontal */
    @media (min-width: 768px) {
        .carrito-actions {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
            padding-top: 20px;
        }

        .actions-left, .actions-right {
            flex-direction: row;
            width: auto;
            gap: 12px;
        }
    }

    /* Botones - MOBILE OPTIMIZED (MÁS GRANDES Y TÁCTILES) */
    .btn-vaciar {
        background: #fee;
        color: #e74c3c;
        padding: 14px 20px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        border: 2px solid #e74c3c;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-vaciar:active {
        transform: scale(0.98);
        background: #e74c3c;
        color: white;
    }

    .btn-seguir {
        background: #f0e4d5;
        color: #8B4513;
        padding: 14px 20px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-seguir:active {
        transform: scale(0.98);
        background: #e8d5c0;
    }

    .btn-pagar {
        background: linear-gradient(135deg, #27ae60, #2ecc71);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(46,204,113,0.3);
        -webkit-tap-highlight-color: transparent;
    }

    .btn-pagar:active {
        transform: scale(0.98);
        box-shadow: 0 2px 8px rgba(46,204,113,0.3);
    }

    /* Desktop: Hover effects */
    @media (min-width: 768px) {
        .btn-vaciar,
        .btn-seguir,
        .btn-pagar {
            padding: 12px 24px;
            border-radius: 50px;
        }

        .btn-vaciar:hover {
            background: #e74c3c;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(231,76,60,0.3);
        }

        .btn-seguir:hover {
            background: #e8d5c0;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(139,69,19,0.2);
        }

        .btn-pagar:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46,204,113,0.4);
        }
    }

    /* ===== RESUMEN - MOBILE OPTIMIZED ===== */
    .carrito-resumen {
        background: #f8f4f0;
        border-radius: 16px;
        padding: 16px;
        margin-top: 20px;
    }

    @media (min-width: 768px) {
        .carrito-resumen {
            border-radius: 20px;
            padding: 20px;
            margin-top: 24px;
            max-width: 400px;
            margin-left: auto;
        }
    }

    .resumen-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        color: #5D4037;
        font-size: 0.95rem;
    }

    .resumen-item.total {
        border-top: 2px solid #d9b382;
        margin-top: 8px;
        padding-top: 12px;
        font-size: 1.15rem;
        font-weight: 700;
        color: #8B4513;
    }

    @media (min-width: 768px) {
        .resumen-item.total {
            font-size: 1.2rem;
            margin-top: 10px;
            padding-top: 15px;
        }
    }

    .text-success {
        color: #27ae60;
        font-weight: 600;
    }

    /* ===== CARRITO VACÍO - MOBILE OPTIMIZED ===== */
    .empty-cart {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-cart-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(145deg, #f0e4d5, #e8d5c0);
        border-radius: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 3rem;
        color: #8B4513;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%,100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .empty-cart h3 {
        color: #8B4513;
        font-size: 1.5rem;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .empty-cart p {
        color: #8B6B4F;
        font-size: 1rem;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .btn-ver-productos {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #8B4513, #A0522D);
        color: white;
        padding: 14px 32px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(139,69,19,0.3);
        -webkit-tap-highlight-color: transparent;
    }

    .btn-ver-productos:active {
        transform: scale(0.98);
        color: white;
    }

    @media (min-width: 768px) {
        .empty-cart {
            padding: 60px 20px;
        }

        .empty-cart-icon {
            width: 120px;
            height: 120px;
            font-size: 3.5rem;
            margin-bottom: 24px;
        }

        .empty-cart h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .empty-cart p {
            font-size: 1.1rem;
            margin-bottom: 24px;
        }

        .btn-ver-productos {
            padding: 15px 40px;
            border-radius: 50px;
        }

        .btn-ver-productos:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139,69,19,0.4);
            color: white;
        }
    }

    /* ===== SECCIÓN DE PRODUCTOS - MOBILE OPTIMIZED ===== */
    .seccion-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header-decoration {
        font-size: 1.5rem;
        color: #8B4513;
        margin-bottom: 8px;
    }

    .header-decoration i {
        margin: 0 8px;
        animation: bounce 2s infinite;
    }

    .header-decoration i:nth-child(2) {
        animation-delay: 0.3s;
        color: #27ae60;
    }

    .seccion-header h3 {
        color: #8B4513;
        font-weight: 700;
        margin-bottom: 4px;
        font-size: 1.25rem;
    }

    .seccion-header p {
        color: #8B6B4F;
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .seccion-header {
            margin-bottom: 24px;
        }

        .header-decoration {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .seccion-header h3 {
            font-size: 1.5rem;
        }

        .seccion-header p {
            font-size: 1rem;
        }
    }

    /* Grid de productos - MOBILE FIRST (2 COLUMNAS) */
    .productos-grid-mini,
    .productos-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-top: 16px;
    }

    @media (min-width: 480px) {
        .productos-grid-mini,
        .productos-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
    }

    @media (min-width: 768px) {
        .productos-grid-mini {
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .productos-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (min-width: 1024px) {
        .productos-grid-mini {
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .productos-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
    }

    /* Cards de productos - MOBILE OPTIMIZED */
    .producto-mini-card,
    .producto-card-sugerido {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.2s ease;
        border: 1px solid rgba(139,69,19,0.08);
    }

    .producto-mini-card:active,
    .producto-card-sugerido:active {
        transform: scale(0.98);
    }

    @media (min-width: 768px) {
        .producto-mini-card,
        .producto-card-sugerido {
            border-radius: 16px;
        }

        .producto-mini-card:hover,
        .producto-card-sugerido:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(139,69,19,0.12);
        }
    }

    .producto-mini-imagen,
    .producto-imagen-sugerido {
        height: 100px;
        overflow: hidden;
        position: relative;
    }

    @media (min-width: 480px) {
        .producto-mini-imagen {
            height: 110px;
        }

        .producto-imagen-sugerido {
            height: 130px;
        }
    }

    @media (min-width: 768px) {
        .producto-mini-imagen {
            height: 120px;
        }

        .producto-imagen-sugerido {
            height: 150px;
        }
    }

    .producto-mini-imagen img,
    .producto-imagen-sugerido img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mini-placeholder,
    .sugerido-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(145deg, #f0e4d5, #e8d5c0);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #8B4513;
    }

    @media (min-width: 768px) {
        .mini-placeholder {
            font-size: 2.5rem;
        }

        .sugerido-placeholder {
            font-size: 3rem;
        }
    }

    .badge-stock-bajo {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #e74c3c;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        animation: pulse 2s infinite;
    }

    .producto-mini-info,
    .producto-info-sugerido {
        padding: 12px;
    }

    .producto-mini-info h5,
    .producto-info-sugerido h5 {
        margin: 0 0 6px 0;
        font-size: 0.9rem;
        color: #2c3e50;
        font-weight: 600;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    @media (min-width: 768px) {
        .producto-mini-info h5,
        .producto-info-sugerido h5 {
            font-size: 1rem;
        }
    }

    .mini-precio,
    .sugerido-precio {
        display: block;
        font-weight: 700;
        color: #27ae60;
        font-size: 1rem;
        margin-bottom: 4px;
    }

    @media (min-width: 768px) {
        .mini-precio {
            font-size: 1.05rem;
        }

        .sugerido-precio {
            font-size: 1.2rem;
        }
    }

    .mini-stock {
        display: block;
        color: #7f8c8d;
        font-size: 0.75rem;
        margin-bottom: 8px;
    }

    .sugerido-descripcion {
        color: #7f8c8d;
        font-size: 0.8rem;
        margin-bottom: 8px;
        line-height: 1.4;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .sugerido-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .btn-agregar-mini {
        width: 100%;
        background: linear-gradient(135deg, #8B4513, #A0522D);
        color: white;
        border: none;
        padding: 10px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-agregar-mini:active {
        transform: scale(0.98);
    }

    @media (min-width: 768px) {
        .btn-agregar-mini {
            padding: 8px;
            font-size: 0.9rem;
        }

        .btn-agregar-mini:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139,69,19,0.3);
        }
    }

    .btn-agregar-sugerido {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #8B4513, #A0522D);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-agregar-sugerido:active {
        transform: scale(0.95);
    }

    @media (min-width: 768px) {
        .btn-agregar-sugerido {
            width: 40px;
            height: 40px;
        }

        .btn-agregar-sugerido:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(139,69,19,0.3);
        }
    }

    .btn-ver-mas {
        display: inline-block;
        background: #f0e4d5;
        color: #8B4513;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-ver-mas:active {
        transform: scale(0.98);
        background: #e8d5c0;
    }

    @media (min-width: 768px) {
        .btn-ver-mas {
            padding: 12px 30px;
            border-radius: 50px;
        }

        .btn-ver-mas:hover {
            background: #8B4513;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(139,69,19,0.2);
        }
    }

    /* ===== ALERTAS - MOBILE OPTIMIZED ===== */
    .alert-modern {
        padding: 14px 16px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideIn 0.4s ease;
        font-size: 0.9rem;
    }

    .alert-success-modern {
        background: linear-gradient(145deg, #d4edda, #c3e6cb);
        border-left: 4px solid #28a745;
        color: #155724;
    }

    .alert-error-modern {
        background: linear-gradient(145deg, #f8d7da, #f5c6cb);
        border-left: 4px solid #dc3545;
        color: #721c24;
    }

    .alert-modern i {
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (min-width: 768px) {
        .alert-modern {
            padding: 16px 20px;
            border-radius: 14px;
            font-size: 1rem;
        }

        .alert-modern i {
            font-size: 1.4rem;
        }
    }

    /* ===== FOOTER - MOBILE OPTIMIZED ===== */
    .carrito-footer {
        padding: 12px;
        text-align: center;
        border-top: 2px dashed #e8d5c0;
    }

    @media (min-width: 768px) {
        .carrito-footer {
            padding: 15px;
        }
    }

    .coffee-beans-footer {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .coffee-beans-footer span {
        width: 10px;
        height: 15px;
        background: #8B4513;
        border-radius: 50%;
        transform: rotate(45deg);
        animation: bounce-footer 2s infinite;
        display: inline-block;
        opacity: 0.4;
    }

    @keyframes bounce-footer {
        0%,100% { transform: rotate(45deg) translateY(0); }
        50% { transform: rotate(45deg) translateY(-4px); }
    }

    @media (min-width: 768px) {
        .coffee-beans-footer span {
            width: 12px;
            height: 18px;
            opacity: 0.5;
        }
    }

    /* ===== UTILIDADES MOBILE ===== */
    /* Mejorar el scroll en móviles */
    * {
        -webkit-overflow-scrolling: touch;
    }

    /* Evitar zoom en inputs en iOS */
    input, select, textarea {
        font-size: 16px !important;
    }

    /* Mejorar tap targets */
    button, a, input[type="submit"] {
        min-height: 44px;
        min-width: 44px;
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection
