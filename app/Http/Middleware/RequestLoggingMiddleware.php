<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestLoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        Log::info('Request started', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $response = $next($request);

        $duration = microtime(true) - $startTime;
        
        Log::info('Request completed', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'status_code' => $response->getStatusCode(),
            'duration_ms' => round($duration * 1000, 2),
            'user_id' => auth()->id(),
        ]);

        return $response;
    }
}
