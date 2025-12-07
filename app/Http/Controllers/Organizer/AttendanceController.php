<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Asistencia;
use App\Models\Sesion;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Listar actividades para toma de asistencia
     */
    public function index()
    {
        $actividades = Actividad::where('organizador_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('organizer.attendance.index', compact('actividades'));
    }

    /**
     * Mostrar formulario de asistencia para una sesión
     */
    public function show($sessionId)
    {
        $sesion = Sesion::with(['actividad.inscripciones.user', 'asistencias'])
            ->whereHas('actividad', function ($query) {
                $query->where('organizador_id', auth()->id());
            })
            ->findOrFail($sessionId);

        // Obtener todas las inscripciones de la actividad
        $inscripciones = $sesion->actividad->inscripciones;

        // Crear un mapa de asistencias existentes
        $asistenciasMap = $sesion->asistencias->keyBy('inscripcion_id');

        return view('organizer.attendance.show', compact('sesion', 'inscripciones', 'asistenciasMap'));
    }

    /**
     * Guardar o actualizar asistencias
     */
    public function store(Request $request, $sessionId)
    {
        $sesion = Sesion::whereHas('actividad', function ($query) {
            $query->where('organizador_id', auth()->id());
        })->findOrFail($sessionId);

        $request->validate([
            'asistencias' => 'required|array',
            'asistencias.*' => 'boolean',
        ]);

        foreach ($request->asistencias as $inscripcionId => $presente) {
            Asistencia::updateOrCreate(
                [
                    'inscripcion_id' => $inscripcionId,
                    'sesion_id' => $sessionId,
                ],
                [
                    'presente' => $presente,
                    'fecha_hora_registro' => now(),
                    'registrado_por' => auth()->id(),
                ]
            );
        }

        // Marcar sesión como asistencia tomada
        $sesion->update(['asistencia_tomada' => true]);

        return redirect()->route('organizer.sesiones.index', $sesion->actividad_id)
            ->with('success', 'Asistencia registrada exitosamente.');
    }
}
