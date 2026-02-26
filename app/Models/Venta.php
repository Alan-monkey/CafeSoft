<?php
// app/Models/Venta.php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Venta extends Model
{
    protected $connection = 'mongodb'; // Asegúrate que esta línea exista
    protected $collection = 'ventas';

    protected $fillable = [
        'folio',
        'productos',
        'total',
        'efectivo_recibido',
        'cambio',
        'mesa',
        'fecha_venta',
        'estado',
        'usuario_id'
    ];

    protected $casts = [
        'productos' => 'array',
        'fecha_venta' => 'datetime'
    ];

    public static function generarFolio()
    {
        try {
            $ultimaVenta = self::orderBy('created_at', 'desc')->first();
            
            if ($ultimaVenta && isset($ultimaVenta->folio)) {
                $numero = intval(substr($ultimaVenta->folio, -4)) + 1;
                return 'V' . date('Ymd') . str_pad($numero, 4, '0', STR_PAD_LEFT);
            }
        } catch (\Exception $e) {
            // Si hay error, generar folio por defecto
        }
        
        return 'V' . date('Ymd') . '0001';
    }
}