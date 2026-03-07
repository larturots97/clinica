<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\TipoTratamiento;
use Illuminate\Http\Request;

class TipoTratamientoController extends Controller
{
    private function getMedico()
    {
        return auth()->user()->medico;
    }

    public function index()
    {
        $medico = $this->getMedico();
        $tratamientos = TipoTratamiento::where('medico_id', $medico->id)
            ->orderBy('grupo')->orderBy('orden')->orderBy('nombre')
            ->get()
            ->groupBy('grupo');

        return view('medico.tipo-tratamientos.index', compact('tratamientos', 'medico'));
    }

    public function create()
    {
        $grupos = [
            'A' => 'Neuromoduladores',
            'B' => 'Rellenos / Hidratacion',
            'C' => 'Bioestimulacion',
            'D' => 'Lipoliticos / Corporales',
            'E' => 'Piel Superficial',
        ];
        $claves = $this->getClavesDisponibles();
        return view('medico.tipo-tratamientos.create', compact('grupos', 'claves'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'grupo'       => 'required|in:A,B,C,D,E',
            'clave'       => 'required|string|max:30',
            'precio_base' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'orden'       => 'nullable|integer',
        ]);

        $medico = $this->getMedico();

        TipoTratamiento::create([
            'medico_id'   => $medico->id,
            'nombre'      => $request->nombre,
            'grupo'       => $request->grupo,
            'clave'       => $request->clave,
            'descripcion' => $request->descripcion,
            'precio_base' => $request->precio_base,
            'activo'      => $request->boolean('activo', true),
            'orden'       => $request->orden ?? 0,
        ]);

        return redirect()->route('medico.tipo-tratamientos.index')
            ->with('success', 'Tratamiento agregado correctamente.');
    }

    public function edit(TipoTratamiento $tipoTratamiento)
    {
        $this->authorizeMedico($tipoTratamiento);
        $grupos = [
            'A' => 'Neuromoduladores',
            'B' => 'Rellenos / Hidratacion',
            'C' => 'Bioestimulacion',
            'D' => 'Lipoliticos / Corporales',
            'E' => 'Piel Superficial',
        ];
        $claves = $this->getClavesDisponibles();
        return view('medico.tipo-tratamientos.edit', compact('tipoTratamiento', 'grupos', 'claves'));
    }

    public function update(Request $request, TipoTratamiento $tipoTratamiento)
    {
        $this->authorizeMedico($tipoTratamiento);
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'grupo'       => 'required|in:A,B,C,D,E',
            'clave'       => 'required|string|max:30',
            'precio_base' => 'required|numeric|min:0',
        ]);

        $tipoTratamiento->update([
            'nombre'      => $request->nombre,
            'grupo'       => $request->grupo,
            'clave'       => $request->clave,
            'descripcion' => $request->descripcion,
            'precio_base' => $request->precio_base,
            'activo'      => $request->boolean('activo', true),
            'orden'       => $request->orden ?? 0,
        ]);

        return redirect()->route('medico.tipo-tratamientos.index')
            ->with('success', 'Tratamiento actualizado.');
    }

    public function destroy(TipoTratamiento $tipoTratamiento)
    {
        $this->authorizeMedico($tipoTratamiento);
        $tipoTratamiento->delete();
        return redirect()->route('medico.tipo-tratamientos.index')
            ->with('success', 'Tratamiento eliminado.');
    }

    public function toggleActivo(TipoTratamiento $tipoTratamiento)
    {
        $this->authorizeMedico($tipoTratamiento);
        $tipoTratamiento->update(['activo' => !$tipoTratamiento->activo]);
        return back()->with('success', 'Estado actualizado.');
    }

    private function authorizeMedico(TipoTratamiento $t)
    {
        if ($t->medico_id !== $this->getMedico()->id) abort(403);
    }

    private function getClavesDisponibles(): array
    {
        return [
            'A' => ['botox' => 'Toxina Botulinica (Botox)'],
            'B' => [
                'ha'          => 'Acido Hialuronico',
                'profhilo'    => 'Profhilo',
                'skinbooster' => 'Skinbooster',
                'nctf'        => 'NCTF',
                'pdrn'        => 'PDRN Salmon',
            ],
            'C' => [
                'prf'          => 'Bioestimulacion / PRF',
                'microneedling'=> 'Microneedling',
            ],
            'D' => [
                'lipoenzimas'    => 'Lipoenzimas',
                'glp1'           => 'GLP1',
                'escleroterapia' => 'Escleroterapia',
            ],
            'E' => [
                'peeling'    => 'Peeling',
                'mesoterapia'=> 'Mesoterapia',
                'capilar'    => 'Tratamiento Capilar / Alopecia',
            ],
        ];
    }
}
