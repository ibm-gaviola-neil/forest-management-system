@include('components.layout.header')
    @include('components.layout.sidebar')
    <div class="main-content">
        @yield('content')
    </div>
@include('components.layout.footer')