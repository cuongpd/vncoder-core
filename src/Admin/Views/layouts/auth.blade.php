<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{$auth_title}}</title>
    <meta content="{{$auth_title}} - VnCoder CMS" name="description" />
    <meta content="Cuong Pham" name="author" />
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{url('images/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&display=swap&subset=vietnamese" rel="stylesheet">
    <link href="{{url('css/oneui.min.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page-container">
    <main id="main-container">
        <div class="bg-image" style="background-image: url('{{url('images/auth-vn.jpg')}}');">
            <div class="hero-static bg-white-50">
                <div class="content">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-4">

                            <div class="block block-themed block-fx-shadow mt-5">
                                <div class="block-header">
                                    <h3 class="block-title">{{$auth_title}}</h3>
                                    <div class="block-options">
                                        @stack('menu')
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="p-sm-3 px-lg-4 py-lg-5">
                                        <h1 class="mb-2">{{$auth_title}}</h1>
                                        @if (session('message'))
                                            <p>{{session('message')}}</p>
                                        @endif
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content content-full font-size-sm text-muted text-center">
                    <strong>VnCoder CMS 1.2</strong> &copy; <span data-toggle="year-copy"></span>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="{{url('js/core.min.js')}}"></script>
<script src="{{url('js/app.min.js')}}"></script>
</body>
</html>