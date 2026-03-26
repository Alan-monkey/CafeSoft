# Integración API Python - Productos

## Descripción
Este proyecto Laravel consume ÚNICAMENTE la API Python (FastAPI) para todas las operaciones CRUD de productos. La API Python está conectada a MongoDB Atlas y es la única fuente de verdad.

## Arquitectura

```
Laravel (Frontend) → API Python (FastAPI) → MongoDB Atlas
```

- Laravel NO accede directamente a MongoDB
- Todas las operaciones pasan por la API Python
- La API Python maneja la lógica de negocio y persistencia

## Estructura de Archivos

```
├── api/                                # API Python (FastAPI)
│   ├── main.py                         # Endpoints REST (GET, POST, PUT, DELETE)
│   ├── config.py                       # Conexión a MongoDB Atlas
│   └── .env                            # Credenciales de MongoDB
├── config/
│   └── python_api.php                  # Configuración de la API Python
├── app/
│   └── Services/
│       └── PythonApiService.php        # Cliente HTTP para consumir la API
└── app/Http/Controllers/
    └── ProductosController.php         # Controlador modificado (solo API calls)
```

## Configuración

### 1. Variables de Entorno Laravel
Agrega estas variables a tu archivo `.env`:

```env
PYTHON_API_URL=http://localhost:9000
PYTHON_API_TIMEOUT=30
```

### 2. Variables de Entorno API Python
En `api/.env`:

```env
MONGO_URI=mongodb+srv://usuario:password@cluster.mongodb.net/?appName=UTVT
```

### 3. Endpoints de la API Python Implementados

#### GET
- `GET /productos` - Listar todos los productos
- `GET /productos/{id}` - Obtener un producto específico

#### POST
- `POST /productos` - Crear un nuevo producto
  ```json
  {
    "nombre": "string",
    "precio": float,
    "descripcion": "string",
    "imagen": "string (opcional)",
    "stock_inicial": int,
    "stock_minimo": int,
    "fecha_actualizacion": "ISO8601 string"
  }
  ```

#### PUT
- `PUT /productos/{id}` - Actualizar un producto
  ```json
  {
    "nombre": "string",
    "precio": float,
    "descripcion": "string",
    "imagen": "string (opcional)"
  }
  ```

#### DELETE
- `DELETE /productos/{id}` - Eliminar un producto (también elimina inventario asociado)

## Operaciones Implementadas

### GET - Listar Productos
- **Método**: `leer()`
- **Ruta**: `/productos/leer`
- **Acción**: Obtiene productos ÚNICAMENTE de la API Python (MongoDB Atlas)

### POST - Crear Producto
- **Método**: `store()`
- **Ruta**: `/productos/store`
- **Acción**: Envía el producto a la API Python (guarda en MongoDB Atlas + crea inventario)

### PUT - Actualizar Producto
- **Método**: `update()`
- **Ruta**: `/productos/{producto}`
- **Acción**: Actualiza ÚNICAMENTE en la API Python (MongoDB Atlas)

### DELETE - Eliminar Producto
- **Método**: `destroy()`
- **Ruta**: `/productos/destroy`
- **Acción**: Elimina ÚNICAMENTE en la API Python (MongoDB Atlas + inventario asociado)

## Base de Datos

- **Única fuente de verdad**: MongoDB Atlas (conectado a través de la API Python)
- **Laravel**: NO accede directamente a MongoDB
- **Ventajas**:
  - Centralización de la lógica de negocio en la API
  - Sin duplicación de datos
  - Consistencia garantizada
  - Escalabilidad (la API puede ser consumida por otros clientes)

## Manejo de Errores

Si la API Python no está disponible:
1. Laravel registra el error en logs
2. Muestra un mensaje al usuario: "No se pudieron cargar los productos. Verifica que la API Python esté activa."
3. NO hay fallback a MongoDB local (la API es la única fuente)

## Logs

Todos los errores se registran en:
- `storage/logs/laravel.log`

## Iniciar el Sistema

### 1. Iniciar la API Python

```bash
cd api
python -m uvicorn main:app --reload --host 0.0.0.0 --port 9000
```

O si usas el entorno virtual:

```bash
cd api
.venv/Scripts/activate  # Windows
source .venv/bin/activate  # Linux/Mac
python -m uvicorn main:app --reload --host 0.0.0.0 --port 9000
```

### 2. Iniciar Laravel

```bash
php artisan serve
```

## Verificar Integración

1. Verifica que la API Python esté corriendo:
   ```bash
   curl http://localhost:9000/health
   ```
   Respuesta esperada: `{"status": "healthy", "database": "connected"}`

2. Accede a Laravel: `http://localhost:8000/productos/leer`

3. Revisa los logs en `storage/logs/laravel.log`

## Troubleshooting

### Error: "No se pudieron cargar los productos"
- Verifica que la API Python esté corriendo en el puerto 9000
- Verifica la conexión a MongoDB Atlas en `api/config.py`
- Revisa los logs de la API Python
- Limpia la caché de Laravel: `php artisan config:clear`

### Error: "Database connection failed"
- Verifica las credenciales en `api/.env`
- Verifica que tu IP esté en la whitelist de MongoDB Atlas
- Verifica la conexión a internet
