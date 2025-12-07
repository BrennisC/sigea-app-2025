<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Certificado;
use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard del administrador
     */
    public function index()
    {
        // Estadísticas generales
        $totalUsuarios = User::count();
        $totalActividades = Actividad::count();
        $totalInscripciones = Inscripcion::count();
        $totalCertificados = Certificado::where('activo', true)->count();

        // Actividades recientes
        $actividadesRecientes = Actividad::with(['organizador', 'tipo', 'estado'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Usuarios recientes
        $usuariosRecientes = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Actividades por estado
        $actividadesPorEstado = Actividad::with('estado')
            ->get()
            ->groupBy('estado.nombre')
            ->map(function ($group) {
                return $group->count();
            });

        // Inscripciones por mes (últimos 6 meses) - Compatible con SQLite
        $inscripcionesPorMes = Inscripcion::selectRaw("strftime('%Y-%m', created_at) as mes, COUNT(*) as total")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsuarios',
            'totalActividades',
            'totalInscripciones',
            'totalCertificados',
            'actividadesRecientes',
            'usuariosRecientes',
            'actividadesPorEstado',
            'inscripcionesPorMes'
        ));
    }

    /**
     * Página de reportes
     */
    public function reports()
    {
        // Aquí puedes implementar reportes más detallados
        return view('admin.reports');
    }
}
