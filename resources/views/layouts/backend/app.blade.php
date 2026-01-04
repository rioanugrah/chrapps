<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="https://is3.cloudhost.id/eagleinformatika/Logo%20Eagle%20Media%20Informatika.webp">
    {{-- <link href="{{ url('/') }}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/preloader.min.css" type="text/css" />
    <link href="{{ url('/') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    @yield('css')
</head>
<body class="pace-done" data-bs-theme="dark" data-topbar="dark" data-sidebar="dark">
    <div id="layout-wrapper">
        @include('layouts.backend.header')
        @include('layouts.backend.sidenav')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                @include('layouts.backend.footer')
            </div>
        </div>
    </div>
</body>

    <!-- JAVASCRIPT -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}

    <script src="{{ url('/') }}/assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ url('/') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/') }}/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ url('/') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ url('/') }}/assets/libs/node-waves/waves.min.js"></script>
    <script src="{{ url('/') }}/assets/libs/feather-icons/feather.min.js"></script>
    <!-- pace js -->
    <script src="{{ url('/') }}/assets/libs/pace-js/pace.min.js"></script>

    <!-- apexcharts -->
    {{-- <script src="{{ url('/') }}/assets/libs/apexcharts/apexcharts.min.js"></script> --}}

    <!-- Plugins js-->
    {{-- <script src="{{ url('/') }}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{ url('/') }}/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script> --}}
    <!-- dashboard init -->
    {{-- <script src="{{ url('/') }}/assets/js/pages/dashboard.init.js"></script> --}}

    <script src="{{ url('/') }}/assets/js/app.js"></script>

    @yield('js')
</html>
