<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Estado;
use App\Models\Tipo;
use Illuminate\Http\Request;

class PublicActivityController extends Controller
{
    /**
     * Listar todas las actividades públicas
     */
    public function index(Request $request)
    {
        $query = Actividad::with(['organizador', 'tipo', 'estado'])
            ->whereHas('estado', function ($q) {
                $q->where('nombre', 'Publicada');
            })
            ->where('activo', true);

        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo_id', $request->tipo);
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', $request->modalidad);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_inicio', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_fin', '<=', $request->fecha_hasta);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        $actividades = $query->orderBy('fecha_inicio', 'asc')->paginate(12);
        
        // Para los filtros
        $tipos = Tipo::where('categoria', 'actividad')->where('activo', true)->get();
        $modalidades = ['presencial', 'virtual', 'hibrida'];

        return view('public.activities.index', compact('actividades', 'tipos', 'modalidades'));
    }

    /**
     * Mostrar detalle de una actividad
     */
    public function show($id)
    {
        $actividad = Actividad::with(['organizador', 'tipo', 'estado', 'sesiones'])
            ->where('activo', true)
            ->findOrFail($id);

        // Contar inscritos
        $inscritosCount = $actividad->inscripciones()->count();
        
        // Verificar si hay cupo disponible
        $cupoDisponible = $actividad->cupo_maximo 
            ? ($actividad->cupo_maximo - $inscritosCount) 
            : null;

        return view('public.activities.show', compact('actividad', 'inscritosCount', 'cupoDisponible'));
    }
}
