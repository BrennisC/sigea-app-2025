<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Listar todos los usuarios
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%")
                  ->orWhere('documento_identidad', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('rol')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('rol_id', $request->rol);
            });
        }

        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }

        $usuarios = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Rol::where('activo', true)->get();

        return view('admin.users.index', compact('usuarios', 'roles'));
    }

    /**
     * Mostrar detalle de usuario
     */
    public function show($id)
    {
        $usuario = User::with(['roles', 'inscripciones.actividad', 'certificados', 'actividadesOrganizadas'])
            ->findOrFail($id);

        return view('admin.users.show', compact('usuario'));
    }

    /**
     * Actualizar roles de un usuario
     */
    public function updateRoles(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Sincronizar roles
        $usuario->roles()->sync($request->roles);

        return back()->with('success', 'Roles actualizados exitosamente.');
    }

    /**
     * Activar/desactivar usuario
     */
    public function toggleStatus($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->update(['activo' => !$usuario->activo]);

        $estado = $usuario->activo ? 'activado' : 'desactivado';
        return back()->with('success', "Usuario {$estado} exitosamente.");
    }
}
