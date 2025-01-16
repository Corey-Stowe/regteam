<!doctype html>
<html lang="en">

{{-- {{ dd(Auth::user()) }} --}}
<!-- Mirrored from themesdesign.in/webadmin/layouts/layouts-horizontal.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 15 Nov 2024 00:53:59 GMT -->
<head>

        <meta charset="utf-8" />
        <title>@yield('titile')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- plugin css -->
       <link href="{{  asset('assets/libs/jsvectormap/css/jsvectormap.min.css')    }}" rel="stylesheet" type="text/css" />


        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>
<body>
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="page-content">

    <div class="container-fluid">
        @yield('content')
    </div>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{  asset('assets/libs/metismenujs/metismenujs.min.js') }}"></script>
    <script src="{{  asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{  asset('assets/libs/eva-icons/eva.min.js') }}"></script>

    <!-- Vector map -->
    <script src="{{  asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{  asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{  asset('assets/js/app.js') }}"></script>

    </div>
</body>



<!-- Mirrored from themesdesign.in/webadmin/layouts/layouts-horizontal.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 15 Nov 2024 00:53:59 GMT -->
</html>
