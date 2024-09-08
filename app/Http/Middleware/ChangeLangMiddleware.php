<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeLangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = request()->header('lang');
        if (!empty($lang)) {
            app()->setLocale($lang);
        } else {
            app()->setLocale('en'); // Default to English if no language header is provided
        }
        return $next($request);
    }
}
