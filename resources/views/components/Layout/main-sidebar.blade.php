<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <a href="index.html"><img src="{{ asset('/assets/images/bd-logo.png') }}" alt="Oculux Logo"
                class="img-fluid logo"><span style="color: #fff">Blood Registry System</span></a>
        <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i
                class="lnr lnr-menu icon-close"></i></button>
    </div>
    <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
                <img style="height: 45px" src="{{ Auth::user()->profile_image ? asset('storage/'.$user_data->profile_image) : asset('/assets/images/user.jpg') }}" class="user-photo" alt="User Profile Picture">
            </div>
            <div class="dropdown">
                <span style="color: #fff">Welcome,</span> <br>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown" style="color: #fff">
                    <strong style="text-transform: capitalize">
                        @php
                            if (Auth::check()) {
                                echo Auth::user()->last_name . ' ' . Auth::user()->first_name;
                            }
                        @endphp
                    </strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                    <li><a href="/user/profile"><i class="icon-user"></i>My Profile</a></li>
                    {{-- <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                    <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li> --}}
                    {{-- <li class="divider"></li> --}}
                </ul>

            </div>
        </div>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">
                <li class="header" style="color: #fff">Main</li>
                <li class="sidebar-item no-anim"><a class="sidebar-link" href="/admin" style="font-weight: 500;"><i class="icon-speedometer"></i><span>Dashboard</span></a></li>
                <li class="sidebar-item no-anim"><a class="sidebar-link" href="/departments" style="font-weight: 500;"><i class="icon-grid"></i><span>Departments</span></a></li>
                <li class="sidebar-item no-anim"><a class="sidebar-link" href="/donors" style="font-weight: 500;"><i class="icon-users"></i><span>Donors</span></a></li>
                <li class="sidebar-item no-anim"><a class="sidebar-link" href="/patients" style="font-weight: 500;"><i class="icon-users"></i><span>Patients</span></a></li> 
                <li class="sidebar-item"><a class="sidebar-link" href="/events" style="font-weight: 500;"><i class="icon-calendar"></i><span>Events</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="/reports" style="font-weight: 500;"><i class="icon-bar-chart"></i><span>Report</span></a></li>
                @if (Auth::user()->role == 'general_admin' || Auth::user()->role == 'admin')  
                    <li class="sidebar-item"><a class="sidebar-link" href="/audit-trails" style="font-weight: 500;"><i class="icon-equalizer"></i><span>Audit Trails</span></a></li>
                @endif
                <li class="sidebar-item"><a class="sidebar-link" href="/inventory" style="font-weight: 500;"><i class="icon-wallet"></i><span>Inventory</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="/blood-issuance" style="font-weight: 500;"><i class=" icon-drawer "></i><span>Blood Issuance</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="/users" style="font-weight: 500;"><i class="icon-user"></i><span>Users</span></a></li>
            </ul>
        </nav>
    </div>
</div>
