<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle(Request $request, Closure $next, ...$types)
    {
        $user = Auth::guard('usuarios')->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Convertir a string para comparación segura
        $userType = (string) $user->user_tipo;
        
        // Verificar si el tipo de usuario está en los tipos permitidos
        foreach ($types as $type) {
            if ($userType === (string) $type) {
                return $next($request);
            }
        }

        // Si no tiene permiso, mostrar error 403
        abort(403, 'No tienes permisos para acceder a esta página.');
    }
}