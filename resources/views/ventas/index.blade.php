@extends('layouts.app')

@section('content')
<div class="ventas-container">
    <!-- Elementos decorativos de café - TAZAS BLANCAS (igual que en inventario) -->
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
        <!-- Header con estilo igual al de inventario -->
        <div class="ventas-header">
            <div class="header-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="header-title">
                <h4><i class="fas fa-receipt"></i> Historial de Ventas</h4>
                <p>Gestiona y consulta todos los tickets generados</p>
            </div>
            <div class="coffee-decoration-header">
                <span>🧾</span>
                <span>☕</span>
                <span>📊</span>
            </div>
            <a href="{{ route('ventas.reportes') }}" class="btn-ver-estadisticas">
                <i class="fas fa-chart-line me-1"></i> Ver Estadísticas
            </a>
        </div>

        <!-- Tarjeta principal -->
        <div class="ventas-card">
            <!-- Filtros (búsqueda y estado) con diseño mejorado -->
            <div class="filtros-container">
                <div class="filtro-busqueda">
                    <i class="fas fa-search"></i>
                    <input type="text" class="filtro-input" placeholder="Buscar por ticket, mesa o cliente...">
                </div>
                <div class="filtro-estado">
                    <select class="filtro-select">
                        <option selected>Todos los estados</option>
                        <option>Completada</option>
                        <option>Pendiente</option>
                        <option>Cancelada</option>
                    </select>
                </div>
            </div>

            <!-- Tabla de ventas con estilo similar al inventario -->
            <div class="table-responsive">
                <table class="table ventas-table">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha y Hora</th>
                            <th>Mesa</th>
                            <th>Productos</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                        <tr>
                            <td data-label="Folio">
                                <span class="folio-badge">#{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td data-label="Fecha">
                                @if($venta->created_at)
                                    <div class="fecha-small">{{ $venta->created_at->format('d/m/Y') }}</div>
                                    <div class="hora-small">{{ $venta->created_at->format('h:i A') }}</div>
                                @else
                                    <span class="text-muted">Sin fecha</span>
                                @endif
                            </td>
                            <td data-label="Mesa">
                                <span class="mesa-badge">Mesa {{ $venta->mesa }}</span>
                            </td>
                            <td data-label="Productos">
                                <div class="productos-lista">
                                    @if(is_array($venta->productos) || is_object($venta->productos))
                                        @foreach($venta->productos as $p)
                                            <span class="producto-item">{{ $p['nombre'] ?? 'Producto' }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </td>
                            <td data-label="Total">
                                <span class="total-cell">${{ number_format($venta->total, 2) }}</span>
                            </td>
                            <td data-label="Estado">
                                @php
                                    $status = strtolower($venta->estado ?? 'pendiente');
                                    $statusClass = [
                                        'completada' => 'badge-estado completada',
                                        'pendiente' => 'badge-estado pendiente',
                                        'cancelada' => 'badge-estado cancelada'
                                    ][$status] ?? 'badge-estado pendiente';
                                @endphp
                                <span class="{{ $statusClass }}">
                                    {{ $venta->estado ?? 'PENDIENTE' }}
                                </span>
                            </td>
                            <td data-label="Acciones" class="text-center">
                                <div class="acciones-group">
                                    <a href="{{ route('ventas.show', $venta->id) }}" class="btn-accion ver" title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn-accion imprimir" title="Imprimir Ticket" onclick="imprimirTicket({{ $venta->id }})">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open fa-4x mb-3"></i>
                                    <h5>No hay ventas registradas</h5>
                                    <p>Las ventas aparecerán aquí cuando se realicen.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if(isset($ventas) && method_exists($ventas, 'links'))
                <div class="pagination-container">
                    {{ $ventas->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para imprimir (opcional, puedes adaptarlo) -->
<div id="modalImprimir" class="modal-confirm" style="display: none;">
    <div class="modal-content" style="max-width: 400px;">
        <div class="modal-header" style="background: linear-gradient(135deg, #8B4513, #A0522D);">
            <div class="modal-icon">
                <i class="fas fa-print"></i>
            </div>
            <h3>Imprimir Ticket</h3>
        </div>
        <div class="modal-body text-center">
            <p>¿Deseas imprimir el ticket de la venta?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="cerrarModalImprimir()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="button" class="btn-confirmar" onclick="confirmarImpresion()">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>
</div>

<script>
    function imprimirTicket(id) {
        // Aquí puedes implementar la lógica para imprimir, por ahora abrimos el modal
        document.getElementById('modalImprimir').style.display = 'flex';
        // Guardamos el id en un atributo o variable global
        window.ticketId = id;
    }

    function cerrarModalImprimir() {
        document.getElementById('modalImprimir').style.display = 'none';
    }

    function confirmarImpresion() {
        // Redirigir a la ruta de impresión
        window.location.href = '/ventas/ticket/' + window.ticketId;
        cerrarModalImprimir();
    }

    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        const modal = document.getElementById('modalImprimir');
        if (event.target == modal) {
            cerrarModalImprimir();
        }
    }
</script>

<style>
    /* ===== Mismos estilos decorativos que en inventario ===== */
    .ventas-container {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(145deg, #faf0e6 0%, #f5e6d3 100%);
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        padding: 20px 0;
        overflow-x: hidden;
    }

    /* Elementos decorativos (copiados de inventario) */
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
    .ventas-header {
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

    .ventas-header::after {
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

    .btn-ver-estadisticas {
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

    .btn-ver-estadisticas:hover {
        background: #D4AF37;
        border-color: #D4AF37;
        color: #2c1a0b;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Tarjeta principal */
    .ventas-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 0 0 30px 30px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        z-index: 10;
        position: relative;
    }

    /* Filtros */
    .filtros-container {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .filtro-busqueda {
        flex: 1 1 300px;
        position: relative;
    }

    .filtro-busqueda i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #8B4513;
        font-size: 1rem;
    }

    .filtro-input {
        width: 100%;
        padding: 12px 15px 12px 45px;
        border: 2px solid #e8d5c0;
        border-radius: 50px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .filtro-input:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.1);
    }

    .filtro-estado {
        min-width: 200px;
    }

    .filtro-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e8d5c0;
        border-radius: 50px;
        background: white;
        font-size: 0.95rem;
        cursor: pointer;
    }

    .filtro-select:focus {
        outline: none;
        border-color: #8B4513;
    }

    /* Tabla */
    .ventas-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .ventas-table thead th {
        background: #f8f4f0;
        color: #5D4037;
        padding: 15px;
        font-weight: 600;
        border-radius: 10px;
    }

    .ventas-table tbody tr {
        background: white;
        border-radius: 15px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }

    .ventas-table tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(139, 69, 19, 0.15);
    }

    .ventas-table tbody td {
        padding: 15px;
        vertical-align: middle;
        border: none;
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

    .fecha-small {
        font-weight: 600;
        color: #3E2723;
    }

    .hora-small {
        font-size: 0.85rem;
        color: #8B6B4F;
    }

    .mesa-badge {
        background: #f0e4d5;
        color: #8B4513;
        padding: 5px 12px;
        border-radius: 30px;
        font-weight: 500;
    }

    .productos-lista {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .producto-item {
        background: #f8f4f0;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        color: #5D4037;
    }

    .total-cell {
        font-weight: 700;
        color: #28a745;
        font-size: 1.1rem;
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

    .acciones-group {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .btn-accion {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-accion.ver {
        background: #17a2b8;
    }

    .btn-accion.imprimir {
        background: #6c757d;
    }

    .btn-accion:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Estado vacío */
    .empty-state {
        text-align: center;
        padding: 40px;
    }

    .empty-state i {
        color: #d9b382;
    }

    .empty-state h5 {
        color: #5D4037;
        font-weight: 600;
    }

    /* Paginación */
    .pagination-container {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    /* Modal (similar al de inventario) */
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

    /* Responsividad */
    @media (max-width: 768px) {
        .coffee-cup {
            display: none;
        }

        .ventas-header {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .coffee-decoration-header {
            margin: 0 auto;
        }

        .btn-ver-estadisticas {
            width: 100%;
            justify-content: center;
        }

        .ventas-card {
            padding: 20px;
        }

        .filtros-container {
            flex-direction: column;
        }

        .ventas-table thead {
            display: none;
        }

        .ventas-table tbody tr {
            display: block;
            margin-bottom: 15px;
        }

        .ventas-table tbody td {
            display: block;
            text-align: right;
            padding: 10px 15px;
            position: relative;
            border-bottom: 1px solid #eee;
        }

        .ventas-table tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            font-weight: 600;
            color: #8B4513;
        }

        .productos-lista {
            justify-content: flex-end;
        }

        .modal-footer {
            flex-direction: column;
        }
    }
</style>

<!-- Font Awesome y Poppins (si no están ya en layouts.app) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection