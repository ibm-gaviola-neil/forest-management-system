<!doctype html>
<html lang="en">

<head>
<title>Blood Registery System | Home</title>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Oculux Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
<meta name="keywords" content="admin template, Oculux admin template, dashboard template, flat admin template, responsive admin template, web app, Light Dark version">
<meta name="author" content="GetBootstrap, design by: puffintheme.com">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{ asset('/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('/assets/css/popup.css')}}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/animate-css/vivify.min.css')}}">

<link rel="stylesheet" href="{{ asset('/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">

<link rel="stylesheet" href="{{ asset('/assets/vendor/c3/c3.min.css')}}"/>
<link rel="stylesheet" href="{{ asset('/assets/vendor/chartist/css/chartist.min.css')}}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css')}}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">

<link rel="stylesheet" href="{{ asset('/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css')}}">
<link rel="stylesheet" href="..{{ asset('/assets/vendor/summernote/dist/summernote.css') }}"/>

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset("/assets/vendor/dropify/css/dropify.min.css") }}">
<link rel="stylesheet" href="{{  asset('/html/assets/css/site.min.css')}}">

<link rel="stylesheet" href="{{ asset('/assets/vendor/c3/c3.min.css')}}"/>
<link rel="stylesheet" href="{{ asset('/assets/vendor/chartist/css/chartist.min.css')}}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css')}}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Bogle&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .nav-title{
        font-family: "BBH Sans Bogle", sans-serif;
        margin-top: 5px;
        font-weight: 400;
        letter-spacing: 2px;
        font-size: 19px;
    }

    .btn-primary {
        background-color: #5cb65f !important;
        border-color: #5cb65f !important;
    }

    .nav-item .nav-link.active {
        background-color: #5cb65f !important;
        border-color: #5cb65f !important;
        color: #fff !important;
    }

    .nav-item .nav-link:hover {
        background-color: #5cb65f !important;
        border-color: #5cb65f !important;
        color: #fff !important;
    }

    input {
        color: black !important;
    }
</style>
</head>
<body class="theme-cyan font-montserrat light_version">