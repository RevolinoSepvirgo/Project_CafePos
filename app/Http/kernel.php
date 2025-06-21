<?php


namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\Authenticate;


class Kernel extends HttpKernel
{
    // ...existing code...

    protected $routeMiddleware = [
        // bawaan Laravel
        'auth' => \App\Http\Middleware\Authenticate::class,
        // middleware buatanmu
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];

    // ...existing code...
}
