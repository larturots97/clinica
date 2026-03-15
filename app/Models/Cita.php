<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TipoTratamiento;

class Cita extends Model
{
    use SoftDeletes;

   protected $fillable = [
    'clinica_id',
    'paciente_id',
    'medico_id',
    'fecha_hora',
    'duracion_minutos',
    'motivo',
    'estado',
    'notas',
    'tipo_tratamiento_id',
    'telefono_paciente',
    'email_paciente',
    'recordatorio_enviado',
    'origen',
    'nombre_visitante',
    'telefono_visitante',
    'email_visitante',
    'motivo_visitante',
    'fecha_cita',
    'hora_cita',
];

    protected $casts = [
        'fecha_hora' => 'datetime',
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
    public function tipoTratamiento()
    {
        return $this->belongsTo(TipoTratamiento::class);
    }

    public function estaActiva()
    {
        return in_array($this->estado, ['pendiente', 'confirmada', 'en_curso']);
    }
}