<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema core') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    
    <!-- Favicon -->
     
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125424716-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-125424716-2');
    </script>
</head>

<body class="bg-gradient-primary min-vh-100 d-flex justify-content-center align-items-center">

@yield('main-content')

<!-- Scripts -->
<style>
    .bg-gradient-primary {
        background: url(../img/app-bg4.jpg) !important;
        background-position: cover !important;
        background-size: cover !important;
    }
    .btn-primary {
        color: #fff !important;
        background-color: black !important;
        border-color: black !important;
    }
</style>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('js/core/utils/Translator.js') }}"></script>
</body>
</html>
