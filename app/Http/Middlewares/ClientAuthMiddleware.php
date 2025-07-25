<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiClient;

class ClientAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->route()?->uri(); // e.g., 'api/v1/users'
        $routePrefix = explode('/', $uri)[0]; // returns 'api'

        $key = $request->header('X-API-KEY');
        if($routePrefix === 'api')
        {
            if ((!$key || !ApiClient::where('api_key', $key)->exists())) {
                return response()->json(['error' => 'X-API-KEY is missing or invalid'], 401);
            }
        }

        return $next($request);
    }
}
