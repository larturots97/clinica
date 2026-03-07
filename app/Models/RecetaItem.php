<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetaItem extends Model
{
    protected $fillable = [
        'receta_id',
        'medicamento',
        'dosis',
        'frecuencia',
        'duracion',
        'indicaciones',
        'orden',
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }
}