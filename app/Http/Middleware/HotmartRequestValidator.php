<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HotmartRequestValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hottok != config('hotmart.hottok')) {
            $logMessage = sprintf('Unauthorized access attempt to (%s) from ip: %s', $request->fullUrl(), $request->ip());
            Log::warning($logMessage, $request->toArray());

            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
