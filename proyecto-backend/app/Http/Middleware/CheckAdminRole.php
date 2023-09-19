<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $roles = $user->roles;

        foreach ($roles as $role) {
            if ($role->name === 'admin') {
                return $next($request);
            }
        }
        return response()->json(['message' => 'Sólo un usuario administrador puede ejecutar esta acción'], 403);
    }
}
