<?php

namespace VnCoder\Admin\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BackendMiddleware
{
    public function handle($request, Closure $next)
    {
        if(! Auth::check()){
            session(['current_url' => @$_SERVER['SCRIPT_URI'] ]);
            flash('Bạn cần đăng nhập để truy cập vào hệ thống!');
            return redirect()->route('auth.login');
        }

        $segments = $request->segments();
        $controller = isset($segments[0]) ? $segments[0] : 'dashboard';
        $method = isset($segments[1]) ? $segments[1] : "index";
        $user = Auth::user();
        if($user->role_id > 0){
            // User chưa phân quyền

            if($user->role_id > 1){ // Root User : RoleId = 1
                $current_role = $controller."_".$method;
                $permission = $user->permission;
            }

            return $next($request);
        }else{
            flash('Tài khoản của bạn không có quyền truy cập hệ thống!');
            return redirect()->route('auth.logout-permission');
        }

        return $next($request);
    }
}
