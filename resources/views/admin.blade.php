@extends('layout')

@section('title', Auth::user()->name . ' | Examiner')

@section('content')
    <table class="table table-bordered table-hover table-project">
        <thead>
        <tr>
            <th>User</th>
            <th>Submited project</th>
            <th>Submited grades</th>
            <th>Media</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->Project->count()}} / {{env('MAX_PROJECT_UPLOAD')}}</td>
                <td>{{$user->Grade->count()}} / {{env('MAX_GRADE_ADD')}}</td>
                <td>{{$user->Media}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection