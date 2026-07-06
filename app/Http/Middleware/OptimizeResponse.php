<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Set security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        if (
            ! $request->isMethodCacheable()
            || $request->user()
            || $request->is('admin/*', 'login', 'register', 'profile*', 'blog/*', 'medias/*', 'portfolio/*')
        ) {
            $response->headers->set('Cache-Control', 'no-store, private');
        } elseif ($request->getPathInfo() === '/') {
            $response->headers->set('Cache-Control', 'public, max-age=3600, s-maxage=86400');
        } else {
            $response->headers->set('Cache-Control', 'public, max-age=3600');
        }

        return $response;
    }
}
