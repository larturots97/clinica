<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\LandingMedico;
use App\Models\LandingServicio;
use App\Models\LandingGaleria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LandingConfigController extends Controller
{
    // ── Hero ────────────────────────────────────────────────────
    public function updateHero(Request $request)
    {
        $medico = Auth::user()->medico;
        $request->validate([
            'hero_titulo'      => 'nullable|string|max:120',
            'hero_descripcion' => 'nullable|string|max:500',
            'anos_experiencia' => 'nullable|string|max:20',
            'num_pacientes'    => 'nullable|string|max:20',
            'foto_doctora'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $landing = LandingMedico::firstOrCreate(['medico_id' => $medico->id]);
        $data = $request->only(['hero_titulo', 'hero_descripcion', 'anos_experiencia', 'num_pacientes']);

        if ($request->hasFile('foto_doctora')) {
            if ($landing->foto_doctora) Storage::disk(config('filesystems.default'))->delete($landing->foto_doctora);
            $data['foto_doctora'] = $request->file('foto_doctora')->store('landing', config('filesystems.default'));
        }

        $landing->update($data);
        return redirect()->route('medico.configuraciones.index', ['tab' => 'landing'])
            ->with('success', 'Hero actualizado correctamente.');
    }

    // ── Sobre mí ────────────────────────────────────────────────
    public function updateSobre(Request $request)
    {
        $medico = Auth::user()->medico;
        $request->validate([
            'sobre_mi'        => 'nullable|string|max:1000',
            'foto_consultorio' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $landing = LandingMedico::firstOrCreate(['medico_id' => $medico->id]);
        $data = $request->only(['sobre_mi']);

        if ($request->hasFile('foto_consultorio')) {
            if ($landing->foto_consultorio) Storage::disk(config('filesystems.default'))->delete($landing->foto_consultorio);
            $data['foto_consultorio'] = $request->file('foto_consultorio')->store('landing', config('filesystems.default'));
        }

        $landing->update($data);
        return redirect()->route('medico.configuraciones.index', ['tab' => 'landing'])
            ->with('success', 'Sección "Sobre mí" actualizada.');
    }

    // ── Contacto y redes ────────────────────────────────────────
    public function updateContacto(Request $request)
    {
        $medico = Auth::user()->medico;
        $request->validate([
            'direccion' => 'nullable|string|max:255',
            'horario'   => 'nullable|string|max:100',
            'whatsapp'  => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:60',
            'facebook'  => 'nullable|string|max:60',
        ]);

        $landing = LandingMedico::firstOrCreate(['medico_id' => $medico->id]);
        $landing->update($request->only(['direccion', 'horario', 'whatsapp', 'instagram', 'facebook']));

        return redirect()->route('medico.configuraciones.index', ['tab' => 'landing'])
            ->with('success', 'Contacto y redes actualizados.');
    }

    // ── Servicios ───────────────────────────────────────────────
    public function storeServicio(Request $request)
    {
        $medico = Auth::user()->medico;

        // Si viene _edit_id es una edición de icono
        if ($request->filled('_edit_id') && $request->filled('icono_edit')) {
            $sv = LandingServicio::where('id', $request->_edit_id)
                                 ->where('medico_id', $medico->id)
                                 ->firstOrFail();
            $sv->update(['icono' => $request->icono_edit]);
            return redirect()->route('medico.configuraciones.index', ['tab' => 'landing'])
                ->with('success', 'Ícono actualizado.');
        }

        $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:300',
            'icono'       => 'nullable|string|max:50',
        ]);

        $orden = LandingServicio::where('medico_id', $medico->id)->max('orden') + 1;

        LandingServicio::create([
            'medico_id'   => $medico->id,
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'icono'       => $request->icono ?? 'fa-star',
            'orden'       => $orden,
        ]);

        return redirect()->route('medico.configuraciones.index', ['tab' => 'landing'])
            ->with('success', 'Servicio agregado.');
    }

    public function updateIconos(Request $request)
    {
        $medico = Auth::user()->medico;
        $iconos = $request->input('iconos', []);

        foreach ($iconos as $id => $icono) {
            if ($icono) {
                LandingServicio::where('id', $id)
                    ->where('medico_id', $medico->id)
                    ->update(['icono' => $icono]);
            }
        }

        return redirect()->route('medico.configuraciones.index', ['tab' => 'landing'])
            ->with('success', 'Íconos actualizados correctamente.');
    }

    public function destroyServicio(LandingServicio $servicio)
    {
        $medico = Auth::user()->medico;
        abort_unless($servicio->medico_id === $medico->id, 403);
        $servicio->delete();
        return redirect()->route('medico.configuraciones.index', ['tab' => 'landing'])
            ->with('success', 'Servicio eliminado.');
    }

    // ── Galería ─────────────────────────────────────────────────
    public function storeGaleria(Request $request)
    {
        $medico = Auth::user()->medico;
        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'titulo' => 'nullable|string|max:100',
        ]);

        $orden = LandingGaleria::where('medico_id', $medico->id)->max('orden') + 1;
        $path  = $request->file('imagen')->store('landing/galeria', config('filesystems.default'));

        LandingGaleria::create([
            'medico_id' => $medico->id,
            'imagen'    => $path,
            'titulo'    => $request->titulo,
            'orden'     => $orden,
        ]);

        return redirect()->route('medico.configuraciones.index', ['tab' => 'landing'])
            ->with('success', 'Foto agregada a la galería.');
    }

    public function destroyGaleria(LandingGaleria $galeria)
    {
        $medico = Auth::user()->medico;
        abort_unless($galeria->medico_id === $medico->id, 403);
        Storage::disk(config('filesystems.default'))->delete($galeria->imagen);
        $galeria->delete();
        return redirect()->route('medico.configuraciones.index', ['tab' => 'landing'])
            ->with('success', 'Foto eliminada.');
    }
}