@extends('layouts.admin')

@section('content')
@include('inc.navbar')
    <h1 style="font-family:Gabriola; margin:auto;padding:5px 5px 0px 5px;position:absolute;left:50%;top:5.5%;transform: translate(-50%, -50%);">Add Products</h1>
    <a href="{{ URL::previous()}}" class="btn btn-light mt-2" style="position: absolute;z-index:1;">Go Back</a>

<div class="row mt-2">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        {!! Form::open(['action'=> 'ProductController@store','method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
    <div class="form-group">
        {{Form::label('name','NAME')}}
        {{Form::text('name', '', ['class' => 'form-control','autocomplete' => 'off'])}}
    </div>
    <div class="form-group">
        {{Form::label('info','DETAILS')}}
        {{Form::text('info', '', ['class' => 'form-control','autocomplete' => 'off'])}}
    </div>
    <div class="form-group">
        {{Form::label('barcode','BARCODE')}}
        {{Form::text('barcode', '', ['class' => 'form-control','autocomplete' => 'off'])}}
    </div>
    <div class="form-group">
        {{Form::label('price','PRICE')}}
        {{Form::text('price', '', ['class' => 'form-control','autocomplete' => 'off'])}}
    </div>
    <div class="form-group">
        {{Form::label('quantity','QUANTITY')}}
        {{Form::text('quantity', '', ['class' => 'form-control','autocomplete' => 'off'])}}
    </div>
    <div class="form-group">
        {{Form::file('image')}}
    </div>
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
{!! Form::close() !!}
    </div>
    <div class="col-md-3"></div>
</div>
@endsection