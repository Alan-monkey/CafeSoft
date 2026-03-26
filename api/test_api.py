"""
Script de prueba para verificar que la API funciona correctamente
Ejecutar: python test_api.py
"""

import requests
import json

BASE_URL = "http://localhost:9000"

def test_health():
    """Probar endpoint de salud"""
    print("\n1. Probando /health...")
    response = requests.get(f"{BASE_URL}/health")
    print(f"   Status: {response.status_code}")
    print(f"   Response: {response.json()}")
    return response.status_code == 200

def test_get_productos():
    """Probar GET /productos"""
    print("\n2. Probando GET /productos...")
    response = requests.get(f"{BASE_URL}/productos")
    print(f"   Status: {response.status_code}")
    data = response.json()
    print(f"   Productos encontrados: {len(data.get('data', []))}")
    return response.status_code == 200

def test_create_producto():
    """Probar POST /productos"""
    print("\n3. Probando POST /productos...")
    producto = {
        "nombre": "Producto de Prueba",
        "precio": 99.99,
        "descripcion": "Este es un producto de prueba",
        "stock_inicial": 10,
        "stock_minimo": 5
    }
    response = requests.post(f"{BASE_URL}/productos", json=producto)
    print(f"   Status: {response.status_code}")
    if response.status_code == 200:
        data = response.json()
        print(f"   Producto creado: {data.get('data', {}).get('_id')}")
        return data.get('data', {}).get('_id')
    return None

def test_update_producto(producto_id):
    """Probar PUT /productos/{id}"""
    print(f"\n4. Probando PUT /productos/{producto_id}...")
    update_data = {
        "nombre": "Producto Actualizado",
        "precio": 149.99,
        "descripcion": "Descripción actualizada"
    }
    response = requests.put(f"{BASE_URL}/productos/{producto_id}", json=update_data)
    print(f"   Status: {response.status_code}")
    print(f"   Response: {response.json()}")
    return response.status_code == 200

def test_delete_producto(producto_id):
    """Probar DELETE /productos/{id}"""
    print(f"\n5. Probando DELETE /productos/{producto_id}...")
    response = requests.delete(f"{BASE_URL}/productos/{producto_id}")
    print(f"   Status: {response.status_code}")
    print(f"   Response: {response.json()}")
    return response.status_code == 200

if __name__ == "__main__":
    print("=" * 50)
    print("PRUEBA DE API PYTHON - PRODUCTOS")
    print("=" * 50)
    
    try:
        # 1. Health check
        if not test_health():
            print("\n❌ Error: La API no está disponible")
            exit(1)
        
        # 2. Listar productos
        test_get_productos()
        
        # 3. Crear producto
        producto_id = test_create_producto()
        
        if producto_id:
            # 4. Actualizar producto
            test_update_producto(producto_id)
            
            # 5. Eliminar producto
            test_delete_producto(producto_id)
        
        print("\n" + "=" * 50)
        print("✅ TODAS LAS PRUEBAS COMPLETADAS")
        print("=" * 50)
        
    except requests.exceptions.ConnectionError:
        print("\n❌ Error: No se puede conectar a la API")
        print("   Asegúrate de que la API esté corriendo en http://localhost:9000")
    except Exception as e:
        print(f"\n❌ Error inesperado: {e}")
