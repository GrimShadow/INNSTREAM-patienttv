<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Handle preflight OPTIONS requests
        if ($request->isMethod('OPTIONS')) {
            return $this->handlePreflightRequest($request);
        }

        $response = $next($request);

        // Always add CORS headers - be permissive for development
        $this->addCorsHeaders($response, $request);

        return $response;
    }

    /**
     * Handle preflight OPTIONS requests
     */
    private function handlePreflightRequest(Request $request): Response
    {
        $response = response('', 200);
        $this->addCorsHeaders($response, $request);

        return $response;
    }

    /**
     * Add CORS headers to response
     */
    private function addCorsHeaders(Response $response, Request $request): void
    {
        $origin = $request->header('Origin');

        // For global deployment - allow all origins
        // This is necessary for Tizen devices connecting from various hotel networks worldwide
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, X-CSRF-TOKEN, Origin, X-Forwarded-For, X-Forwarded-Proto, X-Forwarded-Host');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Max-Age', '86400'); // 24 hours
        $response->headers->set('Access-Control-Expose-Headers', 'Content-Length, X-JSON');
    }

    /**
     * Get allowed origins from configuration
     */
    private function getAllowedOrigins(): array
    {
        $origins = config('cors.allowed_origins', []);

        // Add common development origins
        $devOrigins = [
            'http://localhost:3000',
            'http://localhost:8080',
            'http://127.0.0.1:3000',
            'http://127.0.0.1:8080',
            'http://localhost:8000',
            'http://127.0.0.1:8000',
        ];

        // Add Tizen TV origins (common IP ranges for hotel networks)
        $tizenOrigins = [
            'http://192.168.1.1:8000',
            'http://192.168.68.56:8000',
            'http://10.0.0.1:8000',
            'http://172.16.0.1:8000',
        ];

        return array_merge($origins, $devOrigins, $tizenOrigins);
    }

    /**
     * Get allowed origin patterns from configuration
     */
    private function getAllowedPatterns(): array
    {
        return config('cors.allowed_origins_patterns', []);
    }

    /**
     * Check if origin matches any of the allowed patterns
     */
    private function matchesPattern(string $origin, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $origin)) {
                return true;
            }
        }

        return false;
    }
}
