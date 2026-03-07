<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clinica_id',
        'paciente_id',
        'medico_id',
        'historial_id',
        'folio',
        'fecha',
        'diagnostico',
        'indicaciones',
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

    public function historial()
    {
        return $this->belongsTo(Historial::class);
    }

    public function items()
    {
        return $this->hasMany(RecetaItem::class)->orderBy('orden');
    }
}