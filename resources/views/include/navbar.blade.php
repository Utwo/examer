@if(Auth::check())
    @if(Auth::user()->role == 'teacher')
        @include('include.navbar_admin')
    @else
        @include('include.navbar_student')
    @endif
@endif