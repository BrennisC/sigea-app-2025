<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'No autenticado');
        }

        // Verificar si el usuario tiene alguno de los roles especificados
        foreach ($roles as $rol) {
            if ($user->tieneRol($rol)) {
                return $next($request);
            }
        }

        abort(403, 'No tienes permiso para acceder a esta página');
    }
}
