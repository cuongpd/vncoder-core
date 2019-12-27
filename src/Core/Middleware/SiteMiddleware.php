<?php

namespace VnCoder\Core\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class SiteMiddleware
{
    public function handle($request, Closure $next)
    {
        if(! Auth::check()){
            return redirect()->route('auth.login');
        }
        return $next($request);
    }
}