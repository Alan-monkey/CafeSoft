<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libros;
use App\Models\Venta;

class LibrosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:usuarios');
    }
    
    public function inicio()
    {
       $user = auth()->guard('usuarios')->user();

        // Ventas del día
        $ventasHoy = Venta::whereDate('created_at', today())->get();
        $totalHoy = $ventasHoy->sum('total');
        $numVentasHoy = $ventasHoy->count();

        // Productos más vendidos (top 5)
        $productosVendidos = [];
        foreach ($ventasHoy as $venta) {
            foreach ($venta->productos as $producto) {
                $nombre = $producto['nombre'];
                if (!isset($productosVendidos[$nombre])) {
                    $productosVendidos[$nombre] = 0;
                }
                $productosVendidos[$nombre] += $producto['cantidad'];
            }
        }
        arsort($productosVendidos);
        $masVendidos = array_slice($productosVendidos, 0, 5, true);

        // Ticket promedio
        $promedioHoy = $numVentasHoy > 0 ? $totalHoy / $numVentasHoy : 0;

        return view('libros.inicio', compact(
            'user',
            'totalHoy',
            'numVentasHoy',
            'masVendidos',
            'promedioHoy'
        ));
    }
    
    public function inicioInv()
    {
        $user = auth()->guard('usuarios')->user();
        return view('libros.inicioInv', compact('user'));
    }
    
    // Aquí van tus otros métodos...
}