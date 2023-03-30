<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureJsonResponseMiddleware
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}