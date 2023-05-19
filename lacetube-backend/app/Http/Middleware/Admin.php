<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect('/login');
        }
        // Check wether user is admin or not.
        if (!$request->hasRole('admin')) {
            return redirect('/tauler'); // canviar a respuesta con json
        }

        // If user is logged in and admin, let it pass.
        return $next($request);
    }
}
