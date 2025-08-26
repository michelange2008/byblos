<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->email !== 'michelange@wanadoo.fr') {
            return redirect()->route('login'); // redirection vers la page de login
        }

        return $next($request);
    }
}
