<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->query('api_key');

        if (!$apiKey) {
            return response()->json(['error' => 'API key is missing'], 401);
        }

        // Find the user with the given API key
        $user = User::where('api_key', $apiKey)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        // Authenticate the user
        auth()->login($user);
        return $next($request);
    }
}
