<?php

return [
    'path' => 'admin',
    'domain' => null,
    'auth' => [
        'guard' => 'web',
        'pages' => [
            'login' => \Filament\Http\Livewire\Auth\Login::class,
        ],
    ],
    'middleware' => [
        'auth' => [
            \Filament\Http\Middleware\Authenticate::class,
        ],
        'base' => [
            \Filament\Http\Middleware\DispatchServingFilamentEvent::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // \Filament\Http\Middleware\MirrorConfigToModelAttributes::class,
        ],
    ],
    'brand' => 'PetCare Admin',
    'database' => [
        'connection' => null,
        'table_prefix' => 'filament_',
    ],
];
