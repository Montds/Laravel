<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SignatureMiddleware
{

    public function handle(Request $request, Closure $next , $header="NameHeaderPersonalizado"): Response
    {
        $response = $next($request);
        $response->headers->set($header, config('app.name'));
        return $response;
    }
}
