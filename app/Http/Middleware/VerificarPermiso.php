<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarPermiso
{
    public function handle(Request $request, Closure $next, $permiso)
    {
        if (!$request->user()) {  // 👈 Usa $request->user()
            return redirect()->route('login');
        }

        if (!$request->user()->tienePermiso($permiso)) {  // 👈 Usa $request->user()
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
