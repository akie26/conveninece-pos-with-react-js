@extends('layouts.app')

@section('content')
        <div class="row mt-5">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="jumbotron text-center">
                    <h1>POS APPLICATION</h1>
                    <p><a class="btn btn-primary btn-lg" href="{{ route('cart.index') }}" role="button">COUNTER</a><p>
                        
                </div>      
            </div>
            <div class="col-md-3"></div>
        </div>
@endsection