<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <a href="index.html"><img src="{{ asset('/assets/images/icon.svg') }}" alt="Oculux Logo"
                class="img-fluid logo"><span>Oculux</span></a>
        <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i
                class="lnr lnr-menu icon-close"></i></button>
    </div>
    <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
                <img src="{{ asset('/assets/images/user.png') }}" class="user-photo" alt="User Profile Picture">
            </div>
            <div class="dropdown">
                <span>Welcome,</span> <br>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown">
                    <strong>
                        @php
                            if (Auth::check()) {
                                echo Auth::user()->last_name . ' ' . Auth::user()->first_name;
                            }
                        @endphp
                    </strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                    <li><a href="profile.html"><i class="icon-user"></i>My Profile</a></li>
                    {{-- <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                    <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li> --}}
                    {{-- <li class="divider"></li> --}}
                </ul>

            </div>
        </div>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">
                <li class="header">Main</li>
                <li class="sidebar-item"><a href="/admin"><i class="icon-speedometer"></i><span>Dashboard</span></a></li>
                <li class="sidebar-item"><a href="/users"><i class="icon-user"></i><span>Users</span></a></li>
                <li class="sidebar-item"><a href="/departments"><i class="icon-grid"></i><span>Departments</span></a></li>
                <li class="sidebar-item"><a href="/donors"><i class="icon-users"></i><span>Donors</span></a></li>
                <li class="sidebar-item"><a href="events.html"><i class="icon-calendar"></i><span>Events</span></a></li>
                <li class="sidebar-item"><a href="report.html"><i class="icon-bar-chart"></i><span>Report</span></a></li>
                <li class="sidebar-item"><a href="activities.html"><i class="icon-equalizer"></i><span>Audit Trails</span></a></li>
                <li class="sidebar-item"><a href="accounts.html"><i class="icon-wallet"></i><span>Inventory</span></a></li>
            </ul>
        </nav>
    </div>
</div>
