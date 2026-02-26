@extends('layouts.app')
@section('content')

<div class="productos-container">
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
        <!-- Decoración superior -->
        <div class="coffee-decoration">
            <span>☕</span> <span>☕</span> <span>☕</span>
        </div>

        <!-- Header con estilo de backups -->
        <div class="productos-header">
            <div class="header-icon">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="header-title">
                <h4><i class="fas fa-coffee"></i> Lista de productos</h4>
                <p>Catálogo completo de nuestra cafetería</p>
            </div>
            <div class="coffee-decoration-header">
                <span>☕</span>
                <span>📋</span>
                <span>☕</span>
            </div>
        </div>

        <!-- Contenedor de la tabla con estilo glassmorphism -->
        <div class="productos-table-container">
            <table class="table productos-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-tag"></i> Nombre</th>
                        <th><i class="fas fa-dollar-sign"></i> Precio</th>
                        <th><i class="fas fa-align-left"></i> Descripción</th>
                        <th><i class="fas fa-image"></i> Imagen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $p)
                    <tr>
                        <td data-label="Nombre">
                            <div class="producto-nombre-cell">
                                <i class="fas fa-cookie-bite"></i>
                                <strong>{{ $p->nombre }}</strong>
                            </div>
                        </td>
                        <td data-label="Precio">
                            <span class="precio-badge">${{ number_format($p->precio, 2) }}</span>
                        </td>
                        <td data-label="Descripción">
                            <div class="descripcion-cell">
                                {{ $p->descripcion }}
                            </div>
                        </td>
                        <td data-label="Imagen">
                            @if($p->imagen)
                                <div class="imagen-container">
                                    <img src="{{ asset('storage/' . $p->imagen) }}" alt="{{ $p->nombre }}" class="producto-imagen">
                                </div>
                            @else
                                <span class="sin-imagen-badge">
                                    <i class="fas fa-image"></i> Sin imagen
                                </span>
                            @endif 
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Decoración inferior -->
        <div class="coffee-decoration" style="margin-top: 30px;">
            <span>☕</span> <span>☕</span> <span>☕</span>
        </div>
    </div>
</div>

<!-- Script para agregar data-label en responsive -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const headers = document.querySelectorAll('.productos-table thead th');
        const rows = document.querySelectorAll('.productos-table tbody tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, index) => {
                if (headers[index]) {
                    // Limpiar el texto del header (quitar iconos)
                    let headerText = headers[index].textContent.replace(/[^\w\sáéíóúñ]/gi, '').trim();
                    cell.setAttribute('data-label', headerText);
                }
            });
        });
    });
</script>

<style>
    /* ===== ESTILOS GENERALES (mismos que backups) ===== */
    .productos-container {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(145deg, #faf0e6 0%, #f5e6d3 100%);
        font-family: 'Segoe UI', system-ui, sans-serif;
        padding: 20px 0;
        overflow-x: hidden;
    }

    /* ===== ELEMENTOS DECORATIVOS - TAZAS BLANCAS (mismas que backups) ===== */
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

    /* ===== HEADER (mismo estilo que backups) ===== */
    .productos-header {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
        border-radius: 30px 30px 0 0;
        margin-bottom: 0;
    }

    .productos-header::after {
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

    /* ===== CONTENEDOR DE TABLA (glassmorphism) ===== */
    .productos-table-container {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 0 0 30px 30px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* ===== TABLA (mismo estilo que backups) ===== */
    .productos-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .productos-table thead th {
        background: linear-gradient(145deg, #f8f4f0, #f0e8e0);
        color: #5D4037;
        font-weight: 600;
        padding: 16px;
        border: none;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 16px 16px 0 0;
    }

    .productos-table thead th i {
        margin-right: 8px;
        color: #8B4513;
    }

    .productos-table tbody tr {
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }

    .productos-table tbody tr:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(139, 69, 19, 0.15);
        background: white;
    }

    .productos-table tbody td {
        padding: 18px 16px;
        border: none;
        vertical-align: middle;
    }

    /* Celda de nombre */
    .producto-nombre-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .producto-nombre-cell i {
        font-size: 1.5rem;
        color: #8B4513;
    }

    .producto-nombre-cell strong {
        color: #2c3e50;
        font-size: 1.1rem;
    }

    /* Badge de precio */
    .precio-badge {
        background: linear-gradient(135deg, var(--caramelo), #f4c542);
        padding: 8px 16px;
        border-radius: 30px;
        color: var(--cafe-oscuro);
        font-weight: 700;
        font-size: 1.1rem;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(230, 177, 126, 0.3);
    }

    /* Celda de descripción */
    .descripcion-cell {
        color: #6b4f3f;
        line-height: 1.6;
        border-left: 4px solid #d9b382;
        padding-left: 15px;
        font-size: 0.95rem;
        max-width: 350px;
    }

    /* Contenedor de imagen */
    .imagen-container {
        width: 90px;
        height: 90px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(74, 44, 44, 0.2);
        border: 3px solid white;
        transition: all 0.3s ease;
    }

    .imagen-container:hover {
        transform: scale(1.5) translateX(20px);
        box-shadow: 0 15px 30px rgba(74, 44, 44, 0.3);
        z-index: 100;
        position: relative;
    }

    .producto-imagen {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Badge sin imagen */
    .sin-imagen-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: #f0e4d5;
        border-radius: 30px;
        color: var(--cafe-medio);
        font-style: italic;
        font-size: 0.9rem;
        border: 1px dashed var(--cafe-claro);
    }

    .sin-imagen-badge i {
        color: var(--cafe-medio);
    }

    /* Decoración de café */
    .coffee-decoration {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2rem;
        opacity: 0.5;
        letter-spacing: 10px;
    }

    .coffee-decoration span {
        display: inline-block;
        animation: bounce-slow 3s infinite;
    }

    .coffee-decoration span:nth-child(2) { animation-delay: 0.5s; }
    .coffee-decoration span:nth-child(3) { animation-delay: 1s; }

    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    /* Animación de entrada */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .productos-table tbody tr {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    .productos-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
    .productos-table tbody tr:nth-child(2) { animation-delay: 0.2s; }
    .productos-table tbody tr:nth-child(3) { animation-delay: 0.3s; }
    .productos-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
    .productos-table tbody tr:nth-child(5) { animation-delay: 0.5s; }
    .productos-table tbody tr:nth-child(6) { animation-delay: 0.6s; }
    .productos-table tbody tr:nth-child(7) { animation-delay: 0.7s; }
    .productos-table tbody tr:nth-child(8) { animation-delay: 0.8s; }
    .productos-table tbody tr:nth-child(9) { animation-delay: 0.9s; }
    .productos-table tbody tr:nth-child(10) { animation-delay: 1s; }

    /* Responsive */
    @media (max-width: 768px) {
        .coffee-cup {
            display: none;
        }
        
        .productos-header {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        
        .coffee-decoration-header {
            margin: 0 auto;
        }
        
        .productos-table thead {
            display: none;
        }
        
        .productos-table tbody tr {
            display: block;
            margin-bottom: 20px;
        }
        
        .productos-table tbody td {
            display: block;
            text-align: right;
            padding: 12px 15px;
            position: relative;
            border-bottom: 1px solid #eee;
        }
        
        .productos-table tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            font-weight: 600;
            color: var(--cafe-oscuro);
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        
        .producto-nombre-cell {
            justify-content: flex-end;
        }
        
        .producto-nombre-cell i {
            order: 2;
        }
        
        .imagen-container:hover {
            transform: scale(1.2);
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@endsection