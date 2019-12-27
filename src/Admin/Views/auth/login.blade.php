<form action="{{route('auth.login')}}" class="panel-body" method="post">
    {!! csrf_field() !!}
    <div class="form-group">
        <label for="email">Địa chỉ Email:</label>
        <input class="form-control @error('email') parsley-error @enderror" type="email" id="email" name="email" required="" placeholder="Địa chỉ Email dùng để đăng nhập" value="{{old('email')}}">
        @error('email')
        <span class="text-warning"><i class="fa fa-warning"></i> {{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <input class="form-control @error('password') parsley-error @enderror" type="password" required="" name="password" id="password" placeholder="Nhập mật khẩu đăng nhập" value="{{old('password')}}">
        @error('password')
        <span class="text-warning"><i class="fa fa-warning"></i> {{ $message }}</span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <div class="custom-control custom-checkbox checkbox-info">
            <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked="checked" disabled="disabled">
            <label class="custom-control-label" for="checkbox-signin">Remember me</label>
        </div>
    </div>

    <div class="form-group mb-0 text-center">
        <button class="btn btn-danger btn-block" type="submit"> Đăng nhập </button>
    </div>
</form>

@push('menu')
    <a class="btn-block-option font-size-sm" href="javascript:void(0)"><i class="fa fa-fingerprint"></i> Quên mật khẩu?</a>
    <a class="btn-block-option" href="{{route('auth.register')}}" title="Tạo tài khoản mới">
        <i class="fa fa-user-secret"></i> Đăng kí
    </a>
@endpush