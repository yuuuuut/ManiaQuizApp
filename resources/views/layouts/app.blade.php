<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>

<body>
    <nav class="
        navbar
        fixed-top
        footer-color
        shadow p-3"
    >
        <a
            class="navbar-brand ml-3"
            style="font-size: 26px; color: white;"
            href="/"
        >
            マニアッQ
        </a>
        <div
            class="position-absolute"
            style="right: 50px;"
        >
            @if(Auth::check())
                <div class="dropdown dropleft">
                    <div
                        class="dropdown-toggle"
                        data-toggle="dropdown"
                    >
                        <img
                            class="icon-radius"
                            src="{{ Auth::user()->avatar }}"
                        >
                    </div>
                    <div
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton"
                    >
                        <a
                            class="dropdown-item"
                            href="{{ route('category.index') }}"
                        >
                            カテゴリー一覧
                        </a>
                        <div class="dropdown-divider"></div>
                        <a
                            class="dropdown-item"
                            href="{{ route('user.show', Auth::id()) }}"
                        >
                            マイページ
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="button-nonestyle">ログアウト</button>
                            </form>
                        </a>
                    </div>
                </div>
            @else
                <a
                    class="btn btn-primary"
                    href="{{ route('googleLogin') }}"
                >
                    ログイン
                </a>
            @endif
        </div>
    </nav>
    <div id="app">
        <div style="padding-top: 100px;">
            @yield('content')
        </div>
    </div>
    <!--script src="{{ asset('js/app.js') }}"></script -->
</body>
</html>
