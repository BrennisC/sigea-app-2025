<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Mostrar formulario de edición de perfil
     */
    public function edit()
    {
        $user = auth()->user();
        return view('participant.profile.edit', compact('user'));
    }

    /**
     * Actualizar perfil
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'documento_identidad' => 'nullable|string|max:50|unique:users,documento_identidad,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'documento_identidad' => $request->documento_identidad,
        ];

        // Si se proporciona nueva contraseña
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Perfil actualizado exitosamente.');
    }
}
