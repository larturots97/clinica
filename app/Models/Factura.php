<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clinica_id',
        'paciente_id',
        'medico_id',
        'cita_id',
        'folio',
        'fecha',
        'subtotal',
        'descuento',
        'impuesto',
        'total',
        'estado',
        'metodo_pago',
        'notas',
    ];

    protected $casts = [
        'fecha'    => 'date',
        'subtotal' => 'decimal:2',
        'descuento'=> 'decimal:2',
        'impuesto' => 'decimal:2',
        'total'    => 'decimal:2',
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

    public function items()
    {
        return $this->hasMany(FacturaItem::class)->orderBy('orden');
    }
}