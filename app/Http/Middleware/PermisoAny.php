<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermisoAny
{
    public function handle(Request $request, Closure $next, ...$permisos)
    {
        // Verificar si el usuario está autenticado
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Verificar si tiene AL MENOS UNO de los permisos
        foreach ($permisos as $permiso) {
            if ($request->user()->tienePermiso($permiso)) {
                return $next($request);
            }
        }

        // Si no tiene ningún permiso, error 403
        abort(403, 'No tienes permiso para acceder a esta sección. Necesitas al menos uno de estos permisos: ' . implode(', ', $permisos));
    }
}
