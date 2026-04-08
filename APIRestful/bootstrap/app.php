<?php

use App\Http\Middleware\SignatureMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Http\Request;
use App\Exceptions\ApiExceptionHandler;

use Laravel\Passport\Http\Middleware\CheckToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Alias para Passport
        $middleware->alias([
            'client.credentials' => CheckToken::class,
        ]);

        // 2. Middleware  personalizado
        $middleware->append(SignatureMiddleware::class);

        // 3. Excepciones de CSRF
        $middleware->validateCsrfTokens(
            except: [
                'api/*',
                'users',
                'users/*',
                'buyers/*',
                'sellers/*',
                'categories',
                'categories/*',
                'products/*',
                'transactions/*',
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            return (new ApiExceptionHandler)->handle($e, $request);
        });
    })
    ->create();
