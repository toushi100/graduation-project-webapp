@extends('layouts.app')
@section('content')

<div class="container flex-grow-1 mt-3">
    <div class="content">
        <h1>File Upload</h1>
        
        {!! Form::open(['action'=>'VideoController@store', 'method'=>'POST', 'enctype'=>'multipart/form-data'])!!}

        <div class="form-group">
            {{Form::label('name','Name')}}
            {{Form::text('name','',['class'=>'form-control'])}}
        </div>

        <div class="form-group">
            {{Form::label('description','Description')}}
            {{Form::textarea('description','',['class'=>'form-control'])}}
        </div>

        <div class="form-group">
            {{Form::label('path','Upload a file')}}
            {{Form::file('path',['class'=>'btn btn-light py-1 mx-2'])}}
            {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
        </div>
        {!!Form::close()!!}
    </div>
</div>
@endsection