@php
  if (Auth::check()) {
    echo '<script>window.location.replace("admin/")</script>';
  }
@endphp
<!doctype html>
<html lang="en">

<head>
    <title>Blood Registry System</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description"
        content="Oculux Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
    <meta name="author" content="GetBootstrap, design by: puffintheme.com">

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/animate-css/vivify.min.css') }}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('/html/assets/css/site.min.css') }}">

    <style>
        img{
            width: 200px;
            height: 200px;
        }

        .body{
            width: 100%;
            border-radius: 20px;
        }

        .card{
            width: 120% !important;
            height: 100%;
        }
    </style>

</head>

<body class="theme-cyan font-montserrat light_version">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <div class="bar4"></div>
            <div class="bar5"></div>
        </div>
    </div>

    <div class="pattern">
        <span class="red"></span>
        <span class="indigo"></span>
        <span class="blue"></span>
        <span class="green"></span>
        <span class="orange"></span>
    </div>

    <div class="auth-main particles_js">
        <div class="auth_div vivify popIn">
            {{-- <div class="auth_brand">
            <a class="navbar-brand" href="javascript:void(0);"><img src="../assets/images/icon.svg" width="30" height="30" class="d-inline-block align-top mr-2" alt="">Oculux</a>
        </div> --}}
            <div class="card">
                <div class="body">
                    <img src="{{ asset('./assets/images/logo-removebg-preview.png') }}" alt="">
                    <p class="lead">Login to your account</p>
                    <form class="form-auth-small m-t-20" action="/login" method="post" novalidate>
                        @csrf
                        <div class="form-group mb-4">
                            <label for="signin-email" class="control-label sr-only">Username</label>
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="form-control @error('username') parsley-error @enderror round"
                                @error('username') data-parsley-id="29" @enderror id="signin-email"
                                placeholder="Username" novalidate>
                            @error('username')
                                <p class="text-sm text-danger text-italized" style="text-align: left !important; font-size: 11px;">
                                    {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="signin-pass" class="control-label sr-only">Username</label>
                            <input type="password" name="password" value="{{ old('password') }}"
                                class="form-control @error('password') parsley-error @enderror round"
                                @error('password') data-parsley-id="29" @enderror id="signin-pass"
                                placeholder="Password" novalidate>
                            @error('password')
                                <p class="text-sm text-danger text-italized" style="text-align: left !important; font-size: 11px;">
                                    {{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-round btn-block mb-4">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="particles-js"></div>
    </div>
    <!-- END WRAPPER -->

    <script src="{{ asset('/html/assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('/html/assets/bundles/vendorscripts.bundle.js') }}"></script>
    <script src="{{ asset('/html/assets/bundles/mainscripts.bundle.js') }}"></script>
</body>

</html>
