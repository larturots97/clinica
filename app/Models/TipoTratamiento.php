<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoTratamiento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medico_id', 'nombre', 'grupo', 'clave', 'descripcion',
        'precio_base', 'icono', 'activo', 'orden',
    ];

    protected $casts = [
        'activo'      => 'boolean',
        'precio_base' => 'decimal:2',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function tratamientos()
    {
        return $this->hasMany(TratamientoEstetico::class, 'tipo_tratamiento_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->orderBy('orden')->orderBy('nombre');
    }

    public static function grupoNombre($grupo): string
    {
        return match($grupo) {
            'A' => 'Neuromoduladores',
            'B' => 'Rellenos / Hidratacion',
            'C' => 'Bioestimulacion',
            'D' => 'Lipoliticos / Corporales',
            'E' => 'Piel Superficial',
            default => 'Sin grupo',
        };
    }
}
