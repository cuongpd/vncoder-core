<?php

namespace VnCoder\Core\Auth;

use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use VnCoder\Core\Models\VnUsers;

trait VnAuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    public function Login_Submit(Request $request){
        $rules = [
            'email' => ['required','string','email'],
            'password' => ['required', 'string'],
        ];

        $error_messages = [
            'required' => 'Trường :attribute không được bỏ trống!',
            'string' => 'Trường :attribute chỉ được chứa kí tự!',
            'email' => 'Trường :attribute phải là email!'
        ];
        $this->validate($request, $rules, $error_messages);

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $email = $request->post('email');
        $password = $request->post('password');

        if ($this->guard()->attempt(['email' => $email , 'password' => $password] , true)) {
            flash_message('Đăng nhập thành công! Chào mừng bạn quay trở lại website!');
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            return redirect()->intended($this->redirectPath());
        }
        $this->incrementLoginAttempts($request);
        $this->sendFailedLoginResponse($request);
        return false;
    }

    public function Register_Submit(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:__users'],
            'password' => ['required', 'string', 'min:6', 'max:20', 'confirmed'],
        ];

        $error_messages = [
            'required' => 'Trường :attribute không được bỏ trống!',
            'string' => 'Trường :attribute chỉ được chứa kí tự!',
            'email' => 'Trường :attribute phải là email!',
            'confirmed' => 'Mật khẩu bạn nhập chưa trùng khớp!',
            'unique' => 'Email đã tồn tại trên hệ thống, vui lòng kiểm tra lại!',
            'min' => 'Độ dài :attribute tối thiểu phải từ :min kí tự',
            'max' => 'Độ dài :attribute tối đa đến :max kí tự',
        ];

        $this->validate($request, $rules, $error_messages);

        $name = $request->post('name');
        $email = $request->post('email');
        $password = $request->post('password');
        $userId = VnUsers::createUser($name , $email , $password);
        flash_message('Tài khoản của bạn đã được tạo thành công! Vui lòng đăng nhập để sử dụng!');
        $this->guard()->loginUsingId($userId);
        return $this->redirectLoginUrl();
    }

    public function Logout_Action(Request $request){
        $this->guard()->logout();
        $request->session()->invalidate();
        flash_message('Bạn đã đăng xuất khỏi phiên làm việc!');
        return $this->redirectLoginUrl();
    }

    public function username()
    {
        return 'email';
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => 'Thông tin tài khoản không có trên hệ thống',
        ]);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            'email' => 'Bạn đã đăng nhập không chính xác quá nhiều lần. Vui lòng đợi sau '.$seconds.' giây nữa để thực hiện lại'
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    public function redirectLoginUrl()
    {
        if (method_exists($this, 'redirectToLogin')) {
            return redirect()->to($this->redirectToLogin());
        }

        return redirect()->route('auth.login');
    }
}