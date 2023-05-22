<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        *{
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;


        }
        body {
            font-family: 'sarabun', sans-serif;
        }



    </style>
</head>
<body>



    <div class="container-fluid border p-5">
        <header class="d-flex justify-content-between align-items-center">
            <h1 style="font-size: 4em;">SVC Mall</h1>
            <h2 class="text-muted" style="color: grey;">RECEIPT</h2>
        </header>

        <section class="d-flex justify-content-between mt-3">
            <div>
                <b>SVC Mall</b>
            </div>
            <div>
                <table class="table table-striped">
                    <tbody>
                 
                        <tr>
                            <th>Receipt No :</th>
                            <td>{{$data->id}}</td>
                        </tr>
                                   
                        <tr>
                            <th>Customer No : </th>
                            <td>{{$user->id}}</td>
                        </tr>
                                   
                        <tr>
                            <th>Create Date : </th>
                            <td>{{$data->created_at}}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2>BILL TO</h2>
            <p>คุณ <span>{{$user->fullname}}</span></p>
            <p>ที่อยู่ {{$user->address}}<p>
            <p>{{$user->province}} {{$user->area}} {{$user->district}} {{$user->postalcode}}<p>
            <p>LINE : {{$user->lineId}} | TEL : {{$user->tel}}</p>
        </section>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$data->description}}</td>
                    <td>@formatNumber2($data->price)</td>
                    <td>@formatNumber2($data->price)</td>
                </tr>
            </tbody>
        </table>

        <hr>

        <h3>Total : <span>@convertToBath($data->price)</span></h3>
    </div>


    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>