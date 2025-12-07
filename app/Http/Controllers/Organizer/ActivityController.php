<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Estado;
use App\Models\Tipo;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Listar actividades del organizador
     */
    public function index()
    {
        $user = auth()->user();

        $actividades = Actividad::with(['tipo', 'estado'])
            ->where('organizador_id', $user->id)
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(4);

        return view('organizer.activities.index', compact('actividades'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $tipos = Tipo::where('categoria', 'actividad')->where('activo', true)->get();
        $estados = Estado::where('tipo', 'actividad')->where('activo', true)->get();
        $modalidades = ['presencial', 'virtual', 'hibrida'];

        return view('organizer.activities.create', compact('tipos', 'estados', 'modalidades'));
    }

    /**
     * Guardar nueva actividad
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo_id' => 'required|exists:tipos,id',
            'estado_id' => 'required|exists:estados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'modalidad' => 'required|in:presencial,virtual,hibrida',
            'ubicacion' => 'nullable|string',
            'url_virtual' => 'nullable|url',
            'precio' => 'required|numeric|min:0',
            'cupo_maximo' => 'nullable|integer|min:1',
            'horas_totales' => 'nullable|integer|min:1',
            'porcentaje_asistencia_minima' => 'nullable|numeric|min:0|max:100',
            'imagen_url' => 'nullable|url',
        ]);

        $actividad = Actividad::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'organizador_id' => auth()->id(),
            'tipo_id' => $request->tipo_id,
            'estado_id' => $request->estado_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'modalidad' => $request->modalidad,
            'ubicacion' => $request->ubicacion,
            'url_virtual' => $request->url_virtual,
            'precio' => $request->precio,
            'cupo_maximo' => $request->cupo_maximo,
            'horas_totales' => $request->horas_totales,
            'porcentaje_asistencia_minima' => $request->porcentaje_asistencia_minima ?? 75.00,
            'imagen_url' => $request->imagen_url,
            'activo' => true,
        ]);

        return redirect()->route('organizer.actividades.index')
            ->with('success', 'Actividad creada exitosamente.');
    }

    /**
     * Mostrar detalle de actividad
     */
    public function show($id)
    {
        $actividad = Actividad::with(['tipo', 'estado', 'sesiones', 'inscripciones.user'])
            ->where('organizador_id', auth()->id())
            ->findOrFail($id);

        return view('organizer.activities.show', compact('actividad'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $actividad = Actividad::where('organizador_id', auth()->id())->findOrFail($id);
        $tipos = Tipo::where('categoria', 'actividad')->where('activo', true)->get();
        $estados = Estado::where('tipo', 'actividad')->where('activo', true)->get();
        $modalidades = ['presencial', 'virtual', 'hibrida'];

        return view('organizer.activities.edit', compact('actividad', 'tipos', 'estados', 'modalidades'));
    }

    /**
     * Actualizar actividad
     */
    public function update(Request $request, $id)
    {
        $actividad = Actividad::where('organizador_id', auth()->id())->findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo_id' => 'required|exists:tipos,id',
            'estado_id' => 'required|exists:estados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'modalidad' => 'required|in:presencial,virtual,hibrida',
            'ubicacion' => 'nullable|string',
            'url_virtual' => 'nullable|url',
            'precio' => 'required|numeric|min:0',
            'cupo_maximo' => 'nullable|integer|min:1',
            'horas_totales' => 'nullable|integer|min:1',
            'porcentaje_asistencia_minima' => 'nullable|numeric|min:0|max:100',
            'imagen_url' => 'nullable|url',
        ]);

        $actividad->update($request->all());

        return redirect()->route('organizer.actividades.index')
            ->with('success', 'Actividad actualizada exitosamente.');
    }

    /**
     * Eliminar actividad
     */
    public function destroy($id)
    {
        $actividad = Actividad::where('organizador_id', auth()->id())->findOrFail($id);
        $actividad->update(['activo' => false]);

        return redirect()->route('organizer.actividades.index')
            ->with('success', 'Actividad desactivada exitosamente.');
    }

    /**
     * Ver inscripciones de una actividad
     */
    public function enrollments($id)
    {
        $actividad = Actividad::with(['inscripciones.user', 'inscripciones.estado'])
            ->where('organizador_id', auth()->id())
            ->findOrFail($id);

        return view('organizer.activities.enrollments', compact('actividad'));
    }
}
