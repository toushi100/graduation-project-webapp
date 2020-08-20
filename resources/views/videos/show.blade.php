@extends('layouts.app')
@section('content')
<div class="container flex-grow-1">
    <div class="container" style = "padding: 0px">
        <br>
        {!! Form::open(['action'=>['VideoController@search',$video->id], 'method'=>'POST'])!!}
        <div class=" form-group d-flex">
            {{Form::label('','')}}
            {{Form::text('object','',['class'=>'form-control','style'=>'width: 83%', 'placeholder'=>'Search For Video'])}}
            {{Form::submit('Submit',['class'=>'btn btn-primary','style'=>'margin: auto 5px'])}}
            {!!Form::close()!!}
            <button class="btn btn-default" onclick="setCurTime({{$result}})" type="button">Go to object</button>
        </div>
    </div>
    <video id="my-video" width="100%"   controls>
        <source src="{{route('renderVideo',$video->id)}}" type="video/mp4">
        Your browser does not support the video tag
    </video>
    <div class="container">
        <h3>{{$video->name}}</h3>
            @if(!Auth::guest())
                @if(Auth::user()->id == $video->user_id)
                    {!!Form::open(['action'=>['VideoController@destroy',$video->id], 'method'=>'POST', 'class'=>'pull-right'])!!}
                    {{Form::hidden('_method','DELETE')}}
                    {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
        {!!Form::close()!!}
                @endif
            @endif
        <div class="container">
            <p>{{$video->description}}</p>
        </div>
    </div>
</div>

@endsection