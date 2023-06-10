
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <style>
        *{
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
        }
        body {
            font-family: 'sarabun', sans-serif;
        }
        th, td {
            padding-top: 0.25em !important;
        }
    </style>
</head>
<body>
    {{-- FORM --}}
    <div class="container" style="width: 80%; margin-top: 2em; border: 1px solid white; text-align:center;">
        <h1 style="font-size: 2em; margin-top: 2em;">สินค้า {{$categoryName}}</h1>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th>จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr style="border-bottom: 0.1px solid rgba(0, 0, 0, 0.1);">
                                <td >{{ $product['name'] }}</td>
                                @php
                                    //format number
                                    $product['quantity'] = number_format($product['quantity']);
                                @endphp
                                <td >{{ $product['quantity'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>