@extends('layouts.app')
@section('content')
<div class="container flex-grow-1">
    <video id="my-video" width="100%"   controls>
        <source src="{{route('renderVideo',$video->id)}}" type="video/mp4">
        Your browser does not support the video tag
    </video>
    <div class="container">
        <h3>{{$video->name}}</h3>
        <div class="container">
            <p>{{$video->description}}</p>
        </div>
    </div>
</div>

@endsection