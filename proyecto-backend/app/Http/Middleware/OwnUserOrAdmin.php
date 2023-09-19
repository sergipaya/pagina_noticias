<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnUserOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $editableUser = $request->route('user');
        if ($editableUser->id === Auth::id()) {
            return $next($request);
        }

        $user = $request->user();
        $roles = $user->roles;
        foreach ($roles as $role) {
            if ($role->name === 'admin') {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Sólo el propio usuario o un administrador' .
            'puede ejecutar esta acción.'], 403);
    }
}
