<?php

namespace VnCoder\Admin\Auth;

use Barryvdh\Debugbar\Facade as Debugbar;
use VnCoder\Core\Controllers\BaseController;
use VnCoder\Core\Auth\VnAuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    use VnAuthenticatesUsers;

    protected $auth_title = '';
    protected $redirectTo = '/';

    public function Login_Form(){
        $this->auth_title = 'Đăng nhập trên hệ thống';
        return $this->views('login');
    }

    public function Register_Form(){
        $this->auth_title = 'Đăng kí tài khoản';
        return $this->views('register');
    }

    public function Logout_Permission_Action(Request $request){
        $this->guard()->logout();
        $request->session()->invalidate();
        flash_message('Tài khoản của bạn không được phép truy cập hệ thống!');
        return $this->redirectLoginUrl();
    }

    protected function views($bladeAuth)
    {
        $data = [
            'auth_title' => $this->auth_title,
            'auth_template' => 'admin::auth.'.$bladeAuth,
        ];
        Debugbar::disable(); // Turn off debugbar
        return view('admin::templates.auth', $data);
    }

}
