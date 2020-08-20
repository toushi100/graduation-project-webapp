@extends('layouts.app')

@section('content')

<div class="container col-12 col-md-10 flex-grow-1">
    <div class="row justify-content-center no-gutters my-5">
            <div id="profile-card" class="card col-4 mb-3 col-md-3 order-md-12 ml-md-5 mb-md-0">
                <img src="{{ asset('images/user.png') }}" class="mx-auto my-3">
                <h2 class="badge badge-pill badge-info mx-auto"> {{ Auth::user()->name }} </h2>
                <span class="mx-auto my-3" style="width: fit-content"> {{ Auth::user()->email }} </span>
            </div>

            <div class="card col-12 col-md-8">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="panel-body">

                        <a href="/upload" class="btn btn-primary mb-3">Upload</a>
                        @if(count($videos) > 0)

                        <h3>Your Uploaded Videos</h3>

                        <table class="table mt-3">
                            
                            @foreach($videos as $video)
                            <tr>
                                
                                <td id="up-vid-link" style="color: black">
                                    <a href="/videos/{{$video->id}}">
                                        <img src="{{ asset('images/placeholder.png') }}" style="height: 4em" class="mr-3">
                                        {{$video->name}}
                                    </a>
                                </td>

                                <td id="up-vid-action" class="d-flex align-content-center">
                                    {!!Form::open(['action'=>['VideoController@destroy',$video->id], 'method'=>'POST',
                                    'class'=>'pull-right'])!!}
                                    {{Form::hidden('_method','DELETE')}}
                                    {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
                                    {!!Form::close()!!}
                                </td>

                            </tr>
                            @endforeach
                            @else

                            <p style="font-size:150%;" class="text-center mb-3"> Opps . . . </p>
                            <p class="text-center"> No videos yet :(</p>
                            @endif
                        </table>

                    </div>
                </div>
            </div>
    </div>
</div>
@endsection