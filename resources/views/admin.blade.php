@extends('layout')

@section('title', Auth::user()->name . ' | Examiner')

@section('content')
    <table class="table table-bordered table-hover table-project">
        <thead>
        <tr>
            <th>User</th>
            <th>Submited project</th>
            <th>Submited grades</th>
            <th>Recieved grades</th>
            <th>Media</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->Project->count()}} / {{config('settings.max_project_upload')}}</td>
                <td>{{$user->Grade->count()}} / {{config('settings.max_grade_add')}}</td>
                <td>
                    @foreach($user->Project as $project)
                        {{$project->Grade->pluck('grade')}}
                    @endforeach
                </td>
                <td>{{$user->Media}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection