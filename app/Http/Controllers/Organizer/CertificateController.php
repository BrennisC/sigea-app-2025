<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Asistencia;
use App\Models\Certificado;
use App\Models\Inscripcion;
use App\Models\Notificacion;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Listar TODOS los certificados generados por el organizador (de todas sus actividades)
     */
    public function indexAll()
    {
        $certificados = Certificado::with(['actividad', 'user'])
            ->whereHas('actividad', function($query) {
                $query->where('organizador_id', auth()->id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('organizer.certificates.all', compact('certificados'));
    }
    /**
     * Listar certificados de una actividad
     */
    public function index($activityId)
    {
        $actividad = Actividad::with('certificados.user')
            ->where('organizador_id', auth()->id())
            ->findOrFail($activityId);

        $totalInscritos = $actividad->inscripciones()->count();
        $certificadosEmitidos = $actividad->certificados()->count();
        $certificados = $actividad->certificados()->paginate(4);

        // Obtener participantes elegibles (inscritos que cumplen asistencia pero sin certificado)
        $participantesElegibles = Inscripcion::where('actividad_id', $actividad->id)
            ->whereDoesntHave('certificado') // Que no tengan certificado aún
            ->get()
            ->filter(function ($inscripcion) use ($actividad) {
                // Si no hay sesiones, no se puede calcular asistencia
                if ($actividad->sesiones()->count() == 0) {
                    return false;
                }
                $porcentaje = $inscripcion->calcularPorcentajeAsistencia();
                return $porcentaje >= $actividad->porcentaje_asistencia_minima;
            });

        return view('organizer.certificates.index', compact(
            'actividad',
            'totalInscritos',
            'certificadosEmitidos',
            'certificados',
            'participantesElegibles'
        ));
    }

    /**
     * Generar certificados para participantes elegibles
     */
    public function generate(Request $request)
    {
        $request->validate([
            'actividad_id' => 'required|exists:actividades,id',
        ]);

        $actividad = Actividad::where('organizador_id', auth()->id())->findOrFail($request->actividad_id);

        // Obtener todas las inscripciones de la actividad
        $inscripciones = Inscripcion::where('actividad_id', $actividad->id)->get();

        $certificadosGenerados = 0;
        $totalSesiones = $actividad->sesiones()->count();

        if ($totalSesiones == 0) {
            return back()->with('error', 'La actividad no tiene sesiones registradas.');
        }

        foreach ($inscripciones as $inscripcion) {
            // Verificar si ya tiene certificado
            if ($inscripcion->certificado) {
                continue;
            }

            // Contar asistencias del participante
            $asistencias = Asistencia::where('inscripcion_id', $inscripcion->id)
                ->where('presente', true)
                ->count();

            // Calcular porcentaje de asistencia
            $porcentajeAsistencia = ($asistencias / $totalSesiones) * 100;

            // Verificar si cumple el porcentaje mínimo
            if ($porcentajeAsistencia >= $actividad->porcentaje_asistencia_minima) {
                // Generar certificado
                Certificado::create([
                    'inscripcion_id' => $inscripcion->id,
                    'actividad_id' => $actividad->id,
                    'user_id' => $inscripcion->user_id,
                    'fecha_emision' => now(),
                    'porcentaje_asistencia' => $porcentajeAsistencia,
                    'horas_certificadas' => $actividad->horas_totales,
                    'generado_por' => auth()->id(),
                    'activo' => true,
                ]);

                // Crear notificación
                Notificacion::create([
                    'user_id' => $inscripcion->user_id,
                    'titulo' => 'Certificado Generado',
                    'mensaje' => "Tu certificado para '{$actividad->nombre}' ha sido generado. ¡Felicitaciones!",
                    'tipo' => 'success',
                    'enlace' => route('participant.certificates.index'),
                ]);

                $certificadosGenerados++;
            }
        }

        return back()->with('success', "Se generaron {$certificadosGenerados} certificado(s) exitosamente.");
    }
    /**
     * Ver un certificado específico
     */
    public function show($id)
    {
        $certificado = Certificado::with(['actividad', 'user'])
            ->whereHas('actividad', function($query) {
                $query->where('organizador_id', auth()->id());
            })
            ->findOrFail($id);

        return view('certificates.pdf', compact('certificado'));
    }

    /**
     * Mostrar selección de actividad para generar certificados
     */
    public function create()
    {
        $actividades = Actividad::where('organizador_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('organizer.certificates.select', compact('actividades'));
    }
}
