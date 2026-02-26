@extends('layouts.app')
@section('content')

<div class="inventario-container">
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
        <!-- Header con estilo igual a tus otras vistas -->
        <div class="inventario-header">
            <div class="header-icon">
                <i class="fas fa-warehouse"></i>
            </div>
            <div class="header-title">
                <h4><i class="fas fa-coffee"></i> Control de Inventario</h4>
                <p>Gestión de stock de productos</p>
            </div>
            <div class="coffee-decoration-header">
                <span>📦</span>
                <span>☕</span>
                <span>📊</span>
            </div>
        </div>

        <!-- Tarjeta principal -->
        <div class="inventario-card">
            <!-- Resumen de inventario -->
            <div class="inventario-resumen">
                <div class="resumen-card">
                    <i class="fas fa-cubes"></i>
                    <span class="resumen-valor">{{ $total_stock }}</span>
                    <span class="resumen-label">Total unidades</span>
                </div>
                <div class="resumen-card">
                    <i class="fas fa-boxes"></i>
                    <span class="resumen-valor">{{ count($productos_con_inventario) }}</span>
                    <span class="resumen-label">Productos</span>
                </div>
                <div class="resumen-card warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span class="resumen-valor">{{ $productos_bajo_stock }}</span>
                    <span class="resumen-label">Stock bajo</span>
                </div>
            </div>

            <!-- Tabla de inventario -->
            <div class="table-responsive">
                <table class="table inventario-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Stock actual</th>
                            <th>Stock mínimo</th>
                            <th>Estado</th>
                            <th>Última actualización</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos_con_inventario as $producto)
                        <tr>
                            <td>
                                <div class="producto-info-cell">
                                    @if($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                             alt="{{ $producto->nombre }}" class="producto-thumb">
                                    @else
                                        <div class="producto-thumb-placeholder">
                                            <i class="fas fa-coffee"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $producto->nombre }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="precio-cell">${{ number_format($producto->precio, 2) }}</span>
                            </td>
                            <td>
                                <span class="stock-badge {{ $producto->inventario->bajo_stock ? 'bajo' : 'normal' }}">
                                    {{ $producto->inventario->stock_actual }} unidades
                                </span>
                            </td>
                            <td>{{ $producto->inventario->stock_minimo }} unidades</td>
                            <td>
                                @if($producto->inventario->stock_actual == 0)
                                    <span class="badge-estado agotado">Agotado</span>
                                @elseif($producto->inventario->bajo_stock)
                                    <span class="badge-estado bajo">¡Stock bajo!</span>
                                @else
                                    <span class="badge-estado normal">Normal</span>
                                @endif
                            </td>
                            <td>
                                @if($producto->inventario->fecha_actualizacion)
                                    {{ \Carbon\Carbon::parse($producto->inventario->fecha_actualizacion)->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">Sin fecha</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn-ajustar" 
                                        onclick="abrirModalAjuste('{{ $producto->_id }}', '{{ $producto->nombre }}', {{ $producto->inventario->stock_actual }})">
                                    <i class="fas fa-edit"></i> Ajustar
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-box-open fa-4x mb-3" style="color: #d9b382;"></i>
                                    <h5>No hay productos con inventario</h5>
                                    <p>Agrega productos con stock inicial para ver el inventario</p>
                                    <a href="{{ route('productos.crear') }}" class="btn-crear-producto">
                                        <i class="fas fa-plus-circle"></i> Crear producto
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ajustar stock -->
<div id="modalAjuste" class="modal-confirm">
    <div class="modal-content" style="max-width: 450px;">
        <div class="modal-header" style="background: linear-gradient(135deg, #8B4513, #A0522D);">
            <div class="modal-icon">
                <i class="fas fa-boxes"></i>
            </div>
            <h3>Ajustar stock</h3>
        </div>
        <form action="{{ route('inventario.actualizar') }}" method="POST">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="producto_id" id="ajuste_producto_id">
                
                <div class="form-group mb-3">
                    <label class="form-label">Producto</label>
                    <input type="text" class="form-control" id="ajuste_producto_nombre" readonly style="background: #f8f4f0;">
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Stock actual</label>
                    <input type="text" class="form-control" id="ajuste_stock_actual" readonly style="background: #f8f4f0;">
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Nuevo stock <span class="text-danger">*</span></label>
                    <input type="number" name="nuevo_stock" class="form-control" min="0" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Motivo del ajuste <span class="text-danger">*</span></label>
                    <select name="motivo" class="form-control" required>
                        <option value="">Seleccionar motivo</option>
                        <option value="compra">Compra a proveedor</option>
                        <option value="venta">Venta realizada</option>
                        <option value="devolucion">Devolución</option>
                        <option value="inventario_fisico">Inventario físico</option>
                        <option value="ajuste_manual">Ajuste manual</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="cerrarModal()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="submit" class="btn-confirmar">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModalAjuste(id, nombre, stockActual) {
    document.getElementById('ajuste_producto_id').value = id;
    document.getElementById('ajuste_producto_nombre').value = nombre;
    document.getElementById('ajuste_stock_actual').value = stockActual + ' unidades';
    
    document.getElementById('modalAjuste').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modalAjuste').style.display = 'none';
}

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('modalAjuste');
    if (event.target == modal) {
        cerrarModal();
    }
}
</script>

<style>
    /* Mismos estilos decorativos que tus otras vistas */
    .inventario-container {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(145deg, #faf0e6 0%, #f5e6d3 100%);
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        padding: 20px 0;
        overflow-x: hidden;
    }

    /* Elementos decorativos (copiar de tus otras vistas) */
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

    /* Header */
    .inventario-header {
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
    }

    .inventario-header::after {
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

    /* Tarjeta de inventario */
    .inventario-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 0 0 30px 30px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        z-index: 10;
        position: relative;
    }

    /* Resumen cards */
    .inventario-resumen {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .resumen-card {
        background: linear-gradient(145deg, #ffffff, #f5f0eb);
        padding: 25px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(139, 69, 19, 0.1);
        transition: all 0.3s ease;
    }

    .resumen-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(139, 69, 19, 0.15);
    }

    .resumen-card i {
        font-size: 2.5rem;
        color: #8B4513;
        margin-bottom: 15px;
    }

    .resumen-card.warning i {
        color: #dc3545;
    }

    .resumen-valor {
        display: block;
        font-size: 2rem;
        font-weight: 700;
        color: #3E2723;
    }

    .resumen-label {
        color: #8B6B4F;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Tabla */
    .inventario-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .inventario-table thead th {
        background: #f8f4f0;
        color: #5D4037;
        padding: 15px;
        font-weight: 600;
        border-radius: 10px;
    }

    .inventario-table tbody tr {
        background: white;
        border-radius: 15px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }

    .inventario-table tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(139, 69, 19, 0.15);
    }

    .inventario-table tbody td {
        padding: 15px;
        vertical-align: middle;
        border: none;
    }

    .producto-info-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .producto-thumb {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }

    .producto-thumb-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: #f0e4d5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8B4513;
        font-size: 1.5rem;
    }

    .precio-cell {
        font-weight: 600;
        color: #8B4513;
    }

    .stock-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .stock-badge.normal {
        background: linear-gradient(145deg, #d4edda, #c3e6cb);
        color: #155724;
    }

    .stock-badge.bajo {
        background: linear-gradient(145deg, #fff3cd, #ffe69c);
        color: #856404;
    }

    .badge-estado {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-estado.normal {
        background: #28a745;
        color: white;
    }

    .badge-estado.bajo {
        background: #ffc107;
        color: #212529;
    }

    .badge-estado.agotado {
        background: #dc3545;
        color: white;
    }

    .btn-ajustar {
        background: linear-gradient(145deg, #8B4513, #A0522D);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 10px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-ajustar:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
    }

    /* Estado vacío */
    .empty-state {
        text-align: center;
        padding: 40px;
    }

    .btn-crear-producto {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #8B4513, #A0522D);
        color: white;
        padding: 12px 25px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 15px;
        transition: all 0.3s ease;
    }

    .btn-crear-producto:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(139, 69, 19, 0.3);
        color: white;
    }

    /* Modal */
    .modal-confirm {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.3);
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        background: linear-gradient(135deg, #8B4513, #A0522D);
        color: white;
        padding: 20px;
        text-align: center;
    }

    .modal-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-footer {
        padding: 20px 25px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        border-top: 1px solid #eee;
    }

    .btn-cancel {
        background: #f0f0f0;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        color: #666;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #e0e0e0;
    }

    .btn-confirmar {
        background: linear-gradient(145deg, #8B4513, #A0522D);
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-confirmar:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
    }

    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 2px solid #e8d5c0;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #5D4037;
        margin-bottom: 5px;
        display: block;
    }

    @media (max-width: 768px) {
        .coffee-cup {
            display: none;
        }
        
        .inventario-header {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        
        .coffee-decoration-header {
            margin: 0 auto;
        }
        
        .inventario-card {
            padding: 20px;
        }
        
        .inventario-table thead {
            display: none;
        }
        
        .inventario-table tbody tr {
            display: block;
            margin-bottom: 15px;
        }
        
        .inventario-table tbody td {
            display: block;
            text-align: right;
            padding: 10px 15px;
            position: relative;
            border-bottom: 1px solid #eee;
        }
        
        .inventario-table tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            font-weight: 600;
            color: #8B4513;
        }
        
        .producto-info-cell {
            justify-content: flex-end;
        }
        
        .modal-footer {
            flex-direction: column;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@endsection