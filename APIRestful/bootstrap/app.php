<?php

use App\Http\Middleware\SignatureMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Http\Request;            // <--- ¿Está este?
use App\Exceptions\ApiExceptionHandler;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting
    (
        web: __DIR__.'/../routes/web.php',

        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware)
    {
        $middleware->append(SignatureMiddleware::class);

        $middleware->preventRequestForgery(
            except: [
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
    ->withExceptions(function (Exceptions $exceptions)
    {
        $exceptions->render(function (Throwable $e, Request $request)
        {
            return (new ApiExceptionHandler)->handle($e, $request);
        });
    })
    ->create();
