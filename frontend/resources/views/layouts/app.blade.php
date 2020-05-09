<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}" />
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
        <title>pWire - @yield('title')</title>
    </head>
    <body>
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="/">
                    <img src="/img/logo.svg" width="112" height="28" alt="pWire Logo">
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="pwireNavigationBar">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="pwireNavigationBar" class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>

                    @auth
                        <a class="navbar-item">
                            Event Log
                        </a>

                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">
                                Settings
                            </a>

                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{route('edit_user', Auth::user())}}">
                                    User Settings
                                </a>
                                <a class="navbar-item">
                                    Plattform Settings
                                </a>
                            </div>
                        </div>
                        <a class="navbar-item" href="/create_sensor">
                            Add Sensor
                         </a>
                    @endauth
                </div>

                <div class="navbar-end">
                    @auth
                        <div class="navbar-item">
                            {{ __('Welcome')}} {{ Auth::user()->name }}
                        </div>
                    @endauth
                    <div class="navbar-item">
                        <div class="buttons">
                            @guest
                                <a class="button is-primary" href="/login">
                                    Log in
                                </a>
                            @endguest
                            @auth
                                <form action="/logout" method="POST">
                                    @csrf
                                    <input type="submit" class="button is-light" value="Log out"/>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div id="app">
            <div class="container">
                @if (session('success'))
                    @foreach (session('success') as $key => $message)
                        <div class="notification is-success" role="alert">
                            {{ $message }}
                        </div>
                    @endforeach
                @endif
                @if (session('warning'))
                    @foreach (session('warning') as $key => $message)
                        <div class="notification is-warning" role="alert">
                            {{ $message }}
                        </div>
                    @endforeach
                @endif
                @if (session('error'))
                    @foreach (session('error') as $key => $message)
                        <div class="notification is-danger" role="alert">
                            {{ $message }}
                        </div>
                    @endforeach
                @endif
                @if (session('info'))
                    @foreach (session('info') as $key => $message)
                        <div class="notification is-info" role="alert">
                            {{ $message }}
                        </div>
                    @endforeach
                @endif
            </div>

            @yield('content')
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
