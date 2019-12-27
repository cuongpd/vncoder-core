<?php

namespace VnCoder\Admin\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle($request, Closure $next){
        if( Auth::check()){
            Auth::logout();
        }

        return $next($request);
    }

}