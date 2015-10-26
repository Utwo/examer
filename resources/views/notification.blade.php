@foreach ($errors->all() as $error)
    <p class="notification notification--error">{{ $error }}</p>
@endforeach

@if(Session::has('notification'))
    <p class="notification notification--success">{{Session::get('notification')}}</p>
@endif