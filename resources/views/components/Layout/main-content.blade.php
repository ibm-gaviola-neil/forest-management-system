@include('components.Layout.main-header')
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <div class="bar4"></div>
            <div class="bar5"></div>
        </div>
    </div>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div> 

    <div class="wrapper"></div>

    @include('components.Layout.main-navbar')
    @if (auth()->user()->role !== 'donor') 
        @include('components.Layout.main-sidebar')
    @endif

    <div id="main-content"  @if (auth()->user()->role === 'donor') style="width: 100%; margin-top: 80px;" @endif>
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

@include('components.Layout.main-footer')
