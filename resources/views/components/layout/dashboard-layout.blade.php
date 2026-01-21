@include('components.layout.header')
@include('components.layout.sidebar')
<div class="main-content">
  <!-- Top Navbar inside main content -->
  @include('components.layout.navbar')

  <!-- Main Content Area -->
  <div class="p-6">
    @yield('content')
  </div>
</div>
@include('components.layout.footer')

<style>
  .main-content {
    margin-left: 16rem; /* Adjust based on your sidebar width */
    min-height: 100vh;
    background-color: #f9fafb;
    transition: margin-left 0.3s ease;
  }
  
  @media (max-width: 768px) {
    .main-content {
      margin-left: 0;
    }
  }
  
  /* Make the navbar sticky inside the main content */
  .main-content nav {
    position: sticky;
    top: 0;
    z-index: 10;
  }
</style>