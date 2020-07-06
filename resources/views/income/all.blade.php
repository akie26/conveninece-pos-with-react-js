<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{config('app.name')}}</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">  
</head>
<body>
  <div class="container mt-3">
    @include('inc.navbar')
    <ul class="nav nav-tabs mt-2">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('income.index')}}">Today income</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="{{route('income.all')}}">Net income</a>
      </li>
    </ul>
   
         <div class="row mt-2" style="font-family: montserrat,Bahnschrift;">
               <div class="col">
                   <div class="damnIt mt-4">
                           <h3 class="text-center mt-3 mb-5">NET INCOME</h3>
                           <div id="net" class="text-left ml-3"></div>
                   </div>
               </div>
               
               

               <div class="col">
                      <div class="row">
                        <div class="col-md-8">
                          <div class="input-group">
                            <input type="text" name="from_date" id="from_date" class="form-control input-daterange"  readonly/>
                            <button class="btn btn-dark btn-sm ml-2 mr-2" disabled>TO</button>
                            <input type="text"  name="to_date" id="to_date" readonly class="form-control input-daterange" readonly/>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-dark btn-sm mt-1" type="button" name="filter" id="filter">Filter</button>
                            <button class="btn btn-info btn-sm mt-1" type="button" name="refresh" id="refresh">Refresh</button>
                        </div>
                      </div>
                       <table class="table table-bordered mt-2">
                          <thead class="text-center bg-dark" style="color:#FDFEFE;">
                            <tr>
                                <th>Payment Type</th>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Detail</th>
                            </tr>  
                          </thead> 
                          <tbody class="text-center">
                            
                          </tbody> 
                      </table> 
                      {{ csrf_field() }}
              </div> 


   </div>
  
</body>
</html>
<script src="{{ asset('js/app.js') }}"></script>

<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
            var date = new Date();

       var a = $('.input-daterange').datepicker({
              todayBtn: 'linked',
              dateFormat: 'yy-mm-dd',
              autoclose: true,
            });
          

            var _token = $('input[name ="_token"]').val();

             fetch_data(); 

            function fetch_data(from_date = '', to_date = '')
            {
              $.ajax({
                  url:"{{ route('income.all.fetch_data') }}",
                  method: "POST",
                  data: {from_date:from_date, to_date:to_date, _token:_token},
                  dataType:"json",
                  success:function(data)
                  {
                      var output = '';
                      for(var count = 0; count < data.length; count++)
                      {
                        output += '<tr>';
                        output += '<td>' + data[count].payment_type + '</td>';
                        output += '<td>' + data[count].amount + '</td>';
                        output += '<td>' +data[count].created_at + '</td>';
                        output += '<td><a href="income/' +data[count].sale_id+'" class="btn btn-dark btn-sm"><i class="fa fa-eye"></a></td></tr>';
                      }
                      $('tbody').html(output);
                  }
              });
            }
            $('#filter').click(function(){
              var from_date = $('#from_date').val();
              var to_date = $("#to_date").val();
              if(from_date != '' && to_date != '')
              {
                  fetch_data(from_date, to_date);
              }
              else
              {
                  swal.fire(
                    '',
                    'Given Data is Invalid',
                    'error'
                  )
              }
            });
            $('#refresh').click(function(){
              $('#from_date').val('');
              $('#to_date').val('');
              fetch_data();
            })

      });

</script>
