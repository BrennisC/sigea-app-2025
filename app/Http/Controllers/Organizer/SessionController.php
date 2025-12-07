<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Sesion;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Listar actividades para gestión de sesiones
     */
    public function indexAll()
    {
        $actividades = Actividad::where('organizador_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('organizer.sessions.all', compact('actividades'));
    }

    /**
     * Listar sesiones de una actividad
     */
    public function index($activityId)
    {
        $actividad = Actividad::where('organizador_id', auth()->id())->findOrFail($activityId);
        $sesiones = $actividad->sesiones()->orderBy('fecha_hora_inicio', 'asc')->get();

        return view('organizer.sessions.index', compact('actividad', 'sesiones'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create($activityId)
    {
        $actividad = Actividad::where('organizador_id', auth()->id())->findOrFail($activityId);
        return view('organizer.sessions.create', compact('actividad'));
    }

    /**
     * Guardar nueva sesión
     */
    public function store(Request $request, $activityId)
    {
        $actividad = Actividad::where('organizador_id', auth()->id())->findOrFail($activityId);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora_inicio' => 'required|date',
            'fecha_hora_fin' => 'required|date|after:fecha_hora_inicio',
            'duracion_minutos' => 'nullable|integer|min:1',
            'ubicacion' => 'nullable|string',
            'url_virtual' => 'nullable|url',
            'instructor' => 'nullable|string|max:255',
        ]);

        Sesion::create([
            'actividad_id' => $actividad->id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_hora_inicio' => $request->fecha_hora_inicio,
            'fecha_hora_fin' => $request->fecha_hora_fin,
            'duracion_minutos' => $request->duracion_minutos,
            'ubicacion' => $request->ubicacion,
            'url_virtual' => $request->url_virtual,
            'instructor' => $request->instructor,
        ]);

        return redirect()->route('organizer.sesiones.index', $activityId)
            ->with('success', 'Sesión creada exitosamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $sesion = Sesion::whereHas('actividad', function ($query) {
            $query->where('organizador_id', auth()->id());
        })->findOrFail($id);

        return view('organizer.sessions.edit', compact('sesion'));
    }

    /**
     * Actualizar sesión
     */
    public function update(Request $request, $id)
    {
        $sesion = Sesion::whereHas('actividad', function ($query) {
            $query->where('organizador_id', auth()->id());
        })->findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora_inicio' => 'required|date',
            'fecha_hora_fin' => 'required|date|after:fecha_hora_inicio',
            'duracion_minutos' => 'nullable|integer|min:1',
            'ubicacion' => 'nullable|string',
            'url_virtual' => 'nullable|url',
            'instructor' => 'nullable|string|max:255',
        ]);

        $sesion->update($request->all());

        return redirect()->route('organizer.sesiones.index', $sesion->actividad_id)
            ->with('success', 'Sesión actualizada exitosamente.');
    }

    /**
     * Eliminar sesión
     */
    public function destroy($id)
    {
        $sesion = Sesion::whereHas('actividad', function ($query) {
            $query->where('organizador_id', auth()->id());
        })->findOrFail($id);

        $activityId = $sesion->actividad_id;
        $sesion->delete();

        return redirect()->route('organizer.sesiones.index', $activityId)
            ->with('success', 'Sesión eliminada exitosamente.');
    }
}
