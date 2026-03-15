<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingGaleria extends Model
{
      protected $table = 'landing_galeria';
      protected $fillable = ['medico_id','imagen','titulo','orden'];
}
