<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinica extends Model
{
    use SoftDeletes;
    protected $table = 'clinicas';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'logo',
        'rfc',
        'activo',
    ];

    public function especialidades()
    {
        return $this->hasMany(Especialidad::class);
    }

    public function pacientes()
    {
        return $this->hasMany(Paciente::class);
    }

    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}