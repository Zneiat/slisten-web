<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="referrer" content="always">
    <meta name="renderer" content="webkit">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('title')
        <title>@yield('title') - {{ config('app.name', 'Slisten') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <!-- Styles -->
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slisten.css') }}" rel="stylesheet">
    <link href="{{ asset('css/material-design-iconic-font.min.css') }}" rel="stylesheet">
    @stack('styles')

    <!--[if lte IE 9]><script>window.location.href='/static/upgrade-browser.html';</script><![endif]-->
</head>
<body>
    <!-- Loading Layer -->
    <div class="loading-layer" style="display: none;">
        <div class="loading-spinner"><svg viewBox="25 25 50 50"><circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
        <div class="loading-layer-text"></div>
    </div>

    <div class="app-body-wrap">
        <nav class="navbar navbar-app navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Slisten') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li class="{{ nav_route_active_class('home') }}"><a href="{{ route('home') }}">首页</a></li>
                        <li class="{{ nav_route_active_class('user_write') }}"><a href="{{ route('user_write') }}">倾诉</a></li>
                        <li class="{{ nav_route_active_class('user_home') }}"><a href="{{ route('user_home') }}">答复</a></li>
                        <li class=""><a href="#">说明</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li class="{{ nav_route_active_class('login') }}"><a href="{{ route('login') }}">登录</a></li>
                            <li class="{{ nav_route_active_class('register') }}"><a href="{{ route('register') }}">注册</a></li>
                        @else
                            <li class="{{ nav_route_active_class('user_home') }}"><a href="{{ route('user_home') }}">{{ Auth::user()->name }}</a></li>
                            <li>
                                <a href="#" onclick="document.getElementById('logout-form').submit();return false;">
                                    注销
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/module.js') }}"></script>
    <script src="{{ asset('js/hotkeys.js') }}"></script>
    <script src="{{ asset('js/uploader.js') }}"></script>
    <script src="{{ asset('js/slisten.js') }}"></script>
    @stack('scripts')
</body>
</html>
