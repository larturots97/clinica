<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionMedico extends Model
{
    protected $table = 'configuraciones_medico';

    protected $fillable = [
        'medico_id',
        'clinica_id',
        'logo',
        'firma',
        'clinica_nombre',
        'clinica_direccion',
        'clinica_ciudad',
        'clinica_telefono',
        'clinica_email',
        'consentimiento_punto_1',
        'consentimiento_punto_2',
        'consentimiento_punto_3',
        'consentimiento_punto_4',
        'consentimiento_punto_5',
        'consentimiento_punto_6',
        'consentimiento_punto_7',
        'consentimiento_punto_8',
        'consentimiento_punto_9',
        'consentimiento_punto_10',
        'consentimiento_punto_11',
        'consentimiento_punto_12',
        'receta_direccion',
        'receta_instagram',
        'receta_facebook',
        'receta_whatsapp',
        'receta_logo_fondo',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }
}