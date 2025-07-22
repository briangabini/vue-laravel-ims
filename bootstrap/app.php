<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        App\Providers\EventServiceProvider::class,
    ])
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

        $middleware->alias([
            'role' => RoleMiddleware::class,
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

            Log::channel('security')->warning('Validation Failed', $context);

            return false; // stop propagating the exception
        });

        $exceptions->report(function (\Illuminate\Auth\Access\AuthorizationException $e) {
            $request = request();

            $context = [
                'url'      => $request->fullUrl(),
                'user_id'  => $request->user()?->id,
                'ip'       => $request->ip(),
                'action'   => $e->getMessage(),
                'resource' => $e->hasRessource() ? get_class($e->ressource()) : null,
                'resource_id' => $e->hasRessource() ? $e->ressource()->id : null,
            ];

            Log::channel('security')->warning('Access Control Failure', $context);

            return false; // stop propagating the exception
        });

        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return Inertia::render('errors/404', ['status' => $e->getStatusCode()])
                ->toResponse(request())
                ->setStatusCode($e->getStatusCode());
        });
    })

    ->create();
