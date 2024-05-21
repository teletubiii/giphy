<?php

namespace App\Http\Middleware;

use App\Models\ServiceInteraction;
use Closure;
use Illuminate\Http\Request;

class LogServiceInteraction
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $responseData = json_decode($response->getContent(), true);
        $responseUserId = $responseData['data']['user_id']?? null;

        $logData = [
            'user_id' => auth()->user() ? auth()->user()->id : $responseUserId,
            'service' => $request->route()->getName(),
            'request_body' => $request->getContent(),
            'http_status_code' => http_response_code(),
            'response_body' => $response->getContent(),
            'ip_address' => $request->ip(),
        ];

        ServiceInteraction::create($logData);

        return $response;
    }
}
