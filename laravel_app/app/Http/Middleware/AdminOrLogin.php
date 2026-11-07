<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Para los atajos del equipo (/soyflojo): si no hay sesión, manda al ingreso de
 * administrador y vuelve a la página pedida; si la sesión no es de admin, 403.
 */
class AdminOrLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            redirect()->setIntendedUrl($request->fullUrl());

            return redirect()->route('admin.login');
        }
        abort_unless($user->isAdmin(), 403, 'No tienes permisos para acceder a esta sección.');

        return $next($request);
    }
}
