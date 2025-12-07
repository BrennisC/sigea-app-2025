<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Mostrar la landing page
     */
    public function index()
    {
        // Obtener próximas actividades publicadas
        $proximasActividades = Actividad::with(['organizador', 'tipo', 'estado'])
            ->whereHas('estado', function ($query) {
                $query->where('nombre', 'Publicada');
            })
            ->where('activo', true)
            ->where('fecha_inicio', '>=', now())
            ->orderBy('fecha_inicio', 'asc')
            ->take(6)
            ->get();

        return view('public.landing', compact('proximasActividades'));
    }
}
