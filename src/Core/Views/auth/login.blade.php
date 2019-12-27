<form action="{{route('auth.login')}}" class="panel-body" method="post">
    {!! csrf_field() !!}
    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="test@example.com" class="form-control @error('email') parsley-error @enderror" required aria-describedby="parsley-email">
        @error('email')
        <ul class="parsley-errors-list filled" id="parsley-email"><li class="parsley-required">{{ $message }}</li></ul>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password"  class="form-control @error('password') parsley-error @enderror" required aria-describedby="parsley-password">
        @error('password')
        <ul class="parsley-errors-list filled" id="parsley-password"><li class="parsley-required">{{ $message }}</li></ul>
        @enderror
    </div>
    <div class="form-group mb-3">
        <div class="custom-control custom-checkbox checkbox-info">
            <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked="checked" disabled="disabled">
            <label class="custom-control-label" for="checkbox-signin">Remember me</label>
        </div>
    </div>

    <div class="form-group mb-0 text-center">
        <button class="btn btn-danger btn-block" type="submit"> Log In </button>
    </div>
</form>

<div class="text-center">
    <h5 class="mt-3 text-muted">hoặc Đăng nhập qua</h5>
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
    <p> <a href="{{route('auth.register')}}" class="text-muted ml-1">Forgot your password?</a></p>
    <p class="text-muted">Don't have an account? <a href="{{route('auth.register')}}" class="text-muted ml-1"><b class="font-weight-semibold">Sign Up</b></a></p>
@endpush