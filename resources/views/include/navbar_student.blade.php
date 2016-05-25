<nav class="collapse navbar-collapse">
    <form class="navbar-form navbar-left" method="get" action="{{route('profile')}}">
        <div class="form-group">
            <select name="subject" class="form-control">
                @foreach($user->StudentSubject as $subject)
                    @if($subject->name == request()->get('subject'))
                        <option value="{{$subject->name}}" selected="selected">{{$subject->name}}</option>
                    @else
                        <option value="{{$subject->name}}">{{$subject->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <button class="btn btn-default" type="submit">Filter</button>
    </form>
    <ul class="nav navbar-nav navbar-right">
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