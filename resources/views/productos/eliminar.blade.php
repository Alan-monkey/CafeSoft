@extends('layouts.app')
@section('content')

<div class="producto-delete-container">
    <!-- Elementos decorativos de café - TAZAS BLANCAS (mismos que en crear) -->
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
            <div class="col-md-10 col-lg-8">
                <!-- Tarjeta principal con estilo glassmorphism -->
                <div class="producto-card">
                    <div class="producto-card-header delete-header">
                        <div class="header-icon">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <div class="header-title">
                            <h4><i class="fas fa-coffee"></i> Eliminar productos</h4>
                            <p>Selecciona los productos que deseas eliminar</p>
                        </div>
                        <div class="coffee-decoration-header">
                            <span>⚠️</span>
                            <span>☕</span>
                            <span>⚠️</span>
                        </div>
                    </div>

                    <div class="producto-card-body">
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

                        @if($productos->isEmpty())
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h3>No hay productos</h3>
                                <p>No se encontraron productos para eliminar.</p>
                                <a href="{{ route('productos.crear') }}" class="btn-empty-action">
                                    <i class="fas fa-plus-circle"></i> Crear producto
                                </a>
                            </div>
                        @else
                            <!-- Barra de búsqueda -->
                            <div class="search-bar-modern mb-4">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchProduct" class="form-control-modern" 
                                       placeholder="Buscar producto por nombre...">
                            </div>

                            <!-- Lista de productos -->
                            <div class="productos-list" id="productosList">
                                @foreach($productos as $producto)
                                <div class="producto-item" data-nombre="{{ strtolower($producto->nombre) }}">
                                    <form method="POST" action="{{ route('productos.destroy') }}" class="delete-form">
                                        @csrf
                                        <input type="hidden" name="IdProducto" value="{{ $producto->id }}">
                                        
                                        <div class="producto-info">
                                            <div class="producto-imagen">
                                                @if($producto->imagen)
                                                    <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                                         alt="{{ $producto->nombre }}">
                                                @else
                                                    <div class="imagen-placeholder">
                                                        <i class="fas fa-coffee"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="producto-detalles">
                                                <h5 class="producto-nombre">{{ $producto->nombre }}</h5>
                                                <p class="producto-descripcion">{{ Str::limit($producto->descripcion, 60) }}</p>
                                                <span class="producto-precio">${{ number_format($producto->precio, 2) }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="producto-actions">
                                            <button type="button" class="btn-delete-modern" 
                                                    onclick="confirmDelete(this)">
                                                <i class="fas fa-trash-alt"></i>
                                                <span>Eliminar</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                @endforeach
                            </div>

                            <!-- Contador de productos -->
                            <div class="productos-footer">
                                <span class="productos-count">
                                    <i class="fas fa-cube"></i> Total: {{ $productos->count() }} productos
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Decoración de granos en el footer de la tarjeta -->
                    <div class="producto-card-footer">
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

<!-- Modal de confirmación -->
<div id="confirmModal" class="modal-confirm">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3>¿Eliminar producto?</h3>
        </div>
        <div class="modal-body">
            <p>Esta acción no se puede deshacer. El producto será eliminado permanentemente.</p>
            <p class="product-name" id="modalProductName"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="button" class="btn-confirm-delete" id="confirmDeleteBtn">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
// Búsqueda en tiempo real
document.getElementById('searchProduct').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const productos = document.querySelectorAll('.producto-item');
    
    productos.forEach(producto => {
        const nombre = producto.dataset.nombre;
        if (nombre.includes(searchTerm)) {
            producto.style.display = 'flex';
        } else {
            producto.style.display = 'none';
        }
    });
});

// Modal de confirmación
let currentForm = null;

function confirmDelete(button) {
    const form = button.closest('form');
    const productName = form.querySelector('.producto-nombre').textContent;
    
    document.getElementById('modalProductName').textContent = `"${productName}"`;
    document.getElementById('confirmModal').style.display = 'flex';
    
    currentForm = form;
}

function closeModal() {
    document.getElementById('confirmModal').style.display = 'none';
    currentForm = null;
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (currentForm) {
        currentForm.submit();
    }
    closeModal();
});

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('confirmModal');
    if (event.target == modal) {
        closeModal();
    }
}

// Animación de entrada para los productos
document.addEventListener('DOMContentLoaded', function() {
    const productos = document.querySelectorAll('.producto-item');
    productos.forEach((producto, index) => {
        producto.style.animation = `slideIn 0.3s ease forwards ${index * 0.05}s`;
    });
});
</script>

<style>
    /* ===== ESTILOS GENERALES (mismos que en crear) ===== */
    .producto-delete-container {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(145deg, #faf0e6 0%, #f5e6d3 100%);
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        padding: 20px 0;
        overflow-x: hidden;
    }

    /* Mantener todos los estilos de elementos decorativos del crear */
    .coffee-elements,
    .coffee-cup,
    .white-cup,
    .white-handle,
    .cup-top,
    .cup-body,
    .cup-handle,
    .steam,
    .coffee-bean,
    .particle {
        /* mismos estilos que en crear */
    }

    /* Header modificado para eliminar (tonos rojizos) */
    .delete-header {
        background: linear-gradient(135deg, #b71c1c 0%, #c62828 100%) !important;
    }

    /* ===== TARJETA PRINCIPAL ===== */
    .producto-card {
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

    /* Header de la tarjeta */
    .producto-card-header {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
    }

    .producto-card-header::after {
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
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    /* Cuerpo de la tarjeta */
    .producto-card-body {
        padding: 35px;
    }

    /* Footer de la tarjeta */
    .producto-card-footer {
        padding: 15px;
        text-align: center;
        border-top: 2px dashed #e8d5c0;
    }

    .coffee-beans-footer {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .coffee-beans-footer span {
        width: 12px;
        height: 18px;
        background: #8B4513;
        border-radius: 50%;
        transform: rotate(45deg);
        animation: bounce-footer 2s infinite;
        display: inline-block;
        opacity: 0.5;
    }

    @keyframes bounce-footer {
        0%, 100% { transform: rotate(45deg) translateY(0); }
        50% { transform: rotate(45deg) translateY(-5px); }
    }

    /* ===== BARRA DE BÚSQUEDA ===== */
    .search-bar-modern {
        position: relative;
        margin-bottom: 20px;
    }

    .search-bar-modern i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #8B4513;
        font-size: 1.1rem;
        z-index: 1;
    }

    .search-bar-modern input {
        padding-left: 45px;
        background: white;
        border: 2px solid #e8d5c0;
        border-radius: 50px;
        height: 50px;
        width: 100%;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-bar-modern input:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.1);
    }

    /* ===== LISTA DE PRODUCTOS ===== */
    .productos-list {
        max-height: 500px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .productos-list::-webkit-scrollbar {
        width: 8px;
    }

    .productos-list::-webkit-scrollbar-track {
        background: #f0e4d5;
        border-radius: 10px;
    }

    .productos-list::-webkit-scrollbar-thumb {
        background: #8B4513;
        border-radius: 10px;
    }

    .productos-list::-webkit-scrollbar-thumb:hover {
        background: #A0522D;
    }

    .producto-item {
        background: linear-gradient(145deg, #ffffff, #faf5f0);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(139, 69, 19, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .producto-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(139, 69, 19, 0.15);
        border-color: rgba(139, 69, 19, 0.3);
    }

    .producto-info {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
    }

    .producto-imagen {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        overflow: hidden;
        background: linear-gradient(145deg, #e8d5c0, #d4b99c);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .producto-imagen img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .imagen-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #8B4513;
    }

    .producto-detalles {
        flex: 1;
    }

    .producto-nombre {
        margin: 0 0 5px 0;
        color: #3E2723;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .producto-descripcion {
        margin: 0 0 8px 0;
        color: #8B6B4F;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .producto-precio {
        display: inline-block;
        background: linear-gradient(145deg, #8B4513, #A0522D);
        color: white;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 3px 10px rgba(139, 69, 19, 0.3);
    }

    /* ===== BOTÓN DE ELIMINAR ===== */
    .btn-delete-modern {
        background: linear-gradient(145deg, #ffebee, #ffcdd2);
        border: 2px solid #ef5350;
        color: #c62828;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
    }

    .btn-delete-modern:hover {
        background: linear-gradient(145deg, #ffcdd2, #ef9a9a);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(198, 40, 40, 0.3);
        border-color: #c62828;
        color: #b71c1c;
    }

    .btn-delete-modern i {
        font-size: 1.1rem;
    }

    /* ===== ESTADO VACÍO ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(145deg, #e8d5c0, #d4b99c);
        border-radius: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 3.5rem;
        color: #8B4513;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .empty-state h3 {
        color: #3E2723;
        font-size: 1.8rem;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #8B6B4F;
        font-size: 1.1rem;
        margin-bottom: 25px;
    }

    .btn-empty-action {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 15px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(74, 44, 44, 0.3);
    }

    .btn-empty-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(74, 44, 44, 0.4);
        color: white;
    }

    /* ===== MODAL DE CONFIRMACIÓN ===== */
    .modal-confirm {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: white;
        border-radius: 30px;
        width: 90%;
        max-width: 400px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
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
        background: linear-gradient(135deg, #b71c1c 0%, #c62828 100%);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
    }

    .modal-icon {
        font-size: 3.5rem;
        margin-bottom: 15px;
        animation: shake 0.5s ease;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        50% { transform: translateX(10px); }
        75% { transform: translateX(-5px); }
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.5rem;
    }

    .modal-body {
        padding: 30px;
        text-align: center;
    }

    .modal-body p {
        margin: 0 0 15px;
        color: #5D4037;
        font-size: 1.1rem;
    }

    .product-name {
        background: #f0e4d5;
        padding: 15px;
        border-radius: 15px;
        font-weight: 600;
        color: #8B4513 !important;
        font-size: 1.2rem !important;
        margin: 0 !important;
    }

    .modal-footer {
        padding: 20px 30px;
        display: flex;
        gap: 15px;
        justify-content: center;
        border-top: 2px dashed #e8d5c0;
    }

    .btn-cancel {
        background: linear-gradient(145deg, #f5f5f5, #e0e0e0);
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        background: linear-gradient(145deg, #e0e0e0, #d5d5d5);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-confirm-delete {
        background: linear-gradient(145deg, #c62828, #b71c1c);
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 5px 15px rgba(198, 40, 40, 0.4);
    }

    .btn-confirm-delete:hover {
        background: linear-gradient(145deg, #b71c1c, #a31515);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(198, 40, 40, 0.5);
    }

    /* ===== ALERTAS ===== */
    .alert-modern {
        padding: 18px 20px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideIn 0.5s ease;
    }

    .alert-success-modern {
        background: linear-gradient(145deg, #d4edda, #c3e6cb);
        border-left: 6px solid #28a745;
        color: #155724;
    }

    .alert-error-modern {
        background: linear-gradient(145deg, #f8d7da, #f5c6cb);
        border-left: 6px solid #dc3545;
        color: #721c24;
    }

    .alert-modern i {
        font-size: 1.5rem;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== FOOTER DE PRODUCTOS ===== */
    .productos-footer {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 2px dashed #e8d5c0;
        display: flex;
        justify-content: flex-end;
    }

    .productos-count {
        background: linear-gradient(145deg, #8B4513, #A0522D);
        color: white;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
    }

    /* ===== ANIMACIONES ===== */
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

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .coffee-cup {
            display: none;
        }
        
        .producto-card-header {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        
        .coffee-decoration-header {
            margin: 0 auto;
        }
        
        .producto-card-body {
            padding: 25px;
        }
        
        .producto-item {
            flex-direction: column;
            text-align: center;
        }
        
        .producto-info {
            flex-direction: column;
        }
        
        .producto-actions {
            width: 100%;
        }
        
        .btn-delete-modern {
            width: 100%;
            justify-content: center;
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