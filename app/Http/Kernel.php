<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

// Laravel core middleware
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\SetLocale;

// App middleware
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\IsAdmin;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            SetLocale::class, 
        ],
    ];

    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'is_admin' => IsAdmin::class,
        'verified' => EnsureEmailIsVerified::class,
    ];
    protected $commands = [
    \App\Console\Commands\TestMail::class,
    
];
}
