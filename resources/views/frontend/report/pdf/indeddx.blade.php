<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงาน</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <style>
        body {
            font-family: 'sarabun', sans-serif;
        }

        td, th{
            padding: 10px !important;
        }


    </style>
</head>
<body>
    <header class="text-center">
       {{--  <h1 style="font-size: 25.0vh">รายงาน</h1> --}}
       <img 
            src="https://chomphunutdocumentary.files.wordpress.com/2018/11/e0b884e0b8a3e0b8b8e0b891e0b89ee0b988e0b8b2e0b8abe0b98c-e0b8a3e0b8b2e0b88ae0b881e0b8b2e0b8a3e0b983e0b899e0b89be0b8a3e0b8b0e0b980e0b897.png" 
            width="110px"
            class="mb-6"
            alt="">
    </header>
    <article>
        <div class="container">
            <p class="text-end" style="margin-right: 200px; margin-top: 20px; margin-bottom: 30px;">
                {{$timeNow}}
            </p>

            <section>
                {{-- LIST --}}
                <div class="w-25 float-start">เรื่อง : </div>
                <div class="w-60 float-end text-end">ผลการสำรวจการซื้อขาย </div>

                <div class="w-25 float-start">ผลสำรวจวันที่ : </div>
                <div class="w-60 float-end text-end"> {{$timeFrom}} <span>-</span>  {{$timeTo}}</div>
      
                <div class="w-25 float-start">ยอดขาย : </div>
                <div class="w-50 float-end text-end" id="price">@convertToBath($totalPrice)</div>
            </section>
            <hr>
            <section>
                <div class="container p-3">
                    <section class="border-bottom ">
                        <table class="table table-striped text-center">
                            <caption>สินค้าที่มีการซื้อขายมากที่สุด :</caption>
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">ชื่อสินค้า</th>
                                    <th class="text-center">ราคาสินค้า</th>
                         
                                    <th class="text-center">จำนวนการซื้อขาย</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($most) >= 1)
                                    @foreach ($most as $item)
                                        <tr>
                                            <td class="text-center">@formatNumber($item['product_number'])</td>
                                            <td class="text-center">{{$item['product_name']}}</td>
                                            <td class="text-center">@convertToBath($item['product_price'])</td>
                                            <td class="text-center">@formatNumber($item['product_sold'])</td> 
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td  class="text-center" colspan="4">ไม่มีพบสินค้า</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </section>
                   
                    <section class="border-bottom mt-2">
                        <table class="table table-striped text-center">
                            <caption>สินค้าที่มีการซื้อขายน้อยที่สุด :</caption>
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">ชื่อสินค้า</th>
                                    <th class="text-center">ราคาสินค้า</th>
                         
                                    <th class="text-center">จำนวนการซื้อขาย</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($least) >= 1)
                                    @foreach ($least as $item)
                                        <tr>
                                            <td class="text-center">@formatNumber($item['product_number'])</td>
                                            <td class="text-center">{{$item['product_name']}}</td>
                                            <td class="text-center">@convertToBath($item['product_price'])</td>
                                            <td class="text-center">@formatNumber($item['product_sold'])</td> 
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td  class="text-center" colspan="4">ไม่มีพบสินค้า</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </section>
                </div>
            </section>
  
        </div>
    </article>

</body>
</html>