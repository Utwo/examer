@foreach ($errors->all() as $error)
    <p class="alert alert-danger alert-custom text-center">{{ $error }}</p>
@endforeach

@if(Session::has('notification'))
    <p class="alert alert-info alert-custom text-center">{{Session::get('notification')}}</p>
@endif