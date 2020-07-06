@extends('layouts.admin')


@section('content')
<div class="container mt-3">
 @include('inc.navbar')
    <ul class="nav nav-tabs mt-2">
        <li class="nav-item">
          <a class="nav-link active " href="{{ route('income.index')}}">Today income</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="{{route('income.all')}}">Net income</a>
        </li>
      </ul>

        <div class="row mt-2" style="font-family: montserrat,Bahnschrift;">
            <div class="col">
                <div class="damnIt mt-5">
                        <h3 class="text-center mt-3 mb-5">TODAY CASH INCOME</h3>
                        <div id="invoice" class="text-left ml-3"></div>
                </div>
            </div>
            <div class="col">
                    <table class="table table-bordered shadow-sm" id="net_table">
                      <thead class="bg-dark text-center" style="color:#FDFEFE;">
                        <tr>
                          <th>Payment Type</th> 
                          <th>Invoice</th> 
                          <th>Purchase Time</th>     
                          <th>Details</th> 
                        </tr>
                      </thead>
                      <tbody class="text-center">
                        @foreach ($pay as $pay)
                        <tr>
                          <td>{{$pay->payment_type}}</td>
                          <td>{{$pay->amount}}</td>
                          <td>{{$pay->created_at}}</td>
                          <td><a href="/income/{{$pay->sale_id}}" class="btn btn-dark btn-sm"><i class="fa fa-eye"></a></td>
                        @endforeach
                      </tbody>
                    </table>
            </div>  
        <div>
</div>
@endsection

