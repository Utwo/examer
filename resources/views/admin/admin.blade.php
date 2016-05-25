@extends('layout')

@section('title', Auth::user()->name . ' | Examiner')

@section('content')
    @foreach($subjects as $subject)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5 class="text-muted">{{$subject->name}}</h5>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover table-project">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Submited project</th>
                        <th>Submited grades</th>
                        <th>Received grades</th>
                        <th>Media</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subject->StudentUser as $user)
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
            </div>
            </div>
    @endforeach
@endsection