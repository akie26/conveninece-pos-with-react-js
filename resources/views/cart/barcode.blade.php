<!DOCTYPE html>
<html lang="en">
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

            <div class="row mt-5">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <table class="table table-bordered text">
                        <thead class="bg-dark text-center" style="color: #FDFEFE;">
                            <tr>
                                <th>CODES</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr>
                        @foreach ($products as $item)
                           <td  style="height: 90px;">{!! DNS1D::getBarcodeHTML($item->barcode, 'C128A')  !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>

                </div>
                <div class="col-md-4"></div>

            </div>



</body>
</html>