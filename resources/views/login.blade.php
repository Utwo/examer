@extends('layout')

@section('title', 'Login | Examiner')

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <a class="btn btn-default" href="http://localhost:3999/#/scopes?client_id=123456&redirect_uri=http://examiner.dev:8000/login_callback&response_type=code&scope=basic_user_read,advanced_user_read&state=123">Login in with UBB</a>
        </div>
    </div>
@endsection
