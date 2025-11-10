<nav class="navbar top-navbar"
    @if (auth()->user()->role === 'donor') style="width: 100%; padding-lef: 30px; padding-right: 30px;" @endif>
    <div class="container-fluid">

        <div class="navbar-left">
            <div class="navbar-btn">
                {{-- <a href="index.html"><img src="../assets/images/icon.svg" alt="Oculux Logo" class="img-fluid logo"></a> --}}
                <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
            </div>
            @if (auth()->user()->role === 'donor')
            @endif
            <div class="d-flex align-items-center justify-content-center">
                <img id="side-logo" style="height: 50px; width: 50px; margin-left: 30px"
                    src="{{ isset($systemSettings) ? asset('storage/' . $systemSettings?->navbar_logo) : asset('/assets/images/bd-logo.png') }}"
                    alt="Biliran Province Logo" class="img-fluid logo">
                <h6 class="ml-2 nav-title">Province of Biliran</h6>
            </div>
        </div>

        @if (auth()->user()->role !== 'donor')
            <div class="navbar-right">
                <div id="navbar-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                <i class="icon-bell"></i>
                                <span class="notification-dot bg-azura">{{count($nofications)}}</span>
                            </a>
                            <ul class="dropdown-menu feeds_widget vivify fadeIn" style="left: -290px">
                                <li class="header blue">You have {{count($nofications)}} New Notifications</li>
                                @forelse ($nofications as $item)
                                    <li>
                                        <a href="javascript:void(0);">
                                            {!!$item->icon!!}
                                            <div class="feeds-body">
                                                <h6 class="title text-info">{{$item->title}} <small
                                                        class="float-right text-muted">{{$item->created_at->diffForHumans()}}</small></h6>
                                                        </small></h4>
                                                <small>{{$item->message}}</small>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li>
                                        <a href="javascript:void(0);">
                                            No New Notifications
                                        </a>
                                    </li>
                                @endforelse
                            </ul>
                        </li>
                        <li><a href="#" class="icon-menu" id="logout-link"><i class="icon-power"></i></a></li>
                    </ul>
                </div>
            </div>
        @else
            ()
            <div class="navbar-right" style="margin-left: 20px">
                <div id="navbar-menu">
                    <ul class="nav navbar-nav">
                        <li><a href="javascript:void(0);"
                                style="font-weight: bold; text-transform: capitalize; font-size: medium;"
                                class="search_toggle icon-menu" title="Search Result">
                                {{ auth()->user()->last_name . ' ' . auth()->user()->first_name }}

                            </a></li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                <i class="icon-bell"></i>
                                <span class="notification-dot bg-azura">4</span>
                            </a>
                            <ul class="dropdown-menu feeds_widget vivify fadeIn" style="left: -290px">
                                <li class="header blue">You have 4 New Notifications</li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="feeds-left bg-red"><i class="fa fa-check"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="title text-danger">Issue Fixed <small
                                                    class="float-right text-muted">9:10
                                                    AM</small></h4>
                                            <small>WE have fix all Design bug with Responsive</small>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="feeds-left bg-info"><i class="fa fa-user"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="title text-info">New User <small
                                                    class="float-right text-muted">9:15
                                                    AM</small></h4>
                                            <small>I feel great! Thanks team</small>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="feeds-left bg-orange"><i class="fa fa-question-circle"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="title text-warning">Server Warning <small
                                                    class="float-right text-muted">9:17 AM</small></h4>
                                            <small>Your connection is not private</small>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="feeds-left bg-green"><i class="fa fa-thumbs-o-up"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="title text-success">2 New Feedback <small
                                                    class="float-right text-muted">9:22 AM</small></h4>
                                            <small>It will give a smart finishing to your site</small>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#" class="icon-menu" id="logout-link"><i class="icon-power"></i></a></li>
                    </ul>
                </div>
            </div>
        @endif
    </div>
    <div class="progress-container">
        <div class="progress-bar" id="myBar"></div>
    </div>
</nav>
