<!doctype html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
          integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
          crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/base.min.css') }}" rel="stylesheet">
</head>
<body>

@include('notification')

<div class="container">
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a href="/" class="navbar-brand">Examiner</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{route('profile')}}">{{Auth::user()->name}}</a></li>
            </ul>
        </div>
    </div>
    <main>
        <div class="row">
            @yield('content')
        </div>
    </main>
    <footer>
        <small class="grid align-center">&lt;&gt; with &hearts; by <a href="http://www.utwo.ro"
                                                                      title="design and development" target="_blank">Utwo</a>
        </small>
    </footer>

</div>

</body>
</html>