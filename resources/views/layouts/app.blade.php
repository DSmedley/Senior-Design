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
    <link href="{{ asset('css/creative.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/jquery.circliful.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/vendor/bootstrap-slider.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top topnav">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed navbar-fixed-top" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ route('welcome') }}">
                        <span><img title="{{ config('app.name', 'Laravel') }}" style="width:200px; height:50px;" src='/chirpreport.svg'></span>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li class="{{Request::is('/') ? 'active' : ''}}"><a href="{{ route('welcome') }}"><span class="fas fa-home"></span> Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true"><span class="fas fa-chart-pie"></span> Analyze <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('analyze') }}"><span class="fas fa-user-circle"> Twitter User </span></a>
                                </li>
                                <li>
                                    <a href="{{ route('hashtag') }}"><span class="fas fa-hashtag"> Hashtag </span></a>
                                </li>
                                <li>
                                    <a href="{{ route('cashtag') }}"><span class="fas fa-dollar-sign"> Cashtag </span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{Request::is('compare') ? 'active' : ''}}"><a href="{{ route('compare') }}"><span class="fas fa-users"></span> Compare</a></li>
                        <li class="{{Request::is('about') ? 'active' : ''}}"><a href="{{ route('about') }}"><span class="fas fa-info"></span> About</a></li>
                        @guest
                            <li><a href="{{ route('login') }}"><span class="fas fa-sign-in-alt"></span> Login</a></li>
                            <li><a href="{{ route('register') }}"><span class="fas fa-user-plus"></span> Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    <img title="profile image" class="img-circle" style="width:20px; height:20px;" src='/uploads/avatars/{{ Auth::user()->avatar }}'>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    @auth
                                    <li>
                                        <a href="{{ route('user') }}"><span class="fas fa-user"> Profile </span></a>
                                    </li>
                                    @endauth
                                    @auth('admin')
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}"><span class="fas fa-user"> Admin </span></a>
                                    </li>
                                    @endauth
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <span class="fas fa-sign-out-alt"> Logout</span>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-inline">
                            <li>
                                <a href="{{ route('welcome') }}">Home</a>
                            </li>
                            <li class="footer-menu-divider">&sdot;</li>
                            <li>
                                <a href="{{ route('about') }}">About</a>
                            </li>
                            <li class="footer-menu-divider">&sdot;</li>
                            <li>
                                <a href="{{ route('admin.login') }}">Admin</a>
                            </li>
                        </ul>
                        <p class="copyright text-muted small">Copyright &copy; {{ config('app.name', 'Laravel') }} 2018. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-69914420-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-69914420-2');
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery.circliful.js') }}"></script>
    <script src="{{ asset('js/vendor/Chart.js') }}"></script>
    <script src="{{ asset('js/vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap-slider.js') }}"></script>
    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5ab19ecbb338830013655046&product=inline-share-buttons' async='async'></script>
    <script src="{{ asset('js/loading.js') }}"></script>
    @yield('javascript')
</body>
</html>
