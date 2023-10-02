<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->headers->get('Locale'), ['en', 'ka'])) {
            if ($request->headers->get('Locale')) {
                \Illuminate\Support\Facades\App::setLocale($request->headers->get('Locale'));
            }

            return $next($request);
        }
        abort(403, 'Language is not Supported');
    }
}
