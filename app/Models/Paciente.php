<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use SoftDeletes;
    protected $table = 'pacientes';

    protected $fillable = [
        'clinica_id',
        'numero_expediente',
        'nombre',
        'apellidos',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'email',
        'direccion',
        'tipo_sangre',
        'alergias',
        'antecedentes',
        'foto',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellidos;
    }
    public function tratamientosEsteticos()
    {
        return $this->hasMany(\App\Models\TratamientoEstetico::class);
    }
    public function historiales()
    {
        return $this->hasMany(\App\Models\Historial::class);
    }

    public function recetas()
    {
        return $this->hasMany(\App\Models\Receta::class);
    }

    public function citas()
    {
        return $this->hasMany(\App\Models\Cita::class);
    }
}