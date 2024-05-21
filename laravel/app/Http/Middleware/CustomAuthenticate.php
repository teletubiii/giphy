<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

class CustomAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUrl = parse_url(request()->path())['path'];

        if (!auth()->guard('api')->check()) {
            $allowedUrls = ['api/login', 'api/register', 'uml'];

            if (in_array($currentUrl, $allowedUrls)) {
                return $next($request);
            }

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
