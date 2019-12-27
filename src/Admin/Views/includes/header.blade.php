<div class="content-header">
    <div class="d-flex align-items-center">
        <button type="button" class="btn btn-sm btn-dual mr-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle"><i class="fa fa-fw fa-bars"></i></button>
        <button type="button" class="btn btn-sm btn-dual mr-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle"><i class="fa fa-fw fa-bars"></i></button>
        <button type="button" class="btn btn-sm btn-dual d-sm-none" data-toggle="layout" data-action="header_search_on">
            <i class="fa fa-search"></i>
        </button>
        <form class="d-none d-sm-inline-block" method="PUT">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control form-control-alt"  placeholder="Search..." name="_query" value="{{$_query}}" id="page-header-search-input2" name="page-header-search-input2">
                <div class="input-group-append"><span class="input-group-text bg-body border-0"><i class="fa fa-search"></i></span></div>
            </div>
        </form>
    </div>

    <div class="d-flex align-items-center">
        <div class="dropdown d-inline-block ml-2">
            <button type="button" class="btn btn-sm btn-dual" id="debugbar-ajax">
                <i class="fa fa-bug noti-icon"></i>  Debug: <b>{{$vn_debugbar}}</b>
            </button>
        </div>
        <div class="dropdown d-inline-block ml-2">
            <button type="button" class="btn btn-sm btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded" src="{{$user_info->avatar_url}}" alt="{{$user_info->name}}" style="width: 18px;">
                <span class="d-none d-sm-inline-block ml-1">{{$user_info->name}}</span>
                <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="page-header-user-dropdown">
                <div class="p-3 text-center bg-primary">
                    <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{$user_info->avatar_url}}" alt="">
                </div>
                <div class="p-2">
                    <h5 class="dropdown-header text-uppercase">User Options</h5>
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="be_pages_generic_inbox.html">
                        <span>Inbox</span>
                        <span>
                            <span class="badge badge-pill badge-primary">3</span><i class="fa fa-bolt ml-1"></i>
                        </span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="be_pages_generic_profile.html">
                        <span>Profile</span>
                        <span>
                            <span class="badge badge-pill badge-success">1</span>
                            <i class="fa fa-user-alt ml-1"></i>
                        </span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                        <span>Settings</span><i class="fa fa-cog"></i>
                    </a>
                    <div role="separator" class="dropdown-divider"></div>
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{route('auth.logout')}}">
                        <span>Log Out</span><i class="fa fa-terminal ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="dropdown d-inline-block ml-2">
            <button type="button" class="btn btn-sm btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell text-success"></i>
                <span class="badge badge-primary badge-pill small">6</span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="page-header-notifications-dropdown">
                <div class="p-2 bg-primary text-center">
                    <h5 class="dropdown-header text-uppercase text-white">Notifications</h5>
                </div>
                <ul class="nav-items mb-0">
                    <li>
                        <a class="text-dark media py-2" href="javascript:void(0)">
                            <div class="mr-2 ml-3">
                                <i class="fa fa-fw fa-check-circle text-success"></i>
                            </div>
                            <div class="media-body pr-2">
                                <div class="font-w600">You have a new follower</div>
                                <small class="text-muted">15 min ago</small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="text-dark media py-2" href="javascript:void(0)">
                            <div class="mr-2 ml-3">
                                <i class="fa fa-fw fa-plus-circle text-info"></i>
                            </div>
                            <div class="media-body pr-2">
                                <div class="font-w600">1 new sale, keep it up</div>
                                <small class="text-muted">22 min ago</small>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="p-2 border-top">
                    <a class="btn btn-sm btn-light btn-block text-center" href="javascript:void(0)">
                        <i class="fa fa-fw fa-arrow-down mr-1"></i> Load More..
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="page-header-search" class="overlay-header bg-white">
    <div class="content-header">
        <form class="w-100" method="PUT">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <button type="button" class="btn btn-danger" data-toggle="layout" data-action="header_search_off">
                        <i class="fa fa-fw fa-times-circle"></i>
                    </button>
                </div>
                <input type="text" class="form-control" placeholder="Search..." name="_query" value="{{$_query}}" id="page-header-search-input" name="page-header-search-input">
            </div>
        </form>
    </div>
</div>
<div id="page-header-loader" class="overlay-header bg-white">
    <div class="content-header">
        <div class="w-100 text-center">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>
    </div>
</div>