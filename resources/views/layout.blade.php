<!doctype html>
<html>
<head>
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/base.min.css') }}" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<header class="navbar navbar-default navbar-custom">
    <div class="container">
        <div class="navbar-header">
            <a href="{{route('profile')}}" class="navbar-brand">Examiner</a>
        </div>
        @if(Auth::check())
            <nav>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">{{Auth::user()->name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('logout')}}">log out</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
</header>
@include('include.notification')

<main class="container">
    @yield('content')
</main>
<footer class="footer text-center">
    <small>&lt;&gt; with &hearts; by <a href="http://www.utwo.ro"
                                        title="design and development"
                                        target="_blank">Utwo</a>
    </small>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{{ asset('js/main.min.js') }}"></script>
</body>
</html>