@extends('layout')

@section('title', Auth::user()->name . ' | Examiner')

@section('content')
    <div class="container">
        <div class="content">
            <div class="title">{{$user->name}} profile</div>
            @if($user->Project->count() < 3)
                <form method="post" action="{{route('add_project')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="file" name="upload" accept="file_extension|.pdf,.doc,.docx,.txt,.rtf,.ppt" required>
                    <button type="submit">Upload</button>
                </form>
            @endif

            <table class="table table-striped table-hover ">
                <tr>
                    <td>Project name</td>
                    <td>Note 1</td>
                    <td>Note 2</td>
                    <td>Note 3</td>
                    <td>Give grade</td>
                </tr>
                @foreach($user->Project as $project)
                    <tr>
                        <td><a href="{{route('download_project', ['id' => $project->id])}}">{{$project->name}}</a></td>
                        @foreach($project->Grade as $grade)
                            <td>{{ $grade->grade }}</td>
                        @endforeach
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                </tr>
                @foreach($projects as $project)
                    <tr>
                        <td><a href="{{route('download_project', ['id' => $project->id])}}">{{$project->name}}</a></td>
                        <?php $i = 0; ?>
                        @foreach($project->Grade as $grade)
                            @if($i < 3)
                                <td>{{ $grade->grade }}</td>
                            @endif
                            <?php $i++; ?>
                        @endforeach
                        <td>
                            @if($project->Grade->count() < 3 && $project->Grade->where('user_id', Auth::id())->count() == 0)
                                <form method="post" action="{{route('add_grade')}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="project_id" value="{{$project->id}}">
                                    <select name="grade" required>
                                        <option value=""></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <button type="submit">Add grade</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection