@extends('layout')

@section('title', 'Login | Examiner')

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h2 class="text-center">Login</h2>

            <form method="post" action="{{route('post_login')}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" placeholder="pmir1541" type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary btn-block" type="submit">Log in</button>
                </div>
            </form>
        </div>
    </div>
@endsection
