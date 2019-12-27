<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{$auth_title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{$auth_title}} - VnCoder CMS" name="description" />
    <meta content="Cuong Pham" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{url('images/favicon.ico')}}">
    <link href="{{$auth_css_url}}font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{$auth_css_url}}bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{$auth_css_url}}app.css" rel="stylesheet" type="text/css" />
</head>
<body class="authentication-bg authentication-bg-pattern">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <a href="index">
                                    <span><img src="{{url('images/logo.png')}}" height="30"></span>
                                </a>
                                <p class="text-muted mb-4 mt-3"></p>
                            </div>
                            @if (session('message'))
                                <div class="alert alert-warning" role="alert">
                                    <i class="fa fa-warning mr-2"></i><strong>Thông báo!</strong><br>{{session('message')}}!
                                </div>
                            @endif
                            <h5 class="auth-title">{{$auth_title}}</h5>
                            @includeIf($auth_template)
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            @stack('footer')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
