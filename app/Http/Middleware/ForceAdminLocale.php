<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Force la locale française sur l'ensemble de l'application.
 */
class ForceAdminLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale('fr');

        return $next($request);
    }
}
