<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historial extends Model
{
    use SoftDeletes;

    protected $table = 'historiales';

    protected $fillable = [
        'clinica_id',
        'paciente_id',
        'medico_id',
        'cita_id',
        'fecha',
        'motivo_consulta',
        'sintomas',
        'exploracion_fisica',
        'diagnostico',
        'tratamiento',
        'observaciones',
        'peso',
        'talla',
        'presion_sistolica',
        'presion_diastolica',
        'frecuencia_cardiaca',
        'temperatura',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function getPresionAttribute()
    {
        if ($this->presion_sistolica && $this->presion_diastolica) {
            return $this->presion_sistolica . '/' . $this->presion_diastolica;
        }
        return null;
    }
}