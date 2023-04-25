<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect('/login');
        }
        // Verificar si el usuario tiene el rol de administrador
        if (!$request->hasRole('admin')) {
            return redirect('/tauler'); // canviar a respuesta con json
        }

        // Si el usuario está autenticado y es un administrador, dejarlo pasar
        return $next($request);
    }
}