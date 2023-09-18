
@php
    function baht_text(float $amount): string{
        [$integer, $fraction] = explode('.', number_format(abs($amount), 2, '.', ''));

        $baht = convert($integer);
        $satang = convert($fraction);

        $output = $amount < 0 ? 'ลบ' : '';
        $output .= $baht ? $baht.'บาท' : '';
        $output .= $satang ? $satang.'สตางค์' : 'ถ้วน';

        return $baht.$satang === '' ? 'ศูนย์บาทถ้วน' : $output;
    }

    function convert(string $number): string{
        $values = ['', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
        $places = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];
        $exceptions = ['หนึ่งสิบ' => 'สิบ', 'สองสิบ' => 'ยี่สิบ', 'สิบหนึ่ง' => 'สิบเอ็ด'];

        $output = '';

        foreach (str_split(strrev($number)) as $place => $value) {
            if ($place % 6 === 0 && $place > 0) {
                $output = $places[6].$output;
            }

            if ($value !== '0') {
                $output = $values[$value].$places[$place % 6].$output;
            }
        }

        foreach ($exceptions as $search => $replace) {
            $output = str_replace($search, $replace, $output);
        }

        return $output;
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>

    <style>
        *{
            box-sizing: border-box ;
        }
        body {
            font-family: 'sarabun', sans-serif;
            padding: 5em;
            margin: 5em;
        }

        p{
            margin: 0;-
        }

        .header th{
            text-align: left;
            width: fit-content;
        }

        .header td{
            border-bottom: 0.5px solid black;
            text-align: left;
        }

        .items{
            margin-top: 1em;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .items th{
            border-right: 1px solid black;
            border-bottom: 1px solid black;
        }

        .items td{
            text-align: center;
            border-right: 1px solid black;
        }

        .items tr:nth-child(odd){background-color: #f2f2f2;}

        .borrow{
            color: rgb(148, 18, 18) !important;
        }


        .logo{
            float: left;
        }

        .title{
            float: right;
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
            display: flex;
            margin-left: 2em;
            margin-top: -1.5em;
            width: 70%;
            position: relative;
        }

        .clear{
            content: "";
            clear: both;
            display: table;
        }


        
    </style>
</head>
<body > 
    <div style="width: 100%; height: 100%; padding: 2em;">
        <div style="float: left; width: 20%; height: 15%;">
            <img 
                class="logo"
                src="image/pdf/svc_logo.png" 
                style="width: 100%; float: left;" 
                alt=""
            > 
        </div>
        <div style="float: right; width: 76%; height: 15%; padding: 0; ">
            <h1>{{$title}}</h1>
            <span>{{$address_shop}}</span>
        </div>


        <div class="clear"></div>

        <hr>

        <table style="width: 100%;" class="header">
            <tr>
 

                @if (auth()->user()->grade == 1)
                    <th>ชื่อ-นามสกุล</th>
                    <td colspan="2">{{ $firstname.'  '.$lastname }}</td>

                    <th>สาขา</th>
                    <td colspan="2">{{$department}}</td>
                @else 
                    <th>ชื่อ-นามสกุล</th>
                    <td colspan="5">{{ $firstname.'  '.$lastname }}</td>
                @endif


                <th>วิธีการชำระเงิน</th>
                <td>{{$payment}}</td>
            </tr>
            <tr>
                <th>ที่อยู่</th>
                <td colspan="3">{{$address}}</td>

                <th>ตำบล</th>
                <td>{{$district}}</td>
                
                <th>อำเภอ</th>
                <td>{{$area}}</td>


            </tr>
            <tr>
                <th>จังหวัด</th>
                <td>{{$province}}</td>

                <th>รหัสไปรษณีย์</th>
                <td>{{$postalcode}}</td>

             

                <th>หมายเหตุ</th>
                <td colspan="3">{{$note}}</td>
            </tr>

            
        </table>
        @php
            $i = 1;
            $allPrice = 0;
        @endphp

        <style>
            th{
                text-transform: uppercase;
            }
        </style>

        <table style="width: 100%;" class="items">
            
            <tr style="border-bottom: 1px solid black;">
                <th>ที่<br>Number</th>
                <th>รายการ<br>Description</th>
                <th>หน่วยละ<br>Unit price</th>
                <th>จำนวน<br>Quantity</th>
                <th style="border-right: 0px; ">จำนวนเงิน<br> (Baht)</th>
            </tr>

            @foreach ($products as $product)
   
                <tr >
                    <td class="{{$product->borrow}}">{{$i}} </td>
                    <td class="{{$product->borrow}}">{{$product->name}}</td>

                    <td class="{{$product->borrow}}">{{$product->price}}</td>
                    <td class="{{$product->borrow}}">{{$product->quantity}}</td>
                    <td class="{{$product->borrow}}" style="border-right: 0px; ">{{number_format($product->price*$product->quantity, 2)}}</td>
                </tr>

                @php
                    $allPrice = $allPrice + ($product->price*$product->quantity);
                    $i = $i + 1
                @endphp
            @endforeach

            <tr>
                <th colspan="2" style="border-top: 1px solid black;">รวม</th>
                <th colspan="2" style="border-top: 1px solid black;">{{baht_text($allPrice)}}</th>
                <th colspan="1" style="border-top: 1px solid black;">{{number_format($allPrice, 2)}}</th>
            </tr>

        </table>

        <div style="margin-top: 1em; text-align:right; width: 60%; float: right;">
            <div>
                <b>ลงชื่อ</b>
                <a style="margin-left: 15px; margin-right: 15px; border-bottom: 0.5px solid black;">      {{$nameget}}      </a>
                <b style="margin-left: 50px;">ผู้รับเงิน</b>
            </div>
        </div>
        <div style="margin-top: 0em; text-align:left; width: 40%; float: left;">
            <div>
                <b class="borrow">* รายชื่อสินค้าที่มีสีแดง เป็นสินค้าที่ยังไม่ได้รับสินค้า</b>
                
            </div>
        </div>

    </div>

    <div style="position: absolute; top: 2%; right: 4%; text-align:right;">
        <div>
            <p>เลขที่ <span>{{$currentYear}}-{{$id}}</span></p>
        </div>
    </div> 

    <div style="position: absolute; top: 15%; right: 4%; text-align:right;">
        <div>
            <p>วันที่ <span>{{$date}}</span></p>
        </div>
  
    </div> 

</body>
</html>