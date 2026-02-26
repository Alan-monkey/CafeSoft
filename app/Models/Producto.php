<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Producto extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tb_productos';

    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'imagen'
    ];

    public $timestamps = false;

    // Relación con Inventario
    public function inventario()
    {
        return $this->hasOne(Inventario::class, 'producto_id', '_id');
    }

    // Helper para obtener stock actual
    public function getStockActualAttribute()
    {
        return $this->inventario ? $this->inventario->stock_actual : 0;
    }

    // Verificar si hay stock suficiente
    public function tieneStock($cantidad)
    {
        return $this->stock_actual >= $cantidad;
    }
}