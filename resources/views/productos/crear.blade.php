@extends('layouts.app')
@section('content')

<div class="producto-create-container">
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
            <div class="col-md-8 col-lg-6">
                <!-- Tarjeta principal con estilo glassmorphism -->
                <div class="producto-card">
                    <div class="producto-card-header">
                        <div class="header-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="header-title">
                            <h4><i class="fas fa-coffee"></i> Añadir producto</h4>
                            <p>Nueva delicia para tu cafetería</p>
                        </div>
                        <div class="coffee-decoration-header">
                            <span>☕</span>
                            <span>✨</span>
                            <span>☕</span>
                        </div>
                    </div>

                    <div class="producto-card-body">
                        <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Campo Nombre -->
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-cookie-bite"></i> Nombre del producto
                                </label>
                                <div class="input-wrapper-modern">
                                    <input type="text" name="nombre" class="form-control-modern" 
                                           placeholder="Ej: Cappuccino Caramelo" required>
                                    <span class="focus-border"></span>
                                </div>
                            </div>

                            <!-- Campo Precio -->
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-tag"></i> Precio
                                </label>
                                <div class="input-wrapper-modern">
                                    <input type="number" step="0.01" name="precio" class="form-control-modern" 
                                           placeholder="$0.00" required>
                                    <span class="focus-border"></span>
                                </div>
                            </div>

                            <!-- Campo Descripción -->
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-pencil-alt"></i> Descripción
                                </label>
                                <div class="input-wrapper-modern">
                                    <textarea name="descripcion" class="form-control-modern" 
                                              placeholder="Describe este delicioso producto..." required rows="4"></textarea>
                                    <span class="focus-border"></span>
                                </div>
                            </div>

                            <!-- Campo Imagen -->
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-image"></i> Imagen
                                </label>
                                <div class="file-input-wrapper-modern">
                                    <input type="file" name="imagen" accept="image/*" id="fileInput">
                                    <div class="file-input-button-modern" id="fileButton">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Seleccionar imagen (opcional)</span>
                                    </div>
                                </div>
                                <small class="form-text-modern">
                                    <i class="fas fa-info-circle"></i> Formatos: JPG, PNG, GIF
                                </small>
                            </div>

                            <!-- ===== NUEVOS CAMPOS DE STOCK ===== -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-boxes"></i> Stock inicial
                                        </label>
                                        <div class="input-wrapper-modern">
                                            <input type="number" name="stock_inicial" class="form-control-modern" 
                                                   placeholder="Ej: 50" min="0" value="0" required>
                                            <span class="focus-border"></span>
                                        </div>
                                        <small class="form-text-modern">
                                            <i class="fas fa-info-circle"></i> Cantidad disponible para la venta
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-exclamation-triangle"></i> Stock mínimo
                                        </label>
                                        <div class="input-wrapper-modern">
                                            <input type="number" name="stock_minimo" class="form-control-modern" 
                                                   placeholder="Ej: 10" min="0" value="5" required>
                                            <span class="focus-border"></span>
                                        </div>
                                        <small class="form-text-modern">
                                            <i class="fas fa-info-circle"></i> Alerta cuando el stock baje de esta cantidad
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <!-- ===== FIN NUEVOS CAMPOS DE STOCK ===== -->

                            <!-- Botón de envío -->
                            <button type="submit" class="btn-submit-modern">
                                <i class="fas fa-save"></i> Guardar producto
                                <span class="btn-overlay"></span>
                            </button>
                        </form>

                        @if (session('success'))
                        <div class="alert-modern alert-success-modern mt-4">
                            <i class="fas fa-check-circle"></i>
                            <div class="alert-content">
                                {{ session('success') }}
                            </div>
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

<!-- Script para mostrar nombre del archivo seleccionado -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fileInput');
    const fileButton = document.getElementById('fileButton').querySelector('span');
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Seleccionar imagen (opcional)';
            fileButton.textContent = fileName;
        });
    }
});
</script>

<style>
    /* ===== ESTILOS GENERALES (mismos que backups y productos) ===== */
    .producto-create-container {
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
    }

    .coffee-decoration-header span:nth-child(2) { animation-delay: 0.3s; }

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

    .coffee-beans-footer span:nth-child(2) { animation-delay: 0.2s; }
    .coffee-beans-footer span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes bounce-footer {
        0%, 100% { transform: rotate(45deg) translateY(0); }
        50% { transform: rotate(45deg) translateY(-5px); }
    }

    /* ===== FORMULARIO ===== */
    .form-group-modern {
        margin-bottom: 25px;
    }

    .form-label-modern {
        display: block;
        margin-bottom: 10px;
        color: #5D4037;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-label-modern i {
        margin-right: 8px;
        color: #8B4513;
    }

    .input-wrapper-modern {
        position: relative;
    }

    .form-control-modern {
        width: 100%;
        padding: 14px 20px;
        border: 2px solid #e8d5c0;
        border-radius: 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        color: #3E2723;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.1);
    }

    textarea.form-control-modern {
        min-height: 120px;
        resize: vertical;
    }

    .focus-border {
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, #8B4513, #C97C5D);
        transition: all 0.3s ease;
        transform: translateX(-50%);
        border-radius: 3px;
    }

    .form-control-modern:focus ~ .focus-border {
        width: 100%;
    }

    /* File input moderno */
    .file-input-wrapper-modern {
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .file-input-wrapper-modern input[type=file] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 10;
    }

    .file-input-button-modern {
        background: linear-gradient(145deg, #f0e4d5, #e8d5c0);
        border: 2px dashed #8B4513;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        color: #8B4513;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        cursor: pointer;
    }

    .file-input-button-modern:hover {
        background: #e8d5c0;
        border-color: #8B4513;
        color: #8B4513;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(139, 69, 19, 0.2);
    }

    .file-input-button-modern i {
        font-size: 2rem;
    }

    .form-text-modern {
        display: block;
        margin-top: 8px;
        color: #B2967D;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ===== NUEVOS ESTILOS PARA CAMPOS DE STOCK ===== */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -10px;
        margin-left: -10px;
        margin-bottom: 15px;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding-right: 10px;
        padding-left: 10px;
    }

    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Animación para los campos de stock */
    .row .form-group-modern {
        animation: slideInStock 0.5s ease forwards;
        opacity: 0;
    }

    @keyframes slideInStock {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .row .col-md-6:first-child .form-group-modern {
        animation-delay: 0.1s;
    }

    .row .col-md-6:last-child .form-group-modern {
        animation-delay: 0.2s;
    }

    /* Estilo especial para inputs numéricos */
    input[type=number].form-control-modern {
        -moz-appearance: textfield;
    }

    input[type=number].form-control-modern::-webkit-outer-spin-button,
    input[type=number].form-control-modern::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* ===== BOTÓN DE ENVÍO ===== */
    .btn-submit-modern {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 16px 30px;
        font-size: 1.2rem;
        font-weight: 600;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        text-transform: uppercase;
        box-shadow: 0 8px 20px rgba(74, 44, 44, 0.3);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-submit-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(74, 44, 44, 0.4);
        background: linear-gradient(135deg, #9C4F1E 0%, #B45F2E 100%);
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

    .btn-submit-modern:hover .btn-overlay {
        width: 300px;
        height: 300px;
    }

    /* Alerta de éxito */
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

    /* Responsive general */
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
        
        .file-input-button-modern {
            padding: 20px;
            flex-direction: column;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@endsection