<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Inventario; // <-- IMPORTANTE: Agregar esta línea
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:usuarios');
    }

    public function crear()
    {
        $user = auth()->guard('usuarios')->user();
        return view('productos.crear', compact('user'));
    }

    // MODIFICAR el método store para guardar inventario también
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
            'stock_inicial' => 'required|integer|min:0', // NUEVO CAMPO
            'stock_minimo' => 'required|integer|min:0',  // NUEVO CAMPO
        ]);

        // Crear producto
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            $path = $request->imagen->store('productos', 'public');
            $producto->imagen = $path;
        }

        $producto->save();

        // Crear inventario asociado (USANDO TU ESTRUCTURA)
        $inventario = new Inventario();
        $inventario->producto_id = $producto->_id; // MongoDB usa _id
        $inventario->stock_actual = (int)$request->stock_inicial;
        $inventario->stock_minimo = (int)$request->stock_minimo;
        $inventario->fecha_actualizacion = now();
        $inventario->save();

        return redirect()->back()->with('success', 'Producto creado con éxito');
    }

    // MODIFICAR el método leer para cargar inventario
    public function leer()
    {
        $productos = Producto::all();
        $user = auth()->guard('usuarios')->user();
        
        // Cargar inventario para cada producto
        foreach ($productos as $producto) {
            $producto->inventario = Inventario::where('producto_id', $producto->_id)->first();
        }
        
        return view('productos.leer', compact('productos', 'user'));
    }

    // MODIFICAR el método eliminar para cargar inventario
    public function eliminar()
    {
        $productos = Producto::all();
        $user = auth()->guard('usuarios')->user();
        
        foreach ($productos as $producto) {
            $producto->inventario = Inventario::where('producto_id', $producto->_id)->first();
        }
        
        return view('productos.eliminar', compact('productos', 'user'));
    }

    // NUEVO MÉTODO: Ver inventario
    public function inventario()
    {
        $productos = Producto::all();
        $user = auth()->guard('usuarios')->user();
        
        $productos_con_inventario = [];
        $total_stock = 0;
        $productos_bajo_stock = 0;
        
        foreach ($productos as $producto) {
            $inventario = Inventario::where('producto_id', $producto->_id)->first();
            
            if ($inventario) {
                $producto->inventario = $inventario;
                $total_stock += $inventario->stock_actual;
                
                if ($inventario->bajo_stock) {
                    $productos_bajo_stock++;
                }
                
                $productos_con_inventario[] = $producto;
            }
        }
        
        return view('inventario.index', compact('productos_con_inventario', 'user', 'total_stock', 'productos_bajo_stock'));
    }

    // NUEVO MÉTODO: Actualizar stock
    public function actualizarStock(Request $request)
    {
        $request->validate([
            'producto_id' => 'required',
            'nuevo_stock' => 'required|integer|min:0',
            'motivo' => 'required|string'
        ]);

        $inventario = Inventario::where('producto_id', $request->producto_id)->first();
        
        if (!$inventario) {
            return back()->with('error', 'Inventario no encontrado');
        }

        $stock_anterior = $inventario->stock_actual;
        $inventario->stock_actual = (int)$request->nuevo_stock;
        $inventario->fecha_actualizacion = now();
        $inventario->save();

        // Aquí podrías guardar un historial de movimientos si quieres

        return back()->with('success', 'Stock actualizado correctamente');
    }

    // MODIFICAR el método destroy para eliminar también inventario
    public function destroy(Request $request)
    {
        $id = $request->input('IdProducto');
        $producto = Producto::find($id);

        if ($producto) {
            // Eliminar inventario asociado primero
            Inventario::where('producto_id', $producto->_id)->delete();
            
            // Eliminar producto
            $producto->delete();
            
            return redirect()->back()->with('success', 'Producto eliminado con éxito');
        } else {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }
    }

    // Los demás métodos (update) se quedan igual
    public function update(Request $request, Producto $producto)
    {
        // ... (código existente)
    }
}