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

        if (!$user || !in_array(strtolower($user->role), array_map('strtolower', $roles))) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
