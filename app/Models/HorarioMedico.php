<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HorarioMedico extends Model {
    protected $table    = 'horarios_medico';
    protected $fillable = ['medico_id','dia_semana','hora_inicio','hora_fin','activo'];
    protected $casts    = ['activo' => 'boolean', 'dia_semana' => 'integer'];

    public function medico() {
        return $this->belongsTo(Medico::class);
    }
    public static function nombreDia(int $dia): string {
        return ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'][$dia] ?? '';
    }
}
