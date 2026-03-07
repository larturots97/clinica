<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clinica_id',
        'nombre',
        'codigo',
        'descripcion',
        'categoria',
        'unidad',
        'precio_compra',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'activo',
    ];

    protected $casts = [
        'precio_compra' => 'decimal:2',
        'precio_venta'  => 'decimal:2',
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class)->orderBy('created_at', 'desc');
    }

    public function getBajoStockAttribute()
    {
        return $this->stock_actual <= $this->stock_minimo;
    }
}