@extends('layout')

@section('title', Auth::user()->name . ' | Examiner')

@section('content')
    @foreach($subjects->chunk(3) as $three_subject)
        <div class="row">
            @foreach($three_subject as $subject)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail text-center">
                        <h5>{{$subject->name}}</h5>
                        <hr>
                        <div class="caption">
                            <form class="form-inline" method="POST" action="{{route('update_subject')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="active" value="0">
                                <input type="hidden" name="id" value="{{ $subject->id }}">
                                <input type="checkbox" name="active" value="1" {{$subject->active ? 'checked':''}}>Active
                                <button class="btn btn-primary btn-sm" type="submit">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
@endsection