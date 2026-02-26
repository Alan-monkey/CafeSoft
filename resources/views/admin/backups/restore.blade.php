@extends('layouts.app')

@section('content')
<div class="backup-restore-container">
    <!-- Elementos decorativos de café -->
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
        <div class="coffee-bean bean-1"></div>
        <div class="coffee-bean bean-2"></div>
        <div class="coffee-bean bean-3"></div>
        <div class="coffee-bean bean-4"></div>
        <div class="coffee-bean bean-5"></div>
        <div class="coffee-bean bean-6"></div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <!-- Tarjeta principal con diseño mejorado -->
                <div class="restore-card">
                    <div class="restore-card-header">
                        <div class="header-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="header-title">
                            <h4><i class="fas fa-history"></i> Restaurar Backup</h4>
                            <p>Selecciona el backup que deseas restaurar</p>
                        </div>
                        <div class="coffee-decoration">
                            <span>☕</span>
                            <span>💾</span>
                            <span>☕</span>
                        </div>
                    </div>

                    <div class="restore-card-body">
                        <!-- Mensajes de sesión - SIN MODIFICAR -->
                        @if(session('error'))
                            <div class="alert-modern alert-danger-modern">
                                <i class="fas fa-exclamation-circle"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert-modern alert-success-modern">
                                <i class="fas fa-check-circle"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                        @endif

                        @if(session('warning'))
                            <div class="alert-modern alert-warning-modern">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>{{ session('warning') }}</div>
                            </div>
                        @endif

                        <!-- Formulario - MISMA ESTRUCTURA -->
                        <form action="{{ route('backups.restore') }}" method="POST" id="restoreForm">
                            @csrf
                            
                            <!-- Selector de backup mejorado -->
                            <div class="form-group-modern mb-4">
                                <label for="backup_file" class="form-label-modern">
                                    <i class="fas fa-file-archive"></i> Seleccionar Backup
                                </label>
                                <div class="select-wrapper">
                                    <select class="form-select-modern" id="backup_file" name="backup_file" required onchange="loadBackupDetails(this.value)">
                                        <option value="">📁 Selecciona un backup...</option>
                                        @foreach($backups as $backup)
                                        <option value="{{ $backup }}" {{ isset($filename) && $filename == $backup ? 'selected' : '' }}>
                                            {{ $backup }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                            </div>
                            
                            <!-- Información del backup seleccionado -->
                            <div id="backupInfo" style="display: none;" class="mb-4">
                                <div class="info-card">
                                    <div class="info-card-header">
                                        <i class="fas fa-info-circle"></i>
                                        <h5>Información del Backup</h5>
                                    </div>
                                    <div class="info-card-body">
                                        <div id="backupDetails" class="backup-details"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Selección de colecciones -->
                            <div class="mb-4" id="collectionsSection" style="display: none;">
                                <label class="form-label-modern">
                                    <i class="fas fa-layer-group"></i> Colecciones a restaurar
                                </label>
                                <div class="collections-toolbar mb-2">
                                    <button type="button" class="btn-toolbar" onclick="selectAllCollections(true)">
                                        <i class="fas fa-check-square"></i> Seleccionar todas
                                    </button>
                                    <button type="button" class="btn-toolbar" onclick="selectAllCollections(false)">
                                        <i class="fas fa-square"></i> Limpiar selección
                                    </button>
                                </div>
                                <div class="collections-list" id="collectionsList">
                                    <div class="text-muted-placeholder">
                                        <i class="fas fa-arrow-left"></i> Primero selecciona un backup
                                    </div>
                                </div>
                                <div class="selected-count mt-2">
                                    <span id="selectedCount">0</span> colecciones seleccionadas
                                </div>
                            </div>
                            
                            <!-- Modo de restauración -->
                            <div class="mb-4">
                                <label class="form-label-modern">
                                    <i class="fas fa-cog"></i> Modo de restauración
                                </label>
                                <div class="mode-options">
                                    <div class="mode-option">
                                        <input class="mode-radio" type="radio" name="restore_mode" 
                                               id="replace" value="replace" checked>
                                        <label class="mode-label" for="replace">
                                            <span class="mode-title">
                                                <i class="fas fa-sync-alt"></i> Reemplazar
                                            </span>
                                            <span class="mode-description">Elimina datos existentes y restaura desde backup</span>
                                        </label>
                                    </div>
                                    <div class="mode-option">
                                        <input class="mode-radio" type="radio" name="restore_mode" 
                                               id="merge" value="merge">
                                        <label class="mode-label" for="merge">
                                            <span class="mode-title">
                                                <i class="fas fa-code-branch"></i> Fusionar
                                            </span>
                                            <span class="mode-description">Mantiene datos existentes y añade del backup</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Alerta de precaución -->
                            <div class="precaution-alert">
                                <div class="alert-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="alert-content">
                                    <strong>¡Precaución!</strong>
                                    <ul>
                                        <li>La restauración puede sobrescribir datos existentes</li>
                                        <li>Se recomienda hacer un backup antes de restaurar</li>
                                        <li>Verifica que el backup sea válido y corresponda a la base de datos actual</li>
                                        <li>La restauración puede tardar varios minutos dependiendo del tamaño</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="action-buttons">
                                <a href="{{ route('backups.index') }}" class="btn-cancel">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn-restore" 
                                        onclick="return validateAndConfirm()">
                                    <i class="fas fa-upload"></i> Restaurar Backup
                                    <span class="btn-overlay"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Columna de advertencias -->
            <div class="col-md-4">
                <div class="warning-card">
                    <div class="warning-card-header">
                        <i class="fas fa-shield-alt"></i>
                        <h5>Advertencias</h5>
                    </div>
                    <div class="warning-card-body">
                        <div class="warning-item">
                            <i class="fas fa-exclamation-circle text-danger"></i>
                            <div>
                                <strong>Importante:</strong>
                                <ul>
                                    <li>Verifica que el backup sea válido</li>
                                    <li>La restauración puede tardar varios minutos</li>
                                    <li>No interrumpas el proceso de restauración</li>
                                    <li>Revisa los logs si hay errores</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Tips adicionales -->
                        <div class="tips-section mt-4">
                            <div class="tips-header">
                                <i class="fas fa-lightbulb text-warning"></i>
                                <span>Tips de seguridad</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle text-success"></i>
                                Siempre verifica el tamaño del backup
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle text-success"></i>
                                Revisa la fecha de creación
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle text-success"></i>
                                Asegura tener conexión estable
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
    .backup-restore-container {
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

    /* Tarjeta principal */
    .restore-card {
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

    .restore-card-header {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
    }

    .restore-card-header::after {
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

    .restore-card-body {
        padding: 35px;
    }

    /* Alertas modernas */
    .alert-modern {
        padding: 18px 20px;
        border-radius: 15px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideIn 0.5s ease;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-danger-modern {
        background: linear-gradient(145deg, #ffebee, #ffcdd2);
        border-left: 6px solid #f44336;
        color: #b71c1c;
    }

    .alert-success-modern {
        background: linear-gradient(145deg, #e8f5e9, #c8e6c9);
        border-left: 6px solid #4caf50;
        color: #1b5e20;
    }

    .alert-warning-modern {
        background: linear-gradient(145deg, #fff3e0, #ffe0b2);
        border-left: 6px solid #ff9800;
        color: #bf360c;
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

    /* Info card */
    .info-card {
        background: linear-gradient(145deg, #fff9f0, #f5e6d3);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #E8D5C0;
    }

    .info-card-header {
        background: linear-gradient(145deg, #f0e4d5, #e8d5c0);
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-card-header i {
        color: #8B4513;
        font-size: 1.3rem;
    }

    .info-card-header h5 {
        margin: 0;
        color: #5D4037;
        font-weight: 600;
    }

    .info-card-body {
        padding: 20px;
    }

    .backup-details p {
        margin-bottom: 8px;
        color: #5D4037;
    }

    /* Colecciones */
    .collections-toolbar {
        display: flex;
        gap: 10px;
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

    .collections-list {
        border: 2px solid #E8D5C0;
        border-radius: 15px;
        padding: 15px;
        max-height: 300px;
        overflow-y: auto;
        background: white;
    }

    .text-muted-placeholder {
        color: #B2967D;
        text-align: center;
        padding: 30px;
    }

    .form-check {
        margin-bottom: 10px;
        padding: 8px 12px;
        border-radius: 10px;
        transition: background 0.3s ease;
    }

    .form-check:hover {
        background: #f5e6d3;
    }

    .collection-checkbox {
        margin-right: 10px;
        accent-color: #8B4513;
    }

    .selected-count {
        color: #5D4037;
        font-weight: 500;
    }

    .selected-count span {
        background: #8B4513;
        color: white;
        padding: 3px 10px;
        border-radius: 15px;
        margin-right: 5px;
    }

    /* Modos de restauración */
    .mode-options {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .mode-option {
        background: white;
        border: 2px solid #E8D5C0;
        border-radius: 15px;
        padding: 15px;
        transition: all 0.3s ease;
    }

    .mode-option:hover {
        border-color: #8B4513;
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.1);
    }

    .mode-radio {
        display: none;
    }

    .mode-label {
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }

    .mode-title {
        font-weight: 700;
        color: #8B4513;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mode-description {
        color: #5D4037;
        font-size: 0.9rem;
    }

    .mode-radio:checked + .mode-label .mode-title {
        color: #28a745;
    }

    .mode-radio:checked + .mode-label .mode-title i {
        color: #28a745;
    }

    /* Alerta de precaución */
    .precaution-alert {
        background: linear-gradient(145deg, #fff3e0, #ffe0b2);
        border-radius: 20px;
        padding: 20px;
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        border: 1px solid #ff9800;
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        background: #ff9800;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
    }

    .alert-content {
        flex: 1;
    }

    .alert-content strong {
        color: #bf360c;
        display: block;
        margin-bottom: 8px;
    }

    .alert-content ul {
        margin: 0;
        padding-left: 20px;
        color: #5D4037;
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

    .btn-restore {
        background: linear-gradient(135deg, #ff9800, #f57c00);
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

    .btn-restore:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(255, 152, 0, 0.4);
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

    .btn-restore:hover .btn-overlay {
        width: 300px;
        height: 300px;
    }

    /* Warning card */
    .warning-card {
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

    .warning-card-header {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .warning-card-header i {
        font-size: 1.8rem;
    }

    .warning-card-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .warning-card-body {
        padding: 25px;
    }

    .warning-item {
        display: flex;
        gap: 12px;
    }

    .warning-item i {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .warning-item ul {
        margin: 10px 0 0;
        padding-left: 20px;
        color: #5D4037;
    }

    .tips-section {
        background: linear-gradient(145deg, #fff9f0, #f5e6d3);
        border-radius: 15px;
        padding: 20px;
    }

    .tips-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 15px;
        color: #5D4037;
        font-weight: 600;
    }

    .tip-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        color: #5D4037;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .restore-card-body {
            padding: 25px 20px;
        }
        
        .coffee-cup {
            display: none;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-cancel, .btn-restore {
            width: 100%;
            justify-content: center;
        }
        
        .collections-toolbar {
            flex-direction: column;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Script original - SIN MODIFICAR -->
<script>
// Variables globales
let currentBackupData = null;

// Función para cargar detalles del backup
function loadBackupDetails(filename) {
    console.log('loadBackupDetails llamado con:', filename);
    
    if (!filename) {
        document.getElementById('backupInfo').style.display = 'none';
        document.getElementById('collectionsSection').style.display = 'none';
        return;
    }
    
    // Mostrar indicador de carga
    document.getElementById('collectionsList').innerHTML = '<div class="text-center">Cargando información del backup...</div>';
    document.getElementById('collectionsSection').style.display = 'block';
    
    // Obtener información del backup
    fetch(`/backups/test-restore/${filename}`)
        .then(response => {
            console.log('Respuesta recibida:', response);
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            
            currentBackupData = data;
            
            // Determinar las colecciones
            let collections = [];
            
            if (data.collections && Array.isArray(data.collections) && data.collections.length > 0) {
                collections = data.collections;
            } else if (data.debug && data.debug.files_in_zip && data.debug.files_in_zip.length > 0) {
                collections = data.debug.files_in_zip;
            } else if (data.collections_details && data.collections_details.length > 0) {
                collections = data.collections_details.map(c => c.name);
            }
            
            console.log('Colecciones encontradas:', collections);
            
            // Mostrar información general
            document.getElementById('backupInfo').style.display = 'block';
            let detailsHtml = `
                <p><strong>Backup:</strong> ${data.backup_name || filename}</p>
                <p><strong>Creado por:</strong> ${data.created_by || 'Desconocido'}</p>
                <p><strong>Fecha:</strong> ${data.created_at || 'Desconocida'}</p>
                <p><strong>Total documentos:</strong> ${data.total_documents || 0}</p>
                <p><strong>Colecciones encontradas:</strong> ${collections.length}</p>
            `;
            document.getElementById('backupDetails').innerHTML = detailsHtml;
            
            // Mostrar colecciones disponibles
            if (collections && collections.length > 0) {
                let collectionsHtml = '';
                collections.forEach(collection => {
                    // Buscar detalles de la colección
                    let docCount = '';
                    if (data.collections_details) {
                        const details = data.collections_details.find(c => c.name === collection);
                        if (details && details.documents_count) {
                            docCount = `<span class="text-muted"> (${details.documents_count} documentos)</span>`;
                        }
                    }
                    
                    collectionsHtml += `
                        <div class="form-check">
                            <input class="form-check-input collection-checkbox" type="checkbox" 
                                   name="collections_to_restore[]" value="${collection}" 
                                   id="col_${collection}" onchange="updateSelectedCount()">
                            <label class="form-check-label" for="col_${collection}">
                                ${collection} ${docCount}
                            </label>
                        </div>
                    `;
                });
                document.getElementById('collectionsList').innerHTML = collectionsHtml;
                updateSelectedCount();
            } else {
                document.getElementById('collectionsList').innerHTML = '<div class="text-warning">No se encontraron colecciones en este backup</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('collectionsList').innerHTML = '<div class="text-danger">Error al cargar información del backup</div>';
        });
}

function selectAllCollections(select) {
    const checkboxes = document.querySelectorAll('.collection-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = select;
    });
    updateSelectedCount();
}

function updateSelectedCount() {
    const selected = document.querySelectorAll('.collection-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = selected;
}

function validateAndConfirm() {
    const selectedCollections = document.querySelectorAll('.collection-checkbox:checked').length;
    
    if (selectedCollections === 0) {
        alert('Debes seleccionar al menos una colección para restaurar');
        return false;
    }
    
    const backupFile = document.getElementById('backup_file').value;
    if (!backupFile) {
        alert('Debes seleccionar un archivo de backup');
        return false;
    }
    
    const mode = document.querySelector('input[name="restore_mode"]:checked').value;
    const modeText = mode === 'replace' ? 'REEMPLAZAR' : 'FUSIONAR';
    
    return confirm(`¿Estás seguro de restaurar ${selectedCollections} colecciones en modo ${modeText}?\n\n` +
                  'Esta acción no se puede deshacer fácilmente.');
}

// Cargar detalles si hay un filename en la URL
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado');
    const select = document.getElementById('backup_file');
    console.log('Select element:', select);
    
    if (select && select.value) {
        console.log('Valor inicial del select:', select.value);
        loadBackupDetails(select.value);
    }
});
</script>
@endsection