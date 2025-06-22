<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class SupportMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('support')->check()) {
            return Redirect()->route('support.login');
        }
        return $next($request);
    }
}
