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
    <link href="{{ asset('css/jquery.circliful.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/bootstrap-slider.css') }}" rel="stylesheet" type="text/css" />
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
                        <span><img title="{{ config('app.name', 'Laravel') }}" style="width:32px; height:32px;" src='/scanner.gif'></span>
                        {{ config('app.name', 'Laravel') }}
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
                        <li class="{{Request::is('/') ? 'active' : ''}}"><a href="{{ route('welcome') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true"><i class="fas fa-chart-pie"></i> Analyze <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('analyze') }}"><i class="fas fa-user-circle"> Twitter User </i></a>
                                </li>
                                <li>
                                    <a href="{{ route('hashtag') }}"><i class="fas fa-hashtag"> Hashtag </i></a>
                                </li>
                                <li>
                                    <a href="{{ route('cashtag') }}"><i class="fas fa-dollar-sign"> Cashtag </i></a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{Request::is('compare') ? 'active' : ''}}"><a href="{{ route('compare') }}"><i class="fas fa-users"></i> Compare</a></li>
                        <li class="{{Request::is('about') ? 'active' : ''}}"><a href="{{ route('about') }}"><i class="fas fa-info"></i> About</a></li>
                        @guest
                            <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                            <li><a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    <img title="profile image" class="img-circle" style="width:20px; height:20px;" src='/uploads/avatars/{{ Auth::user()->avatar }}'>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    @auth
                                    <li>
                                        <a href="{{ route('user') }}"><i class="fas fa-user"> Profile </i></a>
                                    </li>
                                    @endauth
                                    @auth('admin')
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-user"> Admin </i></a>
                                    </li>
                                    @endauth
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"> Logout</i>
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
                        <p class="copyright text-muted small">Copyright &copy; Personality Scanner 2018. All Rights Reserved</p>
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
    <script src="{{ asset('js/jquery.circliful.js') }}"></script>
    <script src="{{ asset('js/Chart.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/bootstrap-slider.js') }}"></script>
    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5ab19ecbb338830013655046&product=inline-share-buttons' async='async'></script>
    @yield('javascript')
</body>
</html>
