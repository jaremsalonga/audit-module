<?php

namespace App\Http\Middleware;

use App\Events\AuditLogEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Closure;

class LogActions
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        event(new AuditLogEvent(Auth::user()->toArray(), $response));
        return $response;
    }
}