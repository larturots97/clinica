<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TratamientoZona extends Model
{
    protected $table = 'tratamiento_zonas';

    protected $fillable = [
        'tratamiento_id', 'producto_id', 'zona', 'zona_label',
        'tipo', 'coord_x', 'coord_y', 'color',
        'cantidad', 'unidad', 'notas', 'activa',
    ];

    protected $casts = [
        'activa'   => 'boolean',
        'coord_x'  => 'float',
        'coord_y'  => 'float',
        'cantidad' => 'float',
    ];

    public function tratamiento()
    {
        return $this->belongsTo(TratamientoEstetico::class, 'tratamiento_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
