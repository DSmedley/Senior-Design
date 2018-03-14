<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="adjust-nav">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <span><img src="/scanner.png" / style="width:32px; height:32px;"></span>
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <span class="logout-spn" >
                    <a href="{{ route('admin.logout') }}" style="color:#fff;">LOGOUT</a>  
                </span>
            </div>
        </div>
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="{{Request::is('admin') ? 'active-link' : ''}}">
                        <a href="{{ route('admin.dashboard') }}" ><i class="fa fa-desktop"></i>Dashboard</a>
                    </li>
                    <li class="{{Request::is('admin/settings') ? 'active-link' : ''}}">
                        <a href="{{ route('admin.settings') }}"><i class="fas fa-cog"></i>Site Settings</a>
                    </li>
                    <li class="{{Request::is('admin/users') ? 'active-link' : ''}}">
                        <a href="{{ route('admin.users') }}"><i class="fas fa-users"></i>Manage Users</a>
                    </li>
                    <li>
                        <a href="{{ route('welcome') }}"><i class="fab fa-cloudscale"></i>{{ config('app.name', 'Laravel') }}</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="page-wrapper" >
            <div id="page-inner">
            @yield('content')
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="row">
            <div class="col-lg-12" >
                &copy;  2018 {{ config('app.name', 'Laravel') }}
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    @yield('javascript')
</body>
</html>
