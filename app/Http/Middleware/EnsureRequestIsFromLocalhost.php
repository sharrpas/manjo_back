<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRequestIsFromLocalhost
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = ['127.0.0.1', '::1', 'localhost'];

        if (!in_array($request->ip(), $allowedIps)) {
            abort(403, 'Access denied - localhost only');
        }

        return $next($request);
    }
}
