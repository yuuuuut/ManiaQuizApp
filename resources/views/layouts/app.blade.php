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
        footer-color
        navbar
        shadow p-3"
    >
        <a class="navbar-brand ml-3" style="font-size: 26px; color: white;" href="/">
            StayHomeLog
        </a>
        <div class="position-absolute" style="right: 50px;">
            @if(Auth::check())
                <div class="dropdown dropleft">
                    <div
                        class="dropdown-toggle"
                        data-toggle="dropdown"
                    >
                        <img class="icon-radius" src="{{ Auth::user()->avatar }}">
                    </div>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="button-nonestyle">ログアウト</button>
                            </form>
                        </a>
                    </div>
                </div>
            @else
                <a href="{{ route('googleLogin') }}">ログイン</a>
            @endif
        </div>
    </nav>
    <footer class="
        fixed-bottom
        bd-highlight
    ">
        <nav class="
            footer-color
            d-flex
            justify-content-around
            navbar
            navbar-expand-md
        ">
            <div class="d-flex flex-column">
                <a href="/">
                    <i class="fas fa-home fa-2x footer-icon--color"></i>
                </a>
                <div class="footer-icon--text">ホーム</div>
            </div>
            <a href="/"><i class="fas fa-user fa-2x"></i></a>
            <a href="/"><i class="fas fa-trophy fa-2x"></i></a>
            <a href="/"><i class="fas fa-eye fa-2x"></i></a>
            <a href="/" ><i class="far fa-grin-stars fa-2x"></i></a>
        </nav>
    </footer>
    <div id="app">
        <div class="body-height">
            @yield('content')
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
