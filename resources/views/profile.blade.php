@extends('layout')

@section('title', Auth::user()->name . ' | Examiner')

@section('content')
    @include('include.add_project')
    <table class="table table-bordered table-hover table-project">
        <thead>
        <tr>
            <th>Project name</th>
            @for($i=1; $i <= config('settings.max_project_upload'); $i++)
                <th>Note {{$i}}</th>
            @endfor
            <th>Media</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($user->Project as $project)
            <tr class="warning table-project-own">
                <td><a title="download project"
                       href="{{route('download_project', ['id' => $project->id])}}">{{$project->name}}
                        .{{$project->extension}}</a></td>
                @include('include.grade')
                <td class="text-center">
                    <form action="{{route('delete_project')}}" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="{{$project->id}}">
                        <button class="btn btn-sm btn-danger">Delete project</button>
                    </form>
                </td>
            </tr>
        @endforeach
        <tr class="text-center text-info info">
            <td>------</td>
            @for($i=1; $i <= config('settings.max_project_upload'); $i++)
                <td>------</td>
            @endfor
            <td>------</td>
            <td>------</td>
        </tr>
        @foreach($projects as $project)
            <tr class="table-project-other">
                <td><a title="download project"
                       href="{{route('download_project', ['id' => $project->id])}}">{{$project->name}}
                        .{{$project->extension}}</a></td>
                @include('include.grade')
                <td class="form-hide text-center">
                    @if($project->Grade->count() < config('settings.max_grade_add')
                    && $project->Grade->where('user_id', Auth::id())->count() == 0
                    && $user->Grade->count() < config('settings.max_grade_add'))
                        <div class="form-grade container-fluid text-left">
                            <div class="col-md-4">
                                <p><a title="download project"
                                      href="{{route('download_project', ['id' => $project->id])}}">{{$project->name}}
                                        .{{$project->extension}}</a></p>
                            </div>
                            <div class="col-md-6">
                                <form class="form-inline form-group-sm" method="post" action="{{route('add_grade')}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="project_id" value="{{$project->id}}">
                                    <select class="form-control" name="grade" required>
                                        <option value=""></option>
                                        <option value="1">1 - S</option>
                                        <option value="2">2 - B</option>
                                        <option value="3">3 - FB</option>
                                    </select>
                                    <button class="btn btn-primary btn-sm" type="submit">Add grade</button>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <a class="js-form-close btn btn-primary btn-sm" href="#"><span
                                            aria-hidden="true">&times;</span></a>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-default js-form-show" href="#">Add grade</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection