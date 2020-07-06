@extends('layouts.app')

@section('content')
        
<a href="{{ URL::previous()}}" class="btn btn-light mt-2" style="position: absolute;z-index:1;">Go Back</a>
            <div class="row">
                <div class="col"></div>
                <div class="col-md-8">
                    <table class="table table-bordered text-center">
                        <thead class="bg-dark" style="color:#FDFEFE">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Date&Time</th>
                            </tr>
                        </thead>
                            <tbody>
                                @foreach ($detail as $item)
                                @if ($item->sale_id === $id->sale_id)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->created_at}}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                    </table>
                </div>
                <div class="col"></div>
            </div>


@endsection