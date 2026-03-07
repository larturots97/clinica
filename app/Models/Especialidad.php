<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidad extends Model
{
    use SoftDeletes;
    protected $table = 'especialidades';

    protected $fillable = [
        'clinica_id',
        'nombre',
        'descripcion',
        'icono',
        'activo',
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }
}