<?php

namespace App\Http;

use App\Http\Middleware\HandleCors;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \App\Http\Middleware\HandleCors::class,
    ];

    protected $middlewareGroups = [
        'api' => [
            \App\Http\Middleware\HandleCors::class, // Ajoutez ici le middleware CORS
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
    ];
}
