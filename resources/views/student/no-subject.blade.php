@extends('layout')

@section('title', Auth::user()->name . ' | Examiner')

@section('content')
        <div class="container well">
            <h4 class="text-muted text-center">For the moment there are no subjects for you.</h4>
        </div>
@endsection