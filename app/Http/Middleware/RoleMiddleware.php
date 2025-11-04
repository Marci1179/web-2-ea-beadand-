<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // Használat: ->middleware('role:user,admin') vagy csak 'role:admin'
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error','Előbb jelentkezz be!');
        }

        $user = auth()->user();
        if (empty($roles) || in_array($user->role, $roles, true)) {
            return $next($request);
        }

        abort(403, 'Nincs jogosultságod ehhez az oldalhoz.');
    }
}
