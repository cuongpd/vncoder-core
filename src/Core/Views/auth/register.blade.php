<form action="{{route('auth.register')}}" class="panel-body" method="post">
    @csrf
    <div class="form-group">
        <label for="name">Họ và tên</label>
        <input class="form-control @error('name') parsley-error @enderror" type="text" id="name" name="name" placeholder="Enter your name" required value="{{ old('name') }}">
        @error('name')
        <ul class="parsley-errors-list" id="parsley-name"><li class="parsley-required">{{ $message }}</li></ul>
        @enderror
    </div>
    <div class="form-group">
        <label for="name">Email:</label>
        <input class="form-control @error('email') parsley-error @enderror" type="email" id="email" name="email" placeholder="Email của bạn" required value="{{ old('email') }}">
        @error('email')
        <ul class="parsley-errors-list" id="parsley-email"><li class="parsley-required">{{ $message }}</li></ul>
        @enderror
    </div>
    <div class="form-group">
        <label for="name">Mật khẩu</label>
        <input class="form-control @error('password') parsley-error @enderror" type="password" id="password" name="password" placeholder="Mật khẩu" required autocomplete="new-password">
        @error('password')
        <ul class="parsley-errors-list" id="parsley-password"><li class="parsley-required">{{ $message }}</li></ul>
        @enderror
    </div>
    <div class="form-group">
        <label for="name">Xác nhận lại Mật khẩu</label>
        <input class="form-control" type="password" id="password-confirm" name="password_confirmation" autocomplete="new-password" required placeholder="Xác nhận lại Mật khẩu" >
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox checkbox-info">
            <input type="checkbox" class="custom-control-input" id="checkbox-signup" checked="checked" disabled="disabled">
            <label class="custom-control-label" for="checkbox-signup">Tôi đã đọc và đồng ý với các <a href="javascript: void(0);" class="text-dark">điều khoản và chính sách</a> của hệ thống</label>
        </div>
    </div>
    <div class="form-group mb-0 text-center">
        <button class="btn btn-danger btn-block" type="submit"> Sign Up </button>
    </div>
</form>

<div class="text-center">
    <h5 class="mt-3 text-muted">hoặc Đăng kí nhanh với</h5>
    <ul class="social-list list-inline mt-3 mb-0">
        <li class="list-inline-item">
            <a href="{{ route('auth.provider', ['provider' => 'facebook']) }}" class="social-list-item border-primary text-primary"><i class="fa fa-facebook"></i></a>
        </li>
        <li class="list-inline-item">
            <a href="{{ route('auth.provider', ['provider' => 'google']) }}" class="social-list-item border-danger text-danger"><i class="fa fa-google"></i></a>
        </li>
        <li class="list-inline-item">
            <a href="{{ route('auth.provider', ['provider' => 'github']) }}" class="social-list-item border-secondary text-secondary"><i class="fa fa-github"></i></a>
        </li>
    </ul>
</div>

@push('footer')
    <p class="text-muted">Already have account?  <a href="{{route('auth.login')}}" class="text-muted ml-1"><b class="font-weight-semibold">Sign In</b></a></p>
@endpush