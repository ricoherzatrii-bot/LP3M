<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (method_exists($response, 'header')) {
            $csp = "default-src 'self'; " .
                   "script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdnjs.cloudflare.com https://translate.googleapis.com https://translate.google.com; " .
                   "style-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdnjs.cloudflare.com https://fonts.googleapis.com https://translate.googleapis.com https://translate.google.com; " .
                   "img-src 'self' data: https: blob:; " .
                   "font-src 'self' https://cdnjs.cloudflare.com https://fonts.gstatic.com data:; " .
                   "connect-src 'self' https://translate.googleapis.com; " .
                   "frame-src 'self' https://www.youtube.com; " .
                   "object-src 'none'; " .
                   "base-uri 'self';";
                   
            $response->header('Content-Security-Policy', $csp);
        }

        return $response;
    }
}
