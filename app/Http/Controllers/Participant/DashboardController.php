<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Certificado;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard del participante
     */
    public function index()
    {
        $user = auth()->user();

        // Próximas actividades inscritas
        $proximasActividades = Inscripcion::with(['actividad.sesiones', 'estado'])
            ->where('user_id', $user->id)
            ->whereHas('actividad', function ($query) {
                $query->where('fecha_inicio', '>=', now())
                      ->where('activo', true);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Últimos certificados
        $ultimosCertificados = Certificado::with('actividad')
            ->where('user_id', $user->id)
            ->where('activo', true)
            ->orderBy('fecha_emision', 'desc')
            ->take(3)
            ->get();

        // Notificaciones no leídas
        $notificaciones = $user->notificaciones()
            ->where('leida', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Estadísticas
        $totalInscripciones = $user->inscripciones()->count();
        $totalCertificados = $user->certificados()->where('activo', true)->count();

        return view('participant.dashboard', compact(
            'proximasActividades',
            'ultimosCertificados',
            'notificaciones',
            'totalInscripciones',
            'totalCertificados'
        ));
    }
}
