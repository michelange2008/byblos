<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'utilisateur est connecté et a l'email souhaité
        if (Auth::check() && Auth::user()->email === 'michelange@wanadoo.fr') {
            return $next($request);
        }

        // Sinon on renvoie une erreur 403
        abort(403, 'Accès refusé.');
    }
}
