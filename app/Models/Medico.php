<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medico extends Model
{
    use SoftDeletes;
    protected $table = 'medicos';

    protected $fillable = [
        'clinica_id',
        'user_id',
        'especialidad_id',
        'cedula_profesional',
        'nombre',
        'apellidos',
        'telefono',
        'foto',
        'biografia',
        'activo',
	'logo', 'firma', 'cedula',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellidos;
    }
}
