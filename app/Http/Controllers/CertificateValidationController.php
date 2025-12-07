<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Validacion;
use Illuminate\Http\Request;

class CertificateValidationController extends Controller
{
    /**
     * Mostrar formulario de validación
     */
    public function showForm()
    {
        return view('public.certificates.validate');
    }

    /**
     * Validar certificado por código
     */
    public function validate(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50',
        ]);

        $certificado = Certificado::with(['user', 'actividad', 'inscripcion'])
            ->where('codigo_validacion', strtoupper($request->codigo))
            ->where('activo', true)
            ->first();

        if (!$certificado) {
            return back()->with('error', 'Código de validación no encontrado o certificado inactivo.');
        }

        // Registrar la validación
        Validacion::create([
            'certificado_id' => $certificado->id,
            'ip_address' => $request->ip(),
            'fecha_hora_validacion' => now(),
            'user_agent' => $request->userAgent(),
        ]);

        return view('public.certificates.validate', compact('certificado'));
    }
}
