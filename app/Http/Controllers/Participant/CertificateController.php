<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Certificado;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Listar mis certificados
     */
    public function index()
    {
        $user = auth()->user();

        $certificados = Certificado::with('actividad')
            ->where('user_id', $user->id)
            ->where('activo', true)
            ->orderBy('fecha_emision', 'desc')
            ->paginate(10);

        return view('participant.certificates.index', compact('certificados'));
    }

    /**
     * Descargar certificado en PDF
     */
    /**
     * Ver/Descargar certificado
     */
    public function download($id)
    {
        $user = auth()->user();

        $certificado = Certificado::with(['actividad', 'user'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->where('activo', true)
            ->firstOrFail();

        return view('certificates.pdf', compact('certificado'));
    }
}
