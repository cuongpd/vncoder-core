<form action="{{route('auth.register')}}" class="panel-body" method="post">
    {!! csrf_field() !!}
    <div class="form-group @error('name') has-error @enderror ">
        <label for="name">Họ và tên:</label>
        <input class="form-control @error('name') parsley-error @enderror" type="text" id="name" name="name" placeholder="Vui lòng nhập tên của bạn!" required="" value="{{old('name')}}">
        @error('name')
        <span class="text-warning"><i class="fa fa-warning"></i> {{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="email">Địa chỉ Email:</label>
        <input class="form-control @error('email') parsley-error @enderror" type="email" id="email" name="email" required="" placeholder="Địa chỉ Email dùng để đăng nhập" value="{{old('email')}}">
        @error('email')
        <span class="text-warning"><i class="fa fa-warning"></i> {{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <input class="form-control @error('password') parsley-error @enderror" type="password" required="" name="password" id="password" placeholder="Nhập mật khẩu đăng nhập">
        @error('password')
        <span class="text-warning"><i class="fa fa-warning"></i> {{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="password">Nhập lại mật khẩu:</label>
        <input class="form-control" type="password" id="password-confirm" name="password_confirmation" placeholder="Nhập lại mật khẩu" value="{{old('password_confirmation')}}">
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox checkbox-info">
            <input type="checkbox" class="custom-control-input" id="checkbox-signup" checked="checked" disabled="disabled">
            <label class="custom-control-label" for="checkbox-signup">Tôi đã đọc và đồng ý với các <a href="javascript: void(0);" class="text-dark">điều khoản và chính sách</a> của hệ thống</label>
        </div>
    </div>
    <div class="form-group mb-0 text-center">
        <button class="btn btn-danger btn-block" type="submit"> Đăng kí tài khoản </button>
    </div>
</form>


@push('menu')
    <a class="btn-block-option" href="{{route('auth.login')}}" title="Đăng nhập vào hệ thống">
        <i class="fa fa-user-check"></i> Đăng nhập
    </a>
@endpush