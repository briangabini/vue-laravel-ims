<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

//        enable only during development
        $middleware->validateCsrfTokens(
            except: ['**/*']
        );

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // report ignored exceptions
        $exceptions->stopIgnoring([
            ValidationException::class,
        ]);

        $exceptions->report(function (ValidationException $e) {
            $request = request();

            $context = [
                'url'      => $request->fullUrl(),
                'user_id'  => $request->user()?->id,
                'ip'       => $request->ip(),
                'errors'   => $e->errors(),
            ];

            Log::channel('warning')->warning('Validation Failed', $context);

            return false; // stop propagating the exception
        });
    })->create();
