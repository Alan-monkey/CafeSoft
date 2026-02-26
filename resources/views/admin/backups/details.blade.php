@extends('layouts.app')

@section('content')
<div class="backup-detail-container">
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
        <div class="coffee-bean bean-1"></div>
        <div class="coffee-bean bean-2"></div>
        <div class="coffee-bean bean-3"></div>
        <div class="coffee-bean bean-4"></div>
        <div class="coffee-bean bean-5"></div>
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <!-- Tarjeta principal -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <div class="header-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="header-title">
                            <h4><i class="fas fa-info-circle"></i> Detalles del Backup</h4>
                            <p class="backup-name-badge">{{ $metadata['backup_name'] }}</p>
                        </div>
                        <div class="coffee-decoration">
                            <span>☕</span>
                            <span>📋</span>
                            <span>☕</span>
                        </div>
                    </div>

                    <div class="detail-card-body">
                        <!-- Botones de acción superiores -->
                        <div class="action-buttons-top mb-4">
                            <a href="{{ route('backups.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <a href="{{ route('backups.download', $filename) }}" class="btn-download">
                                <i class="fas fa-download"></i> Descargar Backup
                                <span class="btn-overlay"></span>
                            </a>
                        </div>

                        <!-- Grid de información -->
                        <div class="row">
                            <!-- Columna izquierda - Información General -->
                            <div class="col-md-6">
                                <div class="info-card-modern mb-4">
                                    <div class="info-card-header gradient-primary">
                                        <i class="fas fa-info-circle"></i>
                                        <h5 class="mb-0">Información General</h5>
                                    </div>
                                    <div class="info-card-body">
                                        <div class="info-table">
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fas fa-tag"></i> Nombre del backup:
                                                </span>
                                                <span class="info-value highlight">{{ $metadata['backup_name'] }}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fas fa-file"></i> Archivo:
                                                </span>
                                                <span class="info-value"><code class="code-block">{{ $filename }}</code></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fas fa-calendar"></i> Fecha de creación:
                                                </span>
                                                <span class="info-value">{{ $metadata['created_at'] }}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fas fa-database"></i> Base de datos:
                                                </span>
                                                <span class="info-value">
                                                    <span class="badge-database">{{ $metadata['database'] }}</span>
                                                </span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fas fa-file-export"></i> Formato:
                                                </span>
                                                <span class="info-value">
                                                    <span class="badge-format">{{ $metadata['format'] }}</span>
                                                </span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fas fa-weight"></i> Tamaño del archivo:
                                                </span>
                                                <span class="info-value file-size">{{ formatBytes($file_size) }}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fas fa-clock"></i> Fecha del archivo:
                                                </span>
                                                <span class="info-value">{{ $file_date }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Columna derecha - Información del Usuario -->
                            <div class="col-md-6">
                                <div class="info-card-modern mb-4">
                                    <div class="info-card-header gradient-primary">
                                        <i class="fas fa-user"></i>
                                        <h5 class="mb-0">Información del Usuario</h5>
                                    </div>
                                    <div class="info-card-body">
                                        <div class="user-info-box">
                                            <div class="user-avatar-large">
                                                {{ strtoupper(substr($metadata['created_by'], 0, 1)) }}
                                            </div>
                                            <div class="user-details">
                                                <h4 class="user-name">{{ $metadata['created_by'] }}</h4>
                                                @if(isset($metadata['created_by_email']))
                                                    <p class="user-email">
                                                        <i class="fas fa-envelope"></i> {{ $metadata['created_by_email'] }}
                                                    </p>
                                                @endif
                                                @if(isset($metadata['created_by_id']))
                                                    <p class="user-id">
                                                        <i class="fas fa-id-card"></i> ID: {{ $metadata['created_by_id'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Colecciones Incluidas -->
                        @if(isset($metadata['collections_details']) && !empty($metadata['collections_details']))
                        <div class="info-card-modern mb-4">
                            <div class="info-card-header gradient-primary">
                                <i class="fas fa-database"></i>
                                <h5 class="mb-0">Colecciones Incluidas</h5>
                                <span class="header-badge">{{ count($metadata['collections_details']) }} colecciones</span>
                            </div>
                            <div class="info-card-body">
                                <div class="table-responsive">
                                    <table class="collections-table">
                                        <thead>
                                            <tr>
                                                <th><i class="fas fa-folder"></i> Colección</th>
                                                <th class="text-end"><i class="fas fa-file"></i> Documentos</th>
                                                <th class="text-center">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($metadata['collections_details'] as $collection)
                                            <tr>
                                                <td>
                                                    <code class="collection-code">{{ $collection['name'] }}</code>
                                                </td>
                                                <td class="text-end">
                                                    <span class="document-count">{{ number_format($collection['documents_count']) }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if($collection['documents_count'] > 0)
                                                        <span class="status-badge success">
                                                            <i class="fas fa-check-circle"></i> Exportada
                                                        </span>
                                                    @else
                                                        <span class="status-badge warning">
                                                            <i class="fas fa-exclamation-triangle"></i> Vacía
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th class="text-end">
                                                    <span class="total-badge">{{ number_format($metadata['total_documents'] ?? 0) }}</span>
                                                </th>
                                                <th class="text-center">
                                                    <span class="total-collections">{{ count($metadata['collections_details']) }} colecciones</span>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Información del Sistema -->
                        @if(isset($metadata['system_info']))
                        <div class="info-card-modern mb-4">
                            <div class="info-card-header gradient-primary">
                                <i class="fas fa-server"></i>
                                <h5 class="mb-0">Información del Sistema</h5>
                            </div>
                            <div class="info-card-body">
                                <div class="system-grid">
                                    <div class="system-card">
                                        <div class="system-icon">
                                            <i class="fab fa-php"></i>
                                        </div>
                                        <div class="system-info">
                                            <span class="system-label">PHP</span>
                                            <span class="system-value">{{ $metadata['system_info']['php_version'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="system-card">
                                        <div class="system-icon">
                                            <i class="fab fa-laravel"></i>
                                        </div>
                                        <div class="system-info">
                                            <span class="system-label">Laravel</span>
                                            <span class="system-value">{{ $metadata['system_info']['laravel_version'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="system-card">
                                        <div class="system-icon">
                                            <i class="fas fa-network-wired"></i>
                                        </div>
                                        <div class="system-info">
                                            <span class="system-label">Servidor</span>
                                            <span class="system-value">{{ $metadata['system_info']['server'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Footer con acciones principales -->
                    <div class="detail-card-footer">
                        <div class="footer-actions">
                            <a href="{{ route('backups.restore.form', $filename) }}" class="btn-restore-footer">
                                <i class="fas fa-upload"></i> Restaurar este Backup
                                <span class="btn-overlay"></span>
                            </a>
                            <form action="{{ route('backups.delete', $filename) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar el backup \'{{ $metadata['backup_name'] }}\'?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-footer">
                                    <i class="fas fa-trash"></i> Eliminar Backup
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos generales */
    .backup-detail-container {
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

    @keyframes particle-float {
        0% { transform: translateY(0) scale(1); opacity: 0.3; }
        100% { transform: translateY(-100vh) scale(0); opacity: 0; }
    }

    /* Tarjeta principal */
    .detail-card {
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

    .detail-card-header {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
    }

    .detail-card-header::after {
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

    .backup-name-badge {
        margin: 5px 0 0;
        background: rgba(255,255,255,0.2);
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 0.9rem;
        display: inline-block;
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

    .detail-card-body {
        padding: 35px;
    }

    .detail-card-footer {
        background: #f8f9fa;
        padding: 25px 30px;
        border-top: 2px solid #E8D5C0;
    }

    /* Botones de acción superiores */
    .action-buttons-top {
        display: flex;
        gap: 15px;
        justify-content: space-between;
        align-items: center;
    }

    .btn-back {
        background: linear-gradient(145deg, #6c757d, #5a6268);
        color: white;
        padding: 12px 25px;
        border-radius: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-back:hover {
        transform: translateX(-5px);
        box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
        color: white;
    }

    .btn-download {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 12px 30px;
        border-radius: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .btn-download:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.4);
        color: white;
    }

    /* Cards de información */
    .info-card-modern {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid #E8D5C0;
    }

    .info-card-header {
        padding: 18px 20px;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .gradient-primary {
        background: linear-gradient(135deg, #8B4513, #A0522D);
    }

    .info-card-header i {
        font-size: 1.3rem;
    }

    .info-card-header h5 {
        flex: 1;
    }

    .header-badge {
        background: rgba(255,255,255,0.2);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .info-card-body {
        padding: 20px;
    }

    /* Tabla de información */
    .info-table {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-row {
        display: flex;
        align-items: center;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .info-row:hover {
        background: #f5e6d3;
        transform: translateX(5px);
    }

    .info-label {
        width: 150px;
        color: #5D4037;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        color: #8B4513;
    }

    .info-value {
        flex: 1;
        color: #333;
    }

    .highlight {
        color: #8B4513;
        font-weight: 600;
    }

    .code-block {
        background: #2d2d2d;
        color: #f8f9fa;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .badge-database {
        background: #17a2b8;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .badge-format {
        background: #28a745;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        text-transform: uppercase;
    }

    .file-size {
        font-weight: 600;
        color: #28a745;
    }

    /* Información de usuario */
    .user-info-box {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 10px;
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #8B4513, #A0522D);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        box-shadow: 0 10px 20px rgba(139, 69, 19, 0.3);
    }

    .user-details {
        flex: 1;
    }

    .user-name {
        color: #5D4037;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .user-email, .user-id {
        color: #6c757d;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-email i, .user-id i {
        color: #8B4513;
    }

    /* Tabla de colecciones */
    .collections-table {
        width: 100%;
        border-collapse: collapse;
    }

    .collections-table th {
        background: #f8f9fa;
        color: #5D4037;
        font-weight: 600;
        padding: 15px;
        text-align: left;
    }

    .collections-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #E8D5C0;
    }

    .collections-table tr:hover td {
        background: #f5e6d3;
    }

    .collection-code {
        background: #f8f9fa;
        padding: 4px 10px;
        border-radius: 8px;
        color: #8B4513;
        font-weight: 500;
    }

    .document-count {
        font-weight: 600;
        color: #17a2b8;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-badge.success {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.warning {
        background: #fff3cd;
        color: #856404;
    }

    .total-badge {
        background: #8B4513;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
    }

    .total-collections {
        background: #17a2b8;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* Grid del sistema */
    .system-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .system-card {
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .system-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .system-icon {
        width: 50px;
        height: 50px;
        background: #8B4513;
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .system-info {
        flex: 1;
    }

    .system-label {
        display: block;
        color: #6c757d;
        font-size: 0.85rem;
        margin-bottom: 3px;
    }

    .system-value {
        display: block;
        color: #5D4037;
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Footer actions */
    .footer-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .btn-restore-footer {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #333;
        padding: 15px 30px;
        border-radius: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        flex: 1;
        justify-content: center;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .btn-restore-footer:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(255, 193, 7, 0.4);
        color: #333;
    }

    .btn-delete-footer {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 15px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-delete-footer:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(220, 53, 69, 0.4);
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

    .btn-restore-footer:hover .btn-overlay {
        width: 300px;
        height: 300px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-card-body {
            padding: 25px 20px;
        }
        
        .coffee-cup {
            display: none;
        }
        
        .action-buttons-top {
            flex-direction: column;
        }
        
        .btn-back, .btn-download {
            width: 100%;
            justify-content: center;
        }
        
        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .info-label {
            width: 100%;
        }
        
        .user-info-box {
            flex-direction: column;
            text-align: center;
        }
        
        .system-grid {
            grid-template-columns: 1fr;
        }
        
        .footer-actions {
            flex-direction: column;
        }
        
        .btn-restore-footer, .btn-delete-footer {
            width: 100%;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@push('styles')
<style>
.avatar-circle {
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
}
/* Mantenemos el estilo original del push */
</style>
@endpush