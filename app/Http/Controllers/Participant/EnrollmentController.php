<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Estado;
use App\Models\Inscripcion;
use App\Models\Notificacion;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Listar mis actividades inscritas
     */
    public function index()
    {
        $user = auth()->user();

        $inscripciones = Inscripcion::with(['actividad.tipo', 'actividad.estado', 'estado', 'asistencias'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        return view('participant.enrollments.index', compact('inscripciones'));
    }

    /**
     * Inscribirse en una actividad
     */
    public function store(Request $request)
    {
        $request->validate([
            'actividad_id' => 'required|exists:actividades,id',
        ]);

        $user = auth()->user();
        $actividad = Actividad::findOrFail($request->actividad_id);

        // Verificar si ya está inscrito
        $yaInscrito = Inscripcion::where('user_id', $user->id)
            ->where('actividad_id', $actividad->id)
            ->exists();

        if ($yaInscrito) {
            return back()->with('error', 'Ya estás inscrito en esta actividad.');
        }

        // Verificar cupo disponible
        if ($actividad->cupo_maximo) {
            $inscritosCount = $actividad->inscripciones()->count();
            if ($inscritosCount >= $actividad->cupo_maximo) {
                return back()->with('error', 'No hay cupo disponible para esta actividad.');
            }
        }

        // Obtener estado "Pendiente" o "Confirmada"
        $estadoPendiente = Estado::where('nombre', 'Pendiente')
            ->where('tipo', 'inscripcion')
            ->first();

        // Crear inscripción
        $inscripcion = Inscripcion::create([
            'user_id' => $user->id,
            'actividad_id' => $actividad->id,
            'estado_id' => $estadoPendiente?->id,
            'fecha_inscripcion' => now(),
            'pago_requerido' => $actividad->precio > 0,
            'pago_completado' => $actividad->precio == 0, // Si es gratis, marcar como completado
        ]);

        // Crear notificación
        Notificacion::create([
            'user_id' => $user->id,
            'titulo' => 'Inscripción exitosa',
            'mensaje' => "Te has inscrito exitosamente en: {$actividad->nombre}",
            'tipo' => 'success',
            'enlace' => route('participant.enrollments.index'),
        ]);

        return redirect()->route('participant.enrollments.index')
            ->with('success', 'Te has inscrito exitosamente en la actividad.');
    }
}
