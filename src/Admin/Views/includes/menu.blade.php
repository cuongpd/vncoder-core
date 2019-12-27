<div class="content-header bg-white-5">
    <a class="font-w600 text-dual" href="{{url('/')}}">
        <i class="fa fa-rocket text-danger"></i>
        <span class="smini-hide"><span class="font-w700 font-size-h5">VNCODER</span> <span class="font-w400 small pull-right">1.2</span></span>
    </a>
</div>

<div class="content-side content-side-full">
    <ul class="nav-main">
        <li class="nav-main-item">
            <a class="nav-main-link" href="{{url('/')}}">
                <i class="nav-main-link-icon fa fa-tachometer-alt"></i>
                <span class="nav-main-link-name">Dashboard</span>
            </a>
        </li>
        <li class="nav-main-heading">User Interface</li>
        @if($backendMenu)
            @foreach($backendMenu as $menu)
                <li class="nav-main-item">
                    @if($menu['subMenu'])
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="javascript: void(0);" title="{{$menu['name']}}">
                            <i class="nav-main-link-icon fa {{$menu['icon']}}"></i>
                            <span class="nav-main-link-name">{{$menu['name']}}</span>
                        </a>
                        <ul class="nav-main-submenu">
                            @foreach($menu['subMenu'] as $item)
                                <li><a href="{{$item['link']}}" title="{{$item['name']}}" class="nav-main-link"><span class="nav-main-link-name">{{$item['name']}}</span></a></li>
                            @endforeach
                        </ul>
                    @else
                        <a class="nav-main-link" href="{{$menu['link']}}">
                            <i class="nav-main-link-icon fa {{$menu['icon']}}"></i>
                            <span class="nav-main-link-name">{{$menu['name']}}</span>
                        </a>
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
</div>
@push('footer')