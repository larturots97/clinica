<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TratamientoEstetico extends Model
{
    use SoftDeletes;

    protected $table = 'tratamientos_esteticos';

    protected $fillable = [
        'clinica_id', 'paciente_id', 'medico_id', 'tipo_tratamiento_id',
        'fecha', 'titulo', 'grupo', 'tipo_clave', 'motivo_consulta',
        'fitzpatrick', 'tipo_piel', 'condiciones_piel', 'antecedentes',
        'simetria', 'tonicidad', 'tecnica', 'profundidad',
        'producto_id', 'producto_cantidad',
        'producto_marca', 'producto_lote', 'producto_caducidad',
        'sesion_numero', 'intervalo', 'volumen_total', 'unidad_volumen',
        'objetivo', 'observaciones_generales', 'observaciones_post',
        'consentimiento_idioma', 'consentimiento_entrega', 'campos_extra',
        'peso', 'talla', 'temperatura', 'tension_arterial',
        'frecuencia_cardiaca', 'saturacion_o2', 'exploracion_fisica',
        'mapa_activo', 'zonas_texto',
    ];

    protected $casts = [
        'fecha'              => 'date',
        'producto_caducidad' => 'date',
        'tipo_piel'          => 'array',
        'condiciones_piel'   => 'array',
        'antecedentes'       => 'array',
        'campos_extra'       => 'array',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function tipoTratamiento()
    {
        return $this->belongsTo(TipoTratamiento::class, 'tipo_tratamiento_id');
    }

    // ── Relación con inventario ──────────────────────────────────
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function zonas()
    {
        return $this->hasMany(TratamientoZona::class, 'tratamiento_id');
    }

    public function zonasPredefinidas()
    {
        return $this->hasMany(TratamientoZona::class, 'tratamiento_id')
                    ->where('tipo', 'predefinida')
                    ->where('activa', true);
    }

    public function zonasLibres()
    {
        return $this->hasMany(TratamientoZona::class, 'tratamiento_id')
                    ->where('tipo', 'libre');
    }

    public function getTotalUnidadesAttribute(): float
    {
        return $this->zonas()->sum('cantidad');
    }
}