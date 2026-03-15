<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingServicio extends Model
{
     protected $table = 'landing_servicios';
     protected $fillable = ['medico_id','nombre','descripcion','icono','orden','activo'];
     protected $casts = ['activo' => 'boolean'];
}
