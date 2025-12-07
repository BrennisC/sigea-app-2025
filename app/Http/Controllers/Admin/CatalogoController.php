<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\MetodoPago;
use App\Models\Tipo;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    /**
     * Mostrar todos los catálogos
     */
    public function index()
    {
        $estados = Estado::orderBy('tipo')->orderBy('nombre')->get();
        $tipos = Tipo::orderBy('categoria')->orderBy('nombre')->get();
        $metodosPago = MetodoPago::orderBy('nombre')->get();

        return view('admin.catalogos.index', compact('estados', 'tipos', 'metodosPago'));
    }

    /**
     * Crear nuevo elemento de catálogo
     */
    public function store(Request $request, $tipo)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        switch ($tipo) {
            case 'estados':
                $request->validate(['tipo' => 'required|string|max:50']);
                Estado::create([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'tipo' => $request->tipo,
                    'activo' => true,
                ]);
                break;

            case 'tipos':
                $request->validate(['categoria' => 'required|string|max:50']);
                Tipo::create([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'categoria' => $request->categoria,
                    'activo' => true,
                ]);
                break;

            case 'metodos-pago':
                MetodoPago::create([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'activo' => true,
                ]);
                break;

            default:
                return back()->with('error', 'Tipo de catálogo no válido.');
        }

        return back()->with('success', 'Elemento creado exitosamente.');
    }

    /**
     * Actualizar elemento de catálogo
     */
    public function update(Request $request, $tipo, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        switch ($tipo) {
            case 'estados':
                $item = Estado::findOrFail($id);
                $request->validate(['tipo' => 'required|string|max:50']);
                $item->update([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'tipo' => $request->tipo,
                ]);
                break;

            case 'tipos':
                $item = Tipo::findOrFail($id);
                $request->validate(['categoria' => 'required|string|max:50']);
                $item->update([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'categoria' => $request->categoria,
                ]);
                break;

            case 'metodos-pago':
                $item = MetodoPago::findOrFail($id);
                $item->update([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                ]);
                break;

            default:
                return back()->with('error', 'Tipo de catálogo no válido.');
        }

        return back()->with('success', 'Elemento actualizado exitosamente.');
    }

    /**
     * Eliminar (desactivar) elemento de catálogo
     */
    public function destroy($tipo, $id)
    {
        switch ($tipo) {
            case 'estados':
                $item = Estado::findOrFail($id);
                break;
            case 'tipos':
                $item = Tipo::findOrFail($id);
                break;
            case 'metodos-pago':
                $item = MetodoPago::findOrFail($id);
                break;
            default:
                return back()->with('error', 'Tipo de catálogo no válido.');
        }

        $item->update(['activo' => false]);
        return back()->with('success', 'Elemento desactivado exitosamente.');
    }
}
