<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\Venta;
use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\DB;

/**
 * Controlador unificado de carrito para empleados e invitados
 * 
 * Este controlador maneja todas las operaciones del carrito de compras
 * para ambos tipos de usuarios (empleado: tipo 0, invitado: tipo 1).
 * 
 * La diferencia principal es que detecta el tipo de usuario y:
 * - Empleados: ven la vista 'carrito.ver' (con opción de mesa)
 * - Invitados: ven la vista 'carrito.verInv' (sin opción de mesa)
 */
class CarritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:usuarios');
    }

    /**
     * Agregar producto al carrito
     */
    public function agregar(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado');
        }

        // Verificar inventario
        try {
            $inventario = Inventario::where('producto_id', $id)->first();

            // Si no encuentra con string, intentar con ObjectId
            if (!$inventario) {
                try {
                    $objectId = new ObjectId($id);
                    $inventario = Inventario::where('producto_id', $objectId)->first();
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al verificar inventario');
                }
            }

            if (!$inventario) {
                return back()->with('error', 'Este producto no tiene inventario registrado');
            }

            if ($inventario->stock_actual <= 0) {
                return back()->with('error', 'Producto agotado');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error al verificar disponibilidad');
        }

        $carrito = session()->get('carrito', []);
        $cantidad_solicitada = 1;

        if (isset($carrito[$id])) {
            $cantidad_solicitada = $carrito[$id]['cantidad'] + 1;
        }

        // Verificar stock disponible
        if ($inventario->stock_actual < $cantidad_solicitada) {
            return back()->with('error', 'Stock insuficiente. Disponible: ' . $inventario->stock_actual);
        }

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = $cantidad_solicitada;
            $carrito[$id]['stock_disponible'] = $inventario->stock_actual;
        } else {
            $carrito[$id] = [
                'id' => $id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'imagen' => $producto->imagen,
                'cantidad' => 1,
                'stock_disponible' => $inventario->stock_actual
            ];
        }

        session()->put('carrito', $carrito);

        return back()->with('success', 'Producto agregado al carrito');
    }

    /**
     * Ver carrito (detecta tipo de usuario y redirige a la vista correspondiente)
     */
    public function ver()
    {
        $carrito = session()->get('carrito', []);
        $productos = Producto::all();
        $user = auth()->guard('usuarios')->user();

        // Detectar tipo de usuario y redirigir a la vista correspondiente
        if ($user->user_tipo == 0) {
            // Empleado - vista con mesa
            return view('carrito.ver', compact('carrito', 'productos', 'user'));
        } else {
            // Invitado - vista sin mesa
            return view('carrito.verInv', compact('carrito', 'productos', 'user'));
        }
    }

    /**
     * Actualizar cantidad de un producto en el carrito
     */
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $carrito = session()->get('carrito', []);

        if (!isset($carrito[$id])) {
            return back()->with('error', 'Producto no encontrado en el carrito');
        }

        // Verificar stock
        try {
            $inventario = Inventario::where('producto_id', $id)->first();

            if (!$inventario) {
                try {
                    $objectId = new ObjectId($id);
                    $inventario = Inventario::where('producto_id', $objectId)->first();
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al verificar inventario');
                }
            }

            if (!$inventario) {
                return back()->with('error', 'No se pudo verificar el stock');
            }

            if ($inventario->stock_actual < $request->cantidad) {
                return back()->with('error', 'Stock insuficiente. Disponible: ' . $inventario->stock_actual);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error al verificar disponibilidad');
        }

        $carrito[$id]['cantidad'] = $request->cantidad;
        $carrito[$id]['stock_disponible'] = $inventario->stock_actual;
        session()->put('carrito', $carrito);

        return back()->with('success', 'Cantidad actualizada');
    }

    /**
     * Eliminar producto del carrito
     */
    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
            return back()->with('success', 'Producto eliminado del carrito');
        }

        return back()->with('error', 'Producto no encontrado en el carrito');
    }

    /**
     * Mostrar página de pago (detecta tipo de usuario)
     */
    public function mostrarPago()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.ver')->with('error', 'El carrito está vacío');
        }

        $total = $this->calcularTotal($carrito);
        $user = auth()->guard('usuarios')->user();

        return view('carrito.pago', compact('total', 'carrito', 'user'));
    }

    /**
     * Procesar el pago
     */
    public function procesarPago(Request $request)
{
    // Validar
    $request->validate([
        'efectivo_recibido' => 'nullable|numeric|min:0',
        'mesa' => 'required|integer|min:1|max:10',
        'puntos_a_usar' => 'nullable|numeric|min:0'
    ]);

    $carrito = session()->get('carrito', []);
    
    if (empty($carrito)) {
        return redirect()->back()->with('error', 'El carrito está vacío');
    }

    //Calcular total inicial
    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    $usuario = auth()->guard('usuarios')->user();
    $puntosAUsar = 0;
    $descuento = 0;

    if ($usuario && $usuario->user_tipo == 1) {
        $puntosAUsar = floatval($request->input('puntos_a_usar', 0));
        
        //Validar que tenga puntos suficientes
        if ($puntosAUsar > ($usuario->puntos ?? 0)){
            return redirect()->back()->with('error', 'No tienes suficientes puntos');
        }

        //Validar que no use mas puntos del total
        if ($puntosAUsar > $total) {
            return redirect()->back()->with('error', 'No se puede usar mas puntos del total de la compra');
        }

        //Calcular descuento 
        $descuento = $puntosAUsar;
    } elseif ($request->input('puntos_a_usar', 0) > 0) {
        return redirect()->back()->with('error', 'Solo los clientes pueden usar puntos');
    }

    //Calcular el total con descuento
    $totalFinal = $total - $descuento;

    $efectivoRecibido = floatval($request->efectivo_recibido ?? 0);
    $mesa = intval($request->mesa);

    // Validar efectivo: si el total final es 0 (pagado completamente con puntos), no se requiere efectivo
    if ($totalFinal > 0 && $efectivoRecibido < $totalFinal) {
        return redirect()->back()->with('error', 'El efectivo recibido es insuficiente. Faltan $' . number_format($totalFinal - $efectivoRecibido, 2));
    }

    $cambio = $efectivoRecibido - $totalFinal;

    // PASO 1: Verificar que podemos encontrar los inventarios
    foreach ($carrito as $item) {
        $inventario = Inventario::where('producto_id', $item['id'])->first();
        
        if (!$inventario) {
            try {
                $objectId = new ObjectId($item['id']);
                $inventario = Inventario::where('producto_id', $objectId)->first();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', "Error al verificar stock para {$item['nombre']}: " . $e->getMessage());
            }
        }
        
        if (!$inventario) {
            return redirect()->back()->with('error', "No hay inventario registrado para {$item['nombre']}");
        }
        
        if ($inventario->stock_actual < $item['cantidad']) {
            return redirect()->back()->with('error', "Stock insuficiente para {$item['nombre']}. Disponible: {$inventario->stock_actual}");
        }
    }

    // PASO 2: Intentar guardar sin transacción primero
    try {
        // Crear la venta
        $venta = new Venta();
        $venta->folio = Venta::generarFolio();
        $venta->productos = array_map(function($item) {
            return [
                'producto_id' => $item['id'],
                'nombre' => $item['nombre'],
                'precio' => $item['precio'],
                'cantidad' => $item['cantidad'],
                'subtotal' => $item['precio'] * $item['cantidad']
            ];
        }, $carrito);
        $venta->total = $totalFinal;
        $venta->subtotal = $total;
        $venta->descuento_puntos = $descuento;
        $venta->puntos_usados = $puntosAUsar;
        $venta->efectivo_recibido = $efectivoRecibido;
        $venta->cambio = $cambio;
        $venta->mesa = $mesa;
        $venta->fecha_venta = now();
        $venta->estado = 'completada';
        $venta->usuario_id = auth()->guard('usuarios')->id();
        
        // Guardar y verificar
        $guardado = $venta->save();
        
        if (!$guardado) {
            return redirect()->back()->with('error', 'No se pudo guardar la venta');
        }
        
        // PASO 3: Verificar que se guardó correctamente
        $ventaGuardada = Venta::find($venta->_id);
        if (!$ventaGuardada) {
            return redirect()->back()->with('error', 'La venta no se encontró después de guardar');
        }

        //Solo para clientes
        $usuario = auth()->guard('usuarios')->user();

        if ($usuario && $usuario->user_tipo == 1){

            $usuario->puntos -= $puntosAUsar;
            //Calcular los puntos
            $puntosGanados = floor($totalFinal / 60) * 15;
            $usuario->puntos += $puntosGanados;

            $usuario->save();

            //Actualizar puntos
            $venta->puntos_ganados = $puntosGanados;
            $venta->save();
        }

        // PASO 4: Actualizar inventario
        foreach ($carrito as $item) {
            $inventario = Inventario::where('producto_id', $item['id'])->first();
            
            if (!$inventario) {
                try {
                    $objectId = new ObjectId($item['id']);
                    $inventario = Inventario::where('producto_id', $objectId)->first();
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            if ($inventario) {
                $inventario->stock_actual -= $item['cantidad'];
                $inventario->fecha_actualizacion = now();
                $inventario->save();
            }
        }

        // Guardar datos en sesión
        session()->put('pago_total', $totalFinal);
        session()->put('pago_efectivo', $efectivoRecibido);
        session()->put('pago_cambio', $cambio);
        session()->put('pago_fecha', now());
        session()->put('pago_carrito', $carrito);
        session()->put('pago_mesa', $mesa);
        session()->put('pago_folio', $venta->folio);
        
        // Limpiar carrito
        session()->forget('carrito');

        // PASO 5: Redirigir al ticket
        return redirect()->route('ventas.ticket', $venta->_id)
            ->with('success', 'Pago procesado correctamente. Mesa ' . $mesa . ' asignada.');

    } catch (\Exception $e) {
        // Mostrar el error específico
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage() . ' en línea ' . $e->getLine());
    }
}

    /**
     * Mostrar ticket de venta
     */
    public function ticket($id)
    {
        $user = auth()->guard('usuarios')->user();
        $venta = Venta::find($id);
        
        if (!$venta) {
            return redirect()->route('inicio')->with('error', 'Venta no encontrada');
        }
        
        return view('carrito.ticket', compact('venta', 'user'));
    }

    /**
     * Página de éxito de pago
     */
    public function pagoExito()
    {
        $user = auth()->guard('usuarios')->user();

        // Recuperar datos de la sesión
        $total = session()->get('pago_total', 0);
        $efectivo = session()->get('pago_efectivo', 0);
        $cambio = session()->get('pago_cambio', 0);
        $fecha = session()->get('pago_fecha', now());
        $carrito = session()->get('pago_carrito', []);
        $mesa = session()->get('pago_mesa', 0);
        $folio = session()->get('pago_folio', '');

        // Si no hay datos, redirigir al carrito
        if ($total == 0 || empty($carrito)) {
            return redirect()->route('carrito.ver')->with('error', 'No hay pago reciente');
        }

        return view('carrito.pago-exito', compact('total', 'efectivo', 'cambio', 'fecha', 'carrito', 'user', 'mesa', 'folio'));
    }

    /**
     * Descargar ticket en PDF
     */
    public function descargarTicket()
    {
        // Recuperar datos de la sesión
        $carrito = session()->get('pago_carrito', []);
        $total = session()->get('pago_total', 0);
        $efectivo = session()->get('pago_efectivo', 0);
        $cambio = session()->get('pago_cambio', 0);
        $fecha = session()->get('pago_fecha', now());
        $mesa = session()->get('pago_mesa', 0);
        $folio = session()->get('pago_folio', '');

        // Si no hay datos, generar datos de ejemplo (solo para pruebas)
        if (empty($carrito)) {
            $carrito = [
                'ejemplo' => [
                    'nombre' => 'Producto de Ejemplo',
                    'precio' => 100,
                    'cantidad' => 1
                ]
            ];
            $total = 100;
            $efectivo = 150;
            $cambio = 50;
            $mesa = 1;
            $folio = 'V' . date('Ymd') . '0001';
        }

        // Generar datos del pedido
        $pedido = [
            'fecha' => $fecha instanceof \DateTime ? $fecha->format('d/m/Y H:i:s') : date('d/m/Y H:i:s', strtotime($fecha)),
            'numero_pedido' => $folio ?: 'PED-' . time() . '-' . rand(1000, 9999),
            'total' => $total,
            'efectivo' => $efectivo,
            'cambio' => $cambio,
            'mesa' => $mesa
        ];

        $usuario = auth()->guard('usuarios')->user();

        // Generar PDF
        $pdf = Pdf::loadView('pdf.ticket', [
            'pedido' => $pedido,
            'carrito' => $carrito,
            'total' => $total,
            'efectivo' => $efectivo,
            'cambio' => $cambio,
            'usuario' => $usuario,
            'mesa' => $mesa
        ]);

        // Nombre del archivo
        $filename = 'ticket-' . $pedido['numero_pedido'] . '.pdf';

        // Descargar PDF
        return $pdf->download($filename);
    }

    /**
     * Calcular total del carrito
     */
    private function calcularTotal($carrito)
    {
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return $total;
    }

    /**
     * Guardar pedido (opcional - si tienes modelo Pedido)
     */
    private function guardarPedido($carrito, $total, $efectivo, $cambio, $mesa = null)
    {
        // Si tienes modelo Pedido, guárdalo aquí
        // Ejemplo con MongoDB:
        /*
        try {
            $pedido = new Pedido();
            $pedido->usuario_id = auth()->guard('usuarios')->id();
            $pedido->total = $total;
            $pedido->efectivo_recibido = $efectivo;
            $pedido->cambio = $cambio;
            $pedido->mesa = $mesa;
            $pedido->productos = $carrito;
            $pedido->fecha = now();
            $pedido->save();
            
            return [
                'id' => $pedido->_id,
                'fecha' => $pedido->fecha->format('Y-m-d H:i:s'),
                'numero_pedido' => 'PED-' . strtoupper(substr($pedido->_id, -6)),
                'total' => $total,
                'efectivo' => $efectivo,
                'cambio' => $cambio,
                'mesa' => $mesa
            ];
        } catch (\Exception $e) {
            // Si falla, retornar array simple
        }
        */

        // Por ahora, retornamos un array
        return [
            'fecha' => now()->format('Y-m-d H:i:s'),
            'numero_pedido' => 'PED-' . time() . '-' . rand(100, 999),
            'total' => $total,
            'efectivo' => $efectivo,
            'cambio' => $cambio,
            'mesa' => $mesa
        ];
    }

    /**
     * Registrar movimiento de inventario (opcional)
     */
    private function registrarMovimiento($producto_id, $tipo, $cantidad, $stock_resultante, $motivo)
    {
        // Si tienes un modelo MovimientoInventario, guárdalo aquí
        // Ejemplo:
        /*
        try {
            $movimiento = new MovimientoInventario();
            $movimiento->producto_id = $producto_id;
            $movimiento->tipo = $tipo;
            $movimiento->cantidad = $cantidad;
            $movimiento->stock_resultante = $stock_resultante;
            $movimiento->motivo = $motivo;
            $movimiento->usuario_id = auth()->guard('usuarios')->id();
            $movimiento->fecha = now();
            $movimiento->save();
            
            return $movimiento;
        } catch (\Exception $e) {
            // Silenciar error para no interrumpir la venta
            return null;
        }
        */
    }

    /**
     * Vaciar carrito completo
     */
    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->route('carrito.ver')->with('success', 'Carrito vaciado');
    }
}