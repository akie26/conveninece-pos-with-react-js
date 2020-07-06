@extends('layouts.app')

@section('content')
        <div class="jumbotron text-center mt-5">
            <h1>Privileges</h1>
            <p><a class="btn btn-primary" href="{{route('income.index')}}" role="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SALES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            &nbsp;<a class="btn btn-primary" href="{{route('products.create')}}" role="button">&nbsp;ADD ITEMS&nbsp;</a>&nbsp;&nbsp;<a class="btn btn-primary" href="{{route('products.index')}}" role="button">VIEW ITEMS</a><p>
        </div>
        
@endsection