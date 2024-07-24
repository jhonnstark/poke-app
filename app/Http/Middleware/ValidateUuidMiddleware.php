<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class ValidateUuidMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uuid = $request->header('X-Request-ID', '');

        if (!Uuid::isValid($uuid)) {
            return response()->json(['error' => 'Invalid UUID provided.'], 400);
        }

        return $next($request);
    }
}
