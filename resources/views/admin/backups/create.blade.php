@extends('layouts.app')

@section('content')
<div class="backup-create-container">
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
        <div class="coffee-bean bean-6"></div>
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <!-- Tarjeta principal con diseño mejorado -->
                <div class="create-card">
                    <div class="create-card-header">
                        <div class="header-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="header-title">
                            <h4><i class="fas fa-plus-circle"></i> Crear Nuevo Backup</h4>
                            <p>Protege tus datos con un respaldo seguro</p>
                        </div>
                        <div class="coffee-decoration">
                            <span>☕</span>
                            <span>💾</span>
                            <span>☕</span>
                        </div>
                    </div>

                    <div class="create-card-body">
                        <!-- Formulario - MISMA ESTRUCTURA -->
                        <form action="{{ route('backups.store') }}" method="POST">
                            @csrf
                            
                            <!-- Campo nombre mejorado -->
                            <div class="form-group-modern mb-4">
                                <label for="name" class="form-label-modern">
                                    <i class="fas fa-tag"></i> Nombre del Backup (opcional)
                                </label>
                                <div class="input-wrapper-modern">
                                    <input type="text" class="form-control-modern" id="name" name="name" 
                                           placeholder="Ej: backup_diario">
                                    <span class="focus-border"></span>
                                </div>
                                <div class="form-text-modern">
                                    <i class="fas fa-info-circle"></i> Si se deja vacío, se usará la fecha actual
                                </div>
                            </div>
                            
                            <!-- Selección de colecciones mejorada -->
                            <div class="form-group-modern mb-4">
                                <label class="form-label-modern">
                                    <i class="fas fa-layer-group"></i> Colecciones a incluir
                                </label>
                                <div class="collections-container">
                                    <div class="collections-list">
                                        @foreach($collections as $collection)
                                        <div class="collection-item">
                                            <input class="collection-checkbox" type="checkbox" 
                                                   name="collections[]" value="{{ $collection }}" 
                                                   id="col_{{ $collection }}" checked>
                                            <label class="collection-label" for="col_{{ $collection }}">
                                                <i class="fas fa-folder"></i>
                                                {{ $collection }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="collections-toolbar mt-3">
                                        <button type="button" class="btn-toolbar" onclick="selectAllCollections()">
                                            <i class="fas fa-check-square"></i> Seleccionar todas
                                        </button>
                                        <button type="button" class="btn-toolbar" onclick="deselectAllCollections()">
                                            <i class="fas fa-square"></i> Deseleccionar todas
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Fila de opciones -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-modern mb-4">
                                        <label for="format" class="form-label-modern">
                                            <i class="fas fa-file-export"></i> Formato de exportación
                                        </label>
                                        <div class="select-wrapper">
                                            <select class="form-select-modern" id="format" name="format">
                                                <option value="json">📄 JSON (recomendado)</option>
                                                <option value="csv">📊 CSV</option>
                                                <option value="zip">🗜️ ZIP (comprimido)</option>
                                            </select>
                                            <i class="fas fa-chevron-down select-arrow"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern mb-4">
                                        <div class="structure-checkbox">
                                            <input class="styled-checkbox" type="checkbox" 
                                                   id="include_structure" name="include_structure" value="1">
                                            <label class="checkbox-label" for="include_structure">
                                                <span class="checkbox-custom"></span>
                                                <span class="checkbox-text">
                                                    <i class="fas fa-sitemap"></i> Incluir estructura (índices)
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Alerta de información -->
                            <div class="info-alert">
                                <div class="alert-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="alert-content">
                                    <strong>Nota:</strong> El backup se guardará en 
                                    <code class="code-highlight">storage/app/backups/</code>
                                </div>
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="action-buttons">
                                <a href="{{ route('backups.index') }}" class="btn-cancel">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn-create">
                                    <i class="fas fa-save"></i> Crear Backup
                                    <span class="btn-overlay"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Columna de información -->
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-info-circle"></i>
                        <h5>Información</h5>
                    </div>
                    <div class="info-card-body">
                        <div class="info-section">
                            <h6 class="section-title">
                                <i class="fas fa-file-code"></i> Formatos disponibles:
                            </h6>
                            <ul class="info-list">
                                <li class="info-item">
                                    <span class="badge-format">JSON</span>
                                    <span class="format-desc">Ideal para MongoDB, mantiene la estructura de documentos</span>
                                </li>
                                <li class="info-item">
                                    <span class="badge-format">CSV</span>
                                    <span class="format-desc">Útil para importar en hojas de cálculo</span>
                                </li>
                                <li class="info-item">
                                    <span class="badge-format">ZIP</span>
                                    <span class="format-desc">Comprime todos los archivos en uno solo</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="info-divider"></div>
                        
                        <div class="info-section">
                            <h6 class="section-title">
                                <i class="fas fa-lightbulb"></i> Recomendaciones:
                            </h6>
                            <ul class="tip-list">
                                <li class="tip-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Realiza backups regularmente</span>
                                </li>
                                <li class="tip-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Guarda los backups en un lugar seguro</span>
                                </li>
                                <li class="tip-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Verifica que los backups se puedan restaurar</span>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Tips adicionales -->
                        <div class="extra-tips">
                            <div class="tip-bubble">
                                <i class="fas fa-database"></i>
                                <span>Los backups protegen tu información</span>
                            </div>
                            <div class="tip-bubble">
                                <i class="fas fa-clock"></i>
                                <span>Programa backups automáticos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos generales */
    .backup-create-container {
        min-height: 100vh;
        background: linear-gradient(145deg, #f5e6d3 0%, #f0dcc9 100%);
        position: relative;
        overflow: hidden;
        font-family: 'Poppins', 'Segoe UI', sans-serif;
    }

    /* Elementos decorativos - TAZAS BLANCAS */
    .coffee-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .coffee-cup {
        position: absolute;
        animation: float-cup 8s ease-in-out infinite;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3));
    }

    .cup-1 { top: 10%; left: 5%; transform: scale(0.8); animation-delay: 0s; }
    .cup-2 { bottom: 15%; right: 8%; transform: scale(0.7) rotate(-10deg); animation-delay: 2s; }
    .cup-3 { top: 30%; right: 12%; transform: scale(0.6) rotate(15deg); animation-delay: 4s; }

    .white-cup {
        background: linear-gradient(145deg, #ffffff, #f0f0f0) !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .white-handle {
        border-color: #f0f0f0 !important;
        border-right: 8px solid #ffffff !important;
    }

    .cup-top {
        width: 80px;
        height: 20px;
        border-radius: 50%;
        position: relative;
        z-index: 2;
        background: linear-gradient(145deg, #ffffff, #e0e0e0);
    }

    .cup-body {
        width: 70px;
        height: 60px;
        border-radius: 0 0 35px 35px;
        position: relative;
        top: -10px;
        background: linear-gradient(145deg, #ffffff, #f5f5f5);
    }

    .cup-handle {
        width: 25px;
        height: 40px;
        border: 8px solid #6F4E37;
        border-left: none;
        border-radius: 0 20px 20px 0;
        position: absolute;
        right: -20px;
        top: 15px;
        border-color: #f0f0f0;
    }

    .steam {
        position: absolute;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        animation: steam-animation 3s infinite ease-in-out;
    }

    .s1 { width: 15px; height: 15px; top: -25px; left: 20px; animation-delay: 0s; }
    .s2 { width: 12px; height: 12px; top: -35px; left: 32px; animation-delay: 0.5s; }
    .s3 { width: 10px; height: 10px; top: -30px; left: 45px; animation-delay: 1s; }

    @keyframes steam-animation {
        0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
        50% { transform: translateY(-20px) scale(1.2); opacity: 0.2; }
    }

    @keyframes float-cup {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(2deg); }
    }

    /* Granos de café */
    .coffee-bean {
        position: absolute;
        width: 20px;
        height: 10px;
        background: #8B4513;
        border-radius: 50%;
        opacity: 0.4;
        animation: float-bean 15s infinite linear;
        transform: rotate(45deg);
    }

    .bean-1 { top: 10%; left: 20%; animation-delay: 0s; width: 25px; height: 12px; }
    .bean-2 { top: 70%; left: 85%; animation-delay: 3s; width: 18px; height: 9px; }
    .bean-3 { top: 50%; left: 15%; animation-delay: 6s; width: 22px; height: 11px; }
    .bean-4 { top: 80%; left: 40%; animation-delay: 9s; width: 20px; height: 10px; }
    .bean-5 { top: 30%; left: 90%; animation-delay: 12s; width: 28px; height: 14px; }
    .bean-6 { top: 90%; left: 60%; animation-delay: 15s; width: 15px; height: 8px; }

    @keyframes float-bean {
        0% { transform: translateY(0) rotate(45deg) scale(1); opacity: 0.4; }
        100% { transform: translateY(-100vh) rotate(405deg) scale(0.5); opacity: 0; }
    }

    /* Partículas */
    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        animation: particle-float 10s infinite linear;
    }

    .particle-1 { top: 30%; left: 10%; animation-delay: 0s; }
    .particle-2 { top: 60%; left: 80%; animation-delay: 2.5s; }
    .particle-3 { top: 20%; left: 95%; animation-delay: 5s; }
    .particle-4 { top: 80%; left: 20%; animation-delay: 7.5s; }
    .particle-5 { top: 40%; left: 40%; animation-delay: 3.2s; }

    @keyframes particle-float {
        0% { transform: translateY(0) scale(1); opacity: 0.3; }
        100% { transform: translateY(-100vh) scale(0); opacity: 0; }
    }

    /* Tarjeta principal */
    .create-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(139, 69, 19, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: fadeInUp 0.8s ease;
        position: relative;
        z-index: 10;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .create-card-header {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
    }

    .create-card-header::after {
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

    .coffee-decoration {
        margin-left: auto;
        font-size: 1.5rem;
    }

    .coffee-decoration span {
        margin: 0 5px;
        animation: bounce 2s infinite;
    }

    .coffee-decoration span:nth-child(2) { animation-delay: 0.3s; }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .create-card-body {
        padding: 35px;
    }

    /* Formulario */
    .form-group-modern {
        margin-bottom: 25px;
    }

    .form-label-modern {
        display: block;
        margin-bottom: 10px;
        color: #5D4037;
        font-weight: 600;
        font-size: 1rem;
    }

    .form-label-modern i {
        color: #8B4513;
        margin-right: 8px;
    }

    .input-wrapper-modern {
        position: relative;
    }

    .form-control-modern {
        width: 100%;
        padding: 16px 20px;
        border: 2px solid #E8D5C0;
        border-radius: 15px;
        font-size: 1rem;
        background: white;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.1);
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

    .form-text-modern {
        margin-top: 8px;
        color: #B2967D;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Colecciones */
    .collections-container {
        background: white;
        border: 2px solid #E8D5C0;
        border-radius: 20px;
        padding: 20px;
    }

    .collections-list {
        max-height: 300px;
        overflow-y: auto;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
    }

    .collection-item {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .collection-item:hover {
        background: #f5e6d3;
        transform: translateY(-2px);
    }

    .collection-checkbox {
        accent-color: #8B4513;
        width: 18px;
        height: 18px;
        margin-right: 10px;
    }

    .collection-label {
        color: #5D4037;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .collection-label i {
        color: #8B4513;
    }

    .collections-toolbar {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-toolbar {
        background: white;
        border: 2px solid #8B4513;
        color: #8B4513;
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-toolbar:hover {
        background: #8B4513;
        color: white;
        transform: translateY(-2px);
    }

    /* Select */
    .select-wrapper {
        position: relative;
    }

    .form-select-modern {
        width: 100%;
        padding: 16px 20px;
        border: 2px solid #E8D5C0;
        border-radius: 15px;
        font-size: 1rem;
        background: white;
        transition: all 0.3s ease;
        appearance: none;
        cursor: pointer;
    }

    .form-select-modern:focus {
        outline: none;
        border-color: #8B4513;
        box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.1);
    }

    .select-arrow {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #8B4513;
        pointer-events: none;
    }

    /* Checkbox personalizado */
    .structure-checkbox {
        margin-top: 32px;
    }

    .styled-checkbox {
        display: none;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .checkbox-custom {
        width: 24px;
        height: 24px;
        border: 2px solid #8B4513;
        border-radius: 8px;
        position: relative;
        transition: all 0.3s ease;
    }

    .checkbox-custom::after {
        content: '';
        position: absolute;
        left: 7px;
        top: 3px;
        width: 6px;
        height: 12px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .styled-checkbox:checked + .checkbox-label .checkbox-custom {
        background: #8B4513;
    }

    .styled-checkbox:checked + .checkbox-label .checkbox-custom::after {
        opacity: 1;
    }

    .checkbox-text {
        color: #5D4037;
        font-weight: 500;
    }

    .checkbox-text i {
        color: #8B4513;
        margin-right: 5px;
    }

    /* Alerta de información */
    .info-alert {
        background: linear-gradient(145deg, #e1f5fe, #b3e5fc);
        border-radius: 20px;
        padding: 20px;
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        border: 1px solid #0288d1;
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        background: #0288d1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
    }

    .alert-content {
        flex: 1;
        color: #01579b;
    }

    .alert-content strong {
        display: block;
        margin-bottom: 5px;
    }

    .code-highlight {
        background: #01579b;
        color: white;
        padding: 3px 10px;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    /* Botones de acción */
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .btn-cancel {
        background: linear-gradient(145deg, #6c757d, #5a6268);
        color: white;
        padding: 14px 30px;
        border-radius: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        font-weight: 500;
    }

    .btn-cancel:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
        color: white;
    }

    .btn-create {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }

    .btn-create:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.4);
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

    .btn-create:hover .btn-overlay {
        width: 300px;
        height: 300px;
    }

    /* Info card */
    .info-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(139, 69, 19, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: fadeInUp 0.8s ease;
        position: relative;
        z-index: 10;
    }

    .info-card-header {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-card-header i {
        font-size: 1.8rem;
    }

    .info-card-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .info-card-body {
        padding: 25px;
    }

    .info-section {
        margin-bottom: 20px;
    }

    .section-title {
        color: #5D4037;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        padding: 8px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .badge-format {
        background: #8B4513;
        color: white;
        padding: 4px 10px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        min-width: 50px;
        text-align: center;
    }

    .format-desc {
        color: #5D4037;
        font-size: 0.9rem;
    }

    .info-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent, #E8D5C0, transparent);
        margin: 20px 0;
    }

    .tip-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tip-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .extra-tips {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .tip-bubble {
        background: linear-gradient(135deg, #8B4513, #A0522D);
        color: white;
        padding: 15px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .create-card-body {
            padding: 25px 20px;
        }
        
        .coffee-cup {
            display: none;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-cancel, .btn-create {
            width: 100%;
            justify-content: center;
        }
        
        .collections-list {
            grid-template-columns: 1fr;
        }
        
        .collections-toolbar {
            flex-direction: column;
        }
        
        .info-item {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@push('scripts')
<!-- Script original - SIN MODIFICAR -->
<script>
    function selectAllCollections() {
        document.querySelectorAll('input[name="collections[]"]').forEach(checkbox => {
            checkbox.checked = true;
        });
    }
    
    function deselectAllCollections() {
        document.querySelectorAll('input[name="collections[]"]').forEach(checkbox => {
            checkbox.checked = false;
        });
    }
</script>
@endpush