<div class="panel panel-primary">
    <div class="panel-heading">
        @if(! is_null($warning_message))
            <p class="panel-title">{{$warning_message}}</p>
        @endif
    </div>
    @if($user->Project->count() < config('settings.max_project_upload'))
        <div class="panel-body">
            <form class="form-inline" method="post" action="{{route('add_project')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input class="form-control" id="name" type="text" name="name" placeholder="Project name"
                       required>
                <input class="form-control" type="file" name="upload"
                       accept="file_extension|.pdf,.doc,.docx,.txt,.rtf,.ppt" required>
                <button class="btn btn-primary" type="submit">Upload project</button>
            </form>
        </div>
    @endif
</div>