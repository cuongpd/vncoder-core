<!DOCTYPE html>
<html lang="vi-VN">
<head>
    @include('admin::includes.page_begin')
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-dark side-scroll page-header-fixed">
        <nav id="sidebar" aria-label="Main Navigation">@include('admin::includes.menu')</nav>
        <header id="page-header">@include('admin::includes.header')</header>
        <main id="main-container">
            <div class="bg-body-light content">
                <div class="content content-full">
                    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                        <h1 class="flex-sm-fill h3 my-2">{{$metaData->title}} <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">{{$metaData->description}}</small></h1>
                        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                            @stack('menu')
                        </nav>
                    </div>
                </div>
            </div>
            <div class="content">@yield('content')</div>
        </main>
        <footer id="page-footer" class="bg-body-light">@include('admin::includes.footer')</footer>
    </div>
    @include('admin::includes.page_end')
</body>
</html>