<?php
// ══════════════════════════════════════════════
//  app/Models/LandingMedico.php
// ══════════════════════════════════════════════
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class LandingMedico extends Model
{
    protected $table = 'landing_medico';
 
    protected $fillable = [
        'medico_id',
        'foto_doctora', 'hero_titulo', 'hero_subtitulo', 'hero_descripcion',
        'foto_consultorio', 'sobre_mi', 'anos_experiencia', 'num_pacientes',
        'direccion', 'telefono', 'horario', 'whatsapp', 'instagram', 'facebook',
        'activa',
    ];
 
    protected $casts = ['activa' => 'boolean'];
 
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
 
    public function servicios()
    {
        return $this->hasMany(LandingServicio::class, 'medico_id', 'medico_id')
                    ->where('activo', true)->orderBy('orden');
    }
 
    public function galeria()
    {
        return $this->hasMany(LandingGaleria::class, 'medico_id', 'medico_id')
                    ->orderBy('orden');
    }
}
 