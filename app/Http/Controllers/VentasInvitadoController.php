<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VentaInvitado;
use App\Models\Producto;

class VentasInvitadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:usuarios');
    }

    /**
     * Ver historial de compras del invitado
     */
    public function index()
    {
        $user = auth()->guard('usuarios')->user();
        
        // Mostrar solo las ventas del usuario actual
        $ventas = VentaInvitado::where('usuario_id', $user->_id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('invitado.ventas.index', compact('ventas', 'user'));
    }

    /**
     * Ver detalle de una compra
     */
    public function show($id)
    {
        $user = auth()->guard('usuarios')->user();
        $venta = VentaInvitado::find($id);
        
        if (!$venta || $venta->usuario_id != $user->_id) {
            return redirect()->route('invitado.ventas.index')->with('error', 'Venta no encontrada');
        }
        
        return view('invitado.ventas.show', compact('venta', 'user'));
    }

    /**
     * Ver ticket de una compra
     */
    public function ticket($id)
    {
        $user = auth()->guard('usuarios')->user();
        $venta = VentaInvitado::find($id);
        
        if (!$venta || $venta->usuario_id != $user->_id) {
            return redirect()->route('invitado.inicio')->with('error', 'Venta no encontrada');
        }
        
        return view('invitado.ventas.ticket', compact('venta', 'user'));
    }
}