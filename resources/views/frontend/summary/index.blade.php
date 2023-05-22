@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/selectize.bootstrap3.min.css')}}">
    <script src="{{asset('js/selectize.min.js')}}"></script>
  
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">สรุปผลวันที่  {{$date}}</li>
            </ol>
        </div>
    </nav>

    <div class="container mt-3 my-3">
        <p>วันที่ : {{$date}}</p>
        <p>สินค้าที่ทำรายการ :</p>
        @php
            $items      = [];
            $totalMoney = 0;
            $totalItem  = 0;
        @endphp
        <section >
            <div >
                <div class="row">
                    <div class="col-lg-6 col-sm-12 ">
                        <div class="row">
                            @php
                                $val = 0;
                                $totalPrice = 0;
                                $totalPrice2 = 0;
                            @endphp
                            @foreach ($data as $item)
                                @php
                                    $items2 = json_decode($item['product']);

                                    if ($item['qrcode']){
                                        $totalPrice2 += $item['price'];
                                    }else{
                                        $totalPrice += $item['price'];
                                    }

                                    foreach ($items2 as $serial => $number) {
                                        $val += $number;
                                    }
                                @endphp
                            @endforeach
                            
                            <div class="col-sm-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        รายการ
                                    </div>
                                    <div class="card-body">
                                        <span>@formatNumber(count($data)) รายการ</span>
                                        <blockquote class="blockquote mb-0">
                                            <p></p>
                                            <footer class="blockquote-footer">
                                                จำนวนการทำรายการทั้งหมด
                                            </footer>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        สินค้า
                                    </div>
                                    <div class="card-body">


                                        <span>@formatNumber($val) รายการ</span>
                                        <blockquote class="blockquote mb-0">
                                            <p></p>
                                            <footer class="blockquote-footer">
                                                จำนวนสินค้าทั้งหมดที่ขายได้
                                            </footer>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 ">
                        <table class="table table-striped">
                            <thead>
                                <th>ยอดรวม</th>
                                <th>เงินสด</th>
                                <th>เงินโอน</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>@formatNumber($totalPrice+$totalPrice2) บาท</td>
                                    <td>@formatNumber($totalPrice) บาท</td>
                                    <td>@formatNumber($totalPrice2) บาท</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </section>
        <hr>
        <section >
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>หมายเหตุ</th>
                        <th>ประเภท</th>
                        <th>จำนวนสินค้า</th>
                        <th>ราคา</th>
                        <th>วิธีการชำระเงิน</th>
                        <th>อื่นๆ</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data as $item)
                        <tr>
                            <td>{{$item['id']}}</td>
                            <td>{{$item['note']}}</td>
                            <td>{{$item['isRetail'] ? "ค้าส่ง":"ค้าปลีก"}}</td>
                            <td>
                                @php
                                    $items2 = json_decode($item['product']);
                                    $count = 0;

                                    foreach ($items2 as $serial => $number) {
                                        $count += $number;
                                    }
                                @endphp

                                @formatNumber($count) รายการ
                            </td>
                            <td>@formatNumber($item['price']) บาท</td>
                            <td>{{$item['qrcode'] == "1" ? "โอนเงิน":"เงินสด"}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{route("historyView", ['id' => $item['id']])}}">เพิ่มเติม</a>
                            </td>
                        </tr>
                    @endforeach

 {{--                    @foreach ($data as $item)
                        @php
                            $named = empty((string) $item->categoryId) ? 0:(string) $item->categoryId;
                 
                            if (empty($items[$named])) {
                                    $items[$named] = [
                                        'total_price' => 0,
                                        'total_amount' => 0,
                                        'label' => $named == 0 ? 'ไม่มีประเภท':$item->category_name,
                                        'items' => []
                                    ];
                                }

                                $id =  $named;
                                $productId = (string) $item->id;

                                if(empty($items[$id]['items'][$productId])){
                                    $items[$id]['items'][$productId] = [
                                        'total_price' => 0,
                                        'total_amount' => 0,
                                        'label' => $item->name
                                    ];
                                }

                                /* SUM */
                                $used = $item->amount;
                                $price = $item->price;
                                $allPrice = $used*$price;

                                $totalMoney += $allPrice;
                                $totalItem += $used;

                                /* ADD TO ALL */

                                $items[$id]['total_price'] += $allPrice;
                                $items[$id]['total_amount'] += $used; 

                                /* ADD TO ITEM */
                               
                                $items[$id]['items'][$productId]['total_price'] += $allPrice;
                                $items[$id]['items'][$productId]['total_amount'] += $used;

                        @endphp
                    @endforeach

      

                    @foreach ($items as $category)
                        @foreach ($category['items'] as $product)
                            <tr>
                                <td>{{$product['label']}}</td>
                                <td>{{$product['total_amount']}} รายการ</td>
                                <td>เป็นเงิน @formatNumber($product['total_price']) บาท</td>
                            </tr>
                        @endforeach
                    @endforeach
          
                    <tr >
                        <td>รายงานวันที่</td>
                        <td colspan="2">{{$date}}</td>
                    </tr>
                    <tr>
                        <td>รวมทั้งหมด</td>
                        <td colspan="2">@formatNumber($totalItem) รายการ</td>
                        
                    </tr>
                    <tr>
                        <td>ราคาทั้งหมด</td>
                        <td colspan="2">@formatNumber( $totalMoney) บาท</td>
         
                    </tr> --}}
                </tbody>
            </table>
        </section>

    </div>



@endsection

@section('footer')

    <script>
        $(document).ready(() => {
            $(".datatable").DataTable()
        })
    </script>

@endsection
