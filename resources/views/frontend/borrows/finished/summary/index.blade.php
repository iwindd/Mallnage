@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/selectize.bootstrap3.min.css')}}">
    <script src="{{asset('js/selectize.min.js')}}"></script>
  
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{route('borrows')}}" class="text-decoration-none">การเบิก</a></li>
                <li class="breadcrumb-item"><a href="{{route('borrowsFinished')}}" class="text-decoration-none">การเบิกที่เสร็จสิ้นแล้ว</a></li>
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
        <section class="ps-lg-5">
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th class="w-50">ชื่อ</th>
                        <th>จำนวน</th>
                        <th>ราคา</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
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
                                $productId = (string) $item->product;

                                if(empty($items[$id]['items'][$productId])){
                                    $items[$id]['items'][$productId] = [
                                        'total_price' => 0,
                                        'total_amount' => 0,
                                        'label' => $item->name
                                    ];
                                }

                                /* SUM */
                                $used = $item->used;
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
         
                    </tr>
                </tbody>
            </table>
        </section>

{{--         <p>ประเภทสินค้าที่ทำรายการ</p>
        <section class="ps-lg-5">
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th class="w-50">ชื่อ</th>
                        <th>จำนวน</th>
                        <th>ราคา</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($items as $category)
                    <tr>
                        <td>{{$category['label']}}</td>
                        <td>{{$category['total_amount']}} รายการ</td>
                        <td>เป็นเงิน @formatNumber($category['total_price']) บาท</td>
                    </tr>
                    @endforeach
                    <tr>
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
                    </tr>
                </tbody>
            </table>
        </section> --}}
    </div>



@endsection

@section('footer')



@endsection
