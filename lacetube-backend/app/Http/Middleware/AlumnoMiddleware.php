<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfessorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Verificar si el usuario tiene el rol de administrador
        if (auth()->user()->rol !== 'admin' && auth()->user()->rol !== 'professor' && auth()->user()->rol !== 'almuno' ) {
            return redirect('/home'); // canviar a respuesta con json
        }

        // Si el usuario está autenticado y es un administrador, dejarlo pasar
        return $next($request);
    }
}