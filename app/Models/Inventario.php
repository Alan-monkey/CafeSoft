<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\BSON\UTCDateTime;
use DateTime;

class Inventario extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'inventario';

    protected $fillable = [
        'producto_id',
        'stock_actual',
        'stock_minimo',
        'fecha_actualizacion'
    ];

    // IMPORTANTE: Indicar que fecha_actualizacion es una fecha
    protected $dates = [
        'fecha_actualizacion',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'stock_actual' => 'integer',
        'stock_minimo' => 'integer',
    ];

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', '_id');
    }

    // Accesor para saber si está bajo stock
    public function getBajoStockAttribute()
    {
        return $this->stock_actual <= $this->stock_minimo;
    }

    // Mutator para guardar fechas correctamente en MongoDB
    public function setFechaActualizacionAttribute($value)
    {
        if ($value instanceof UTCDateTime) {
            $this->attributes['fecha_actualizacion'] = $value;
        } elseif ($value instanceof DateTime) {
            $this->attributes['fecha_actualizacion'] = new UTCDateTime($value->getTimestamp() * 1000);
        } elseif (is_string($value)) {
            $this->attributes['fecha_actualizacion'] = new UTCDateTime(strtotime($value) * 1000);
        } else {
            $this->attributes['fecha_actualizacion'] = new UTCDateTime(time() * 1000);
        }
    }

    // Accessor para leer fechas correctamente
    public function getFechaActualizacionAttribute($value)
    {
        if ($value instanceof UTCDateTime) {
            return $value->toDateTime();
        }
        return $value;
    }
}