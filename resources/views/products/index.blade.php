@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
@include('inc.navbar')
<hr>
        <div class="container">
           <table class="table table-striped table-light shadow-sm">
               <thead class="bg-dark" style="color:#FDFEFE;">
                   <tr class="text-center">
                       <th>NAME</th>
                       <th>INFO</th>
                       <th>CODE</th>
                       <th>QUANTITY</th>
                       <th>PRICE</th>
                       <th>CREATED AT</th>
                       <th>MODIFIED AT</th>
                       <th>STATUS</th>
                   </tr>
               </thead>
               <tbody>
                @foreach ($products as $product)
                   <tr class="text-center">
                       <td>{{$product->name}}</td>
                       <td>{{$product->info}}</td>
                       <td>{{$product->barcode}}</td>
                       <td>{{$product->quantity}}</td>
                       <td>{{$product->price}}</td>
                       <td>{{$product->created_at}}</td>
                       <td>{{$product->updated_at}}</td>
                       <td class="text-center">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-dark btn-sm" style="margin-top: -4px;margin-bottom:-3px;"><i class="fa fa-edit"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" style="margin-top:-5px;margin-bottom:-3px;" data-url="{{route('products.destroy', $product)}}"><i
                            class="fas fa-trash"></i></button>
                       </td>
                   </tr>
                @endforeach
               </tbody>
           </table>
        </div>
@endsection

@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click', '.btn-delete', function () {
            $this = $(this);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary mr-5',
                    cancelButton: 'btn btn-dark'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                // reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    $.post($this.data('url'), {_method: 'DELETE', _token: '{{csrf_token()}}'}, function (res) {
                        $this.closest('tr').fadeOut(500, function () {
                            $(this).remove();
                        })
                    })
                }
            })
        })
    })
</script>
@endsection