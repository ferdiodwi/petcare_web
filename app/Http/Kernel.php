<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\ServeImages;

class Kernel extends HttpKernel
{
    // ... kode lainnya

    protected $middlewareGroups = [
        'web' => [
            // Middleware untuk web
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
        'serve.images' => ServeImages::class,
    ];
}
