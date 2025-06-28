<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Cek apakah user tidak login atau role tidak termasuk yang diizinkan
        if (!$user || !in_array($user->role, $roles)) {
            return abort(403, 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
