@extends('layouts.app')

@section('content')
<div class="backups-container">
    <!-- Elementos decorativos de café - TAZAS BLANCAS EN BORDES (NO TAPAN) -->
    <div class="coffee-elements">
        <!-- Taza superior izquierda -->
        <div class="coffee-cup cup-1">
            <div class="cup-top white-cup"></div>
            <div class="cup-body white-cup"></div>
            <div class="cup-handle white-handle"></div>
            <div class="steam s1"></div>
            <div class="steam s2"></div>
            <div class="steam s3"></div>
        </div>
        
        <!-- Taza inferior derecha -->
        <div class="coffee-cup cup-2">
            <div class="cup-top white-cup"></div>
            <div class="cup-body white-cup"></div>
            <div class="cup-handle white-handle"></div>
            <div class="steam s1"></div>
            <div class="steam s2"></div>
            <div class="steam s3"></div>
        </div>
        
        <!-- Taza lateral derecha -->
        <div class="coffee-cup cup-3">
            <div class="cup-top white-cup"></div>
            <div class="cup-body white-cup"></div>
            <div class="cup-handle white-handle"></div>
            <div class="steam s1"></div>
            <div class="steam s2"></div>
            <div class="steam s3"></div>
        </div>

        <!-- Granos de café decorativos -->
        <div class="coffee-bean bean-1"></div>
        <div class="coffee-bean bean-2"></div>
        <div class="coffee-bean bean-3"></div>
        <div class="coffee-bean bean-4"></div>
        <div class="coffee-bean bean-5"></div>
        
        <!-- Partículas flotantes -->
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <!-- Tarjeta principal con glassmorphism -->
                <div class="backups-card">
                    <div class="backups-card-header">
                        <div class="header-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="header-title">
                            <h4><i class="fas fa-database"></i> Gestión de Backups</h4>
                            <p>Protege y restaura tus datos de forma segura</p>
                        </div>
                        <div class="coffee-decoration">
                            <span>☕</span>
                            <span>💾</span>
                            <span>☕</span>
                        </div>
                    </div>

                    <div class="backups-card-body">
                        <!-- Botones de acción - MISMA ESTRUCTURA -->
                        <div class="action-buttons-top mb-4">
                            <button type="button" class="btn-new-backup" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                <i class="fas fa-plus"></i> Nuevo Backup
                            </button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#restorePasswordModal" class="btn-restore-backup">
                                <i class="fas fa-upload"></i> Restaurar Backup
                            </button>
                        </div>

                        <!-- Alertas - MISMA ESTRUCTURA -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                                @if (session('info'))
                                    <div class="mt-1">{{ session('info') }}</div>
                                @endif
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Información usuario - MISMA ESTRUCTURA con diseño mejorado -->
                        <div class="user-info-card mb-4">
                            <i class="fas fa-user-circle user-info-icon"></i>
                            <div class="user-info-content">
                                <span class="user-info-label">Usuario actual:</span>
                                <span class="user-info-name">{{ Auth::guard('usuarios')->user()->nombre }}</span>
                                <span class="user-info-email">({{ Auth::guard('usuarios')->user()->email }})</span>
                            </div>
                        </div>

                        <!-- Tabla - MISMA ESTRUCTURA con diseño mejorado -->
                        <div class="table-responsive">
                            <table class="table table-hover modern-table">
                                <thead>
                                    <tr>
                                        <th>Nombre del Backup</th>
                                        <th>Tamaño</th>
                                        <th>Fecha</th>
                                        <th>Creado por</th>
                                        <th>Base de datos</th>
                                        <th>Colecciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($backups as $backup)
                                    <tr>
                                        <td>
                                            <div class="backup-name-cell">
                                                <i class="fas fa-file-archive file-icon"></i>
                                                <div class="backup-info">
                                                    <strong>{{ $backup['name'] }}</strong>
                                                    <span class="format-badge">{{ $backup['format'] }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="size-badge">{{ formatBytes($backup['size']) }}</span></td>
                                        <td>
                                            <div class="date-info">
                                                <span class="full-date">{{ $backup['date'] }}</span>
                                                <span class="relative-date">{{ \Carbon\Carbon::parse($backup['date'])->diffForHumans() }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($backup['created_by'] != 'Desconocido')
                                                <div class="user-cell">
                                                    <div class="user-avatar">
                                                        {{ strtoupper(substr($backup['created_by'], 0, 1)) }}
                                                    </div>
                                                    <div class="user-details">
                                                        <strong>{{ $backup['created_by'] }}</strong>
                                                        @if($backup['created_by_id'])
                                                            <small>ID: {{ $backup['created_by_id'] }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Desconocido</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="db-badge">
                                                <i class="fas fa-database"></i> {{ $backup['database'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="collections-badge">
                                                <i class="fas fa-layer-group"></i> {{ $backup['collections_count'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button type="button" class="btn-action btn-download" 
                                                        onclick="showDownloadModal('{{ $backup['name'] }}')"
                                                        title="Descargar">
                                                    <i class="fas fa-download"></i>
                                                </button>

                                                <button type="button" data-bs-toggle="modal" data-bs-target="#restorePasswordModal" 
                                                        class="btn-action btn-restore" title="Restaurar">
                                                    <i class="fas fa-upload"></i>
                                                </button>

                                                <button type="button" class="btn-action btn-delete" 
                                                        onclick="showDeleteModal('{{ $backup['name'] }}')"
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-database fa-3x mb-3"></i>
                                                <h5>No hay backups disponibles</h5>
                                                <p class="text-muted">Crea tu primer backup haciendo clic en el botón "Nuevo Backup"</p>
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
        </div>
    </div>
</div>

<!-- MODALES - MISMA ESTRUCTURA (sin cambios) -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="passwordModalLabel">
                    <i class="fas fa-lock"></i> Verificar identidad
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <form action="{{ route('backups.verify-password') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Para acceder a la creación de backups, por favor confirma tu identidad:</p>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <strong>Contraseña</strong>
                        </label>
                        <input type="password" 
                               class="form-control @if(session('password_error')) is-invalid @endif" 
                               id="password" 
                               name="password" 
                               required 
                               autocomplete="off"
                               placeholder="Ingresa tu contraseña">
                        
                        @if(session('password_error'))
                            <div class="invalid-feedback">
                                {{ session('password_error') }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <small>Esta verificación adicional protege contra accesos no autorizados.</small>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Verificar y continuar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para recuperacion de contraseñas para restauracion de backup -->
<div class="modal fade" id="restorePasswordModal" tabindex="-1" aria-labelledby="restorePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="restorePasswordModalLabel">
                    <i class="fas fa-lock"></i> Verificar identidad
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <form action="{{ route('backups.verify-password-restore') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Para acceder a la restauración de backups, por favor confirma tu identidad:</p>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <strong>Contraseña</strong>
                        </label>
                        <input type="password" 
                               class="form-control @if(session('restore_password_error')) is-invalid @endif" 
                               id="password" 
                               name="password" 
                               required 
                               autocomplete="off"
                               placeholder="Ingresa tu contraseña">
                        
                        @if(session('restore_password_error'))
                            <div class="invalid-feedback">
                                {{ session('restore_password_error') }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <small>Esta verificación adicional protege contra accesos no autorizados.</small>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Verificar y continuar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para DESCARGAR BACKUP -->
<div class="modal fade" id="downloadPasswordModal" tabindex="-1" aria-labelledby="downloadPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="downloadPasswordModalLabel">
                    <i class="fas fa-lock"></i> Verificar identidad para descargar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <form action="{{ route('backups.verify-password-download') }}" method="POST" id="downloadVerifyForm">
                @csrf
                <input type="hidden" name="backup_filename" id="download_filename" value="">
                
                <div class="modal-body">
                    <p>Para descargar este backup, por favor confirma tu identidad:</p>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-download"></i>
                        <strong>Backup:</strong> <span id="download_backup_name"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="download_password" class="form-label">
                            <strong>Contraseña</strong>
                        </label>
                        <input type="password" 
                               class="form-control @if(session('download_password_error')) is-invalid @endif" 
                               id="download_password" 
                               name="password" 
                               required 
                               autocomplete="off"
                               placeholder="Ingresa tu contraseña">
                        
                        @if(session('download_password_error'))
                            <div class="invalid-feedback">
                                {{ session('download_password_error') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-check"></i> Verificar y descargar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para ELIMINAR BACKUP -->
<div class="modal fade" id="deletePasswordModal" tabindex="-1" aria-labelledby="deletePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deletePasswordModalLabel">
                    <i class="fas fa-lock"></i> Verificar identidad para eliminar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <form action="{{ route('backups.verify-password-delete') }}" method="POST" id="deleteVerifyForm">
                @csrf
                <input type="hidden" name="backup_filename" id="delete_filename" value="">
                
                <div class="modal-body">
                    <p>Para eliminar este backup, por favor confirma tu identidad:</p>
                    
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>¡Advertencia!</strong> Esta acción no se puede deshacer.
                        <br>
                        <strong>Backup:</strong> <span id="delete_backup_name"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">
                            <strong>Contraseña</strong>
                        </label>
                        <input type="password" 
                               class="form-control @if(session('delete_password_error')) is-invalid @endif" 
                               id="delete_password" 
                               name="password" 
                               required 
                               autocomplete="off"
                               placeholder="Ingresa tu contraseña">
                        
                        @if(session('delete_password_error'))
                            <div class="invalid-feedback">
                                {{ session('delete_password_error') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-check"></i> Verificar y eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPTS - IGUALES -->
<script>
function showDownloadModal(filename) {
    document.getElementById('download_filename').value = filename;
    document.getElementById('download_backup_name').textContent = filename;
    
    var modal = new bootstrap.Modal(document.getElementById('downloadPasswordModal'));
    modal.show();
}

function showDeleteModal(filename) {
    document.getElementById('delete_filename').value = filename;
    document.getElementById('delete_backup_name').textContent = filename;
    
    var modal = new bootstrap.Modal(document.getElementById('deletePasswordModal'));
    modal.show();
}
</script>

<!-- Script para abrir el modal automáticamente si hay error de contraseña -->
@if(session('password_error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        modal.show();
    });
</script>
@endif

@if(session('restore_password_error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('restorePasswordModal'));
        modal.show();
    });
</script>
@endif

@if(session('download_password_error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('downloadPasswordModal'));
        modal.show();
    });
</script>
@endif

@if(session('delete_password_error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('deletePasswordModal'));
        modal.show();
    });
</script>
@endif

<style>
    /* ===== ESTILOS GENERALES ===== */
    .backups-container {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(145deg, #faf0e6 0%, #f5e6d3 100%);
        font-family: 'Segoe UI', system-ui, sans-serif;
        padding: 20px 0;
        overflow-x: hidden;
    }

    /* ===== ELEMENTOS DECORATIVOS - TAZAS EN BORDES (NO TAPAN) ===== */
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

    /* Tazas en las esquinas - lejos del contenido */
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
    .backups-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
        position: relative;
        z-index: 10;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .backups-card-header {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
    }

    .backups-card-header::after {
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

    .backups-card-body {
        padding: 30px;
    }

    /* ===== BOTONES DE ACCIÓN ===== */
    .action-buttons-top {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-new-backup, .btn-restore-backup {
        padding: 14px 28px;
        border: none;
        border-radius: 15px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .btn-new-backup {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        color: white;
    }

    .btn-restore-backup {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
    }

    .btn-new-backup:hover, .btn-restore-backup:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }

    /* ===== CARD DE USUARIO ===== */
    .user-info-card {
        background: linear-gradient(145deg, #f8f4f0, #f0e8e0);
        border-radius: 20px;
        padding: 1.2rem 1.8rem;
        display: flex;
        align-items: center;
        gap: 15px;
        border-left: 6px solid #8B4513;
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.1);
    }

    .user-info-icon {
        font-size: 2.5rem;
        color: #8B4513;
    }

    .user-info-content {
        font-size: 1.1rem;
    }

    .user-info-label {
        font-weight: 500;
        color: #666;
        margin-right: 5px;
    }

    .user-info-name {
        font-weight: 700;
        color: #8B4513;
        margin-right: 8px;
    }

    .user-info-email {
        color: #666;
        font-size: 0.95rem;
    }

    /* ===== TABLA MODERNA ===== */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .modern-table thead th {
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

    .modern-table tbody tr {
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }

    .modern-table tbody tr:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(139, 69, 19, 0.15);
        background: white;
    }

    .modern-table tbody td {
        padding: 18px 16px;
        border: none;
        vertical-align: middle;
    }

    /* Celda de nombre */
    .backup-name-cell {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .file-icon {
        font-size: 2rem;
        color: #8B4513;
        opacity: 0.7;
    }

    .backup-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .backup-info strong {
        color: #2c3e50;
        font-size: 1rem;
    }

    .format-badge {
        background: #e9ecef;
        color: #495057;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.75rem;
        display: inline-block;
        width: fit-content;
        font-weight: 500;
    }

    /* Badge de tamaño */
    .size-badge {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #0d47a1;
        padding: 6px 16px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-block;
        box-shadow: 0 2px 8px rgba(13, 71, 161, 0.1);
    }

    /* Información de fecha */
    .date-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .full-date {
        font-weight: 500;
        color: #2c3e50;
        font-size: 0.95rem;
    }

    .relative-date {
        font-size: 0.8rem;
        color: #7f8c8d;
        background: #f8f9fa;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-block;
        width: fit-content;
    }

    /* Celda de usuario */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #8B4513, #A0522D);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 4px 10px rgba(139, 69, 19, 0.3);
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-details strong {
        color: #2c3e50;
        font-size: 1rem;
    }

    .user-details small {
        color: #7f8c8d;
        font-size: 0.7rem;
    }

    /* Badges */
    .db-badge {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 10px rgba(23, 162, 184, 0.3);
    }

    .collections-badge {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
    }

    /* Botones de acción */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-start;
    }

    .btn-action {
        width: 42px;
        height: 42px;
        border: none;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .btn-download {
        background: linear-gradient(135deg, #17a2b8, #138496);
    }

    .btn-restore {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #333;
    }

    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
    }

    .btn-action:hover {
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        color: #95a5a6;
        padding: 20px;
    }

    .empty-state i {
        color: #8B4513;
        opacity: 0.3;
        font-size: 3.5rem;
    }

    .empty-state h5 {
        color: #5D4037;
        font-weight: 600;
        margin: 15px 0 5px;
    }

    /* Alertas */
    .alert {
        border: none;
        border-radius: 16px;
        padding: 1.2rem 1.8rem;
        margin-bottom: 1.8rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .alert-success {
        background: linear-gradient(145deg, #d4edda, #c3e6cb);
        border-left: 6px solid #28a745;
        color: #155724;
    }

    .alert-danger {
        background: linear-gradient(145deg, #f8d7da, #f5c6cb);
        border-left: 6px solid #dc3545;
        color: #721c24;
    }

    .alert-info {
        background: linear-gradient(145deg, #e8f4fd, #d1e7ff);
        border-left: 6px solid #17a2b8;
        color: #0c5460;
    }

    /* Modales */
    .modal-content {
        border: none;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.3);
    }

    .modal-header {
        padding: 1.8rem;
        border: none;
    }

    .modal-header.bg-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800) !important;
    }

    .modal-header.bg-info {
        background: linear-gradient(135deg, #17a2b8, #138496) !important;
    }

    .modal-header.bg-danger {
        background: linear-gradient(135deg, #dc3545, #c82333) !important;
    }

    .modal-title {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.3rem;
    }

    .modal-body {
        padding: 2.2rem;
    }

    .modal-footer {
        padding: 1.8rem;
        border-top: 2px solid #eee;
        gap: 12px;
    }

    .form-control {
        border: 2px solid #E8D5C0;
        border-radius: 14px;
        padding: 14px 18px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #8B4513;
        box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.15);
    }

    .btn-secondary {
        background: linear-gradient(145deg, #6c757d, #5a6268);
        border: none;
        padding: 12px 28px;
        border-radius: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
    }

    .btn-primary {
        background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
        border: none;
        padding: 12px 28px;
        border-radius: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 69, 19, 0.4);
    }

    .btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        border: none;
        padding: 12px 28px;
        border-radius: 14px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(23, 162, 184, 0.4);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        padding: 12px 28px;
        border-radius: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .coffee-cup {
            display: none;
        }
        
        .backups-card-body {
            padding: 20px;
        }
        
        .action-buttons-top {
            flex-direction: column;
        }
        
        .btn-new-backup, .btn-restore-backup {
            width: 100%;
            justify-content: center;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 5px;
        }
        
        .btn-action {
            width: 100%;
            margin: 0;
        }
        
        .user-cell {
            flex-direction: column;
            text-align: center;
        }
        
        .backup-name-cell {
            flex-direction: column;
            text-align: center;
        }
        
        .user-info-card {
            flex-direction: column;
            text-align: center;
        }
        
        .modal-footer {
            flex-direction: column;
        }
        
        .modal-footer button {
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
/* Mantenemos el estilo original del push - SIN MODIFICAR */
.avatar-circle {
    font-size: 14px;
    font-weight: bold;
}
.badge {
    font-size: 0.85em;
}
.table td {
    vertical-align: middle;
}
</style>
@endpush

@push('scripts')
<script>
function showBackupDetails(filename) {
    $('#backupDetailsContent').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2">Cargando detalles del backup...</p>
        </div>
    `);
    
    var modal = new bootstrap.Modal(document.getElementById('backupDetailsModal'));
    modal.show();
    
    $.ajax({
        url: '{{ url("backups/details") }}/' + filename,
        method: 'GET',
        success: function(response) {
            $('#backupDetailsContent').html(response);
        },
        error: function(xhr) {
            $('#backupDetailsContent').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Error al cargar los detalles del backup.
                </div>
            `);
        }
    });
}

function confirmDelete(filename, createdBy, date) {
    return confirm(`¿Eliminar el backup "${filename}"?\n\nCreado por: ${createdBy}\nFecha: ${date}\n\nEsta acción no se puede deshacer.`);
}
</script>
@endpush