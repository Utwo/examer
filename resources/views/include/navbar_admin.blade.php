<nav>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="{{route('admin')}}">Admin</a></li>
        <li><a href="{{route('get_subject')}}">Subjects</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
               aria-expanded="false">
                <img class="profile-image img-circle" width="26" src="{{ auth()->user()->image }}">
                {{Auth::user()->name}} <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{route('logout')}}">log out</a></li>
            </ul>
        </li>
    </ul>
</nav>