@extends('layouts.app')
@section('content')
<div class="container flex-grow-1">

<div class="card my-3">
    <h2 id="videos-header" class="card-header pl-4">Videos</h2>
    @if(count($videos)>0)
    @foreach($videos as $video)
    <div class="card">
        <div class="row ml-1 my-1">
            <div class="col-sm-3">
                <img style="width:17em; height:10em" src="{{ asset('images/placeholder.png') }}">
            </div>
            <div class="col-sm-8 pt-5">
                <h3><a href="/videos/{{$video->id}}">{{$video->name}}</a></h3>
                <h3 class = "btn btn-default pull-right"><a href="/videos/showannotated/{{$video->id}}">annotated</a></h3>
                <small>Uploaded on {{$video->created_at}} by {{$video->user->name}}</small>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="container">
        <h1>No Videos are available at this moment</h1>
        <p>:(</p>
    </div>
    @endif
    {{ $videos->links() }}
    </div>
</div>
@endsection