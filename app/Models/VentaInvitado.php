<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Str;

class VentaInvitado extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'ventas_invitados';
    
    protected $fillable = [
        'folio',
        'cliente',
        'productos',
        'total',
        'metodo_pago',
        'fecha_venta',
        'estado',
        'usuario_id'
    ];

    protected $casts = [
        'cliente' => 'array',
        'productos' => 'array',
        'fecha_venta' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($venta) {
            if (empty($venta->folio)) {
                $venta->folio = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }
        });
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id', '_id');
    }
}