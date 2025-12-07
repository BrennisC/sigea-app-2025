<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard del organizador
     */
    public function index()
    {
        $user = auth()->user();

        // Actividades que organiza
        $actividadesRecientes = Actividad::with(['tipo', 'estado', 'inscripciones', 'sesiones'])
            ->where('organizador_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Estadísticas
        $totalActividades = Actividad::where('organizador_id', $user->id)->count();
        
        $totalInscritos = Actividad::where('organizador_id', $user->id)
            ->withCount('inscripciones')
            ->get()
            ->sum('inscripciones_count');

        $totalSesiones = Actividad::where('organizador_id', $user->id)
            ->withCount('sesiones')
            ->get()
            ->sum('sesiones_count');

        $totalCertificados = Actividad::where('organizador_id', $user->id)
            ->withCount('certificados')
            ->get()
            ->sum('certificados_count');

        // Próximas sesiones
        $proximasSesiones = \App\Models\Sesion::with('actividad')
            ->whereHas('actividad', function ($query) use ($user) {
                $query->where('organizador_id', $user->id);
            })
            ->where('fecha_hora_inicio', '>=', now())
            ->orderBy('fecha_hora_inicio', 'asc')
            ->take(5)
            ->get();

        return view('organizer.dashboard', compact(
            'actividadesRecientes',
            'totalActividades',
            'totalInscritos',
            'totalSesiones',
            'totalCertificados',
            'proximasSesiones'
        ));
    }
}
