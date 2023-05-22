@extends('layouts.app')

@section('content')
    <div class="container mt-3 pt-2 ">
            
        <header class="d-flex justify-content-start align-items-center pe-3">
            <h1 class="h2">รายละเอียดการซื้อขาย <a href="{{route('historyReceipt', $history->id)}}"><i class="fa-solid fa-print"></i></a></h1>
            <h2 class="h4 text-muted ms-auto">#{{$history->id}}</h2>
        </header>

        <nav aria-label="breadcrumb" class="p-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('history')}}" class="text-decoration-none">ประวัติการซื้อขาย</a></li>
                <li class="breadcrumb-item active" aria-current="page">รายละเอียด</li>
            </ol>
        </nav>
        <hr>
        

        <i class="text-muted ">รายการที่ถูกคิดเงินโดย : {{$created_by_fullname}}</i>
        <div class="row mt-2">
            <div class="col-sm-12 col-md-12 ">
                <div class="card h-100">
                    <div class="card-header">
                        หมายเหตุ
                        <i class="fa-solid fa-circle-info ms-2" style="color: grey;"
                        title="ชื่อผู้ใช้ รหัสการสั่งจอง คำอธิบาย ข้อมูล คำชี้แจงเพิ่มเติม หรือ อื่นๆ"
                    ></i>
                    </div>
                    <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>{{$history->note}}</p>
                    </blockquote>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-4 mt-2">
                <div class="card h-100">
                    <div class="card-header">
                        ยอดรวม
                    </div>
                    <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>@convertToBath($history->price) ({{$history->qrcode == 1 ? 'โอนเงิน':'เงินสด'}})</p>
                        <footer class="blockquote-footer">ราคารวมของรายการนี้</footer>
                    </blockquote>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4 col-md-4 mt-2">
                <div class="card h-100">
                    <div class="card-header">
                        วันที่ทำรายการ
                    </div>
                    <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p id="date" data-toggle="tooltip" data-placement="top"  title="{{$history->created_at}}"></p>
                        <footer class="blockquote-footer">{{$history->created_at->diffForHumans()}}</footer>
                    </blockquote>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-4 mt-2">
                <div class="card h-100">
                    <div class="card-header">
                        จำนวนสินค้า
                    </div>
                    <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p id="all-items-num">-</p>
                        <footer class="blockquote-footer">จำนวนสินค้าในรายการนี้</footer>
                    </blockquote>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <table class="table table-strip text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคาสินค้า</th>
                    <th>จำนวนที่ซื้อ</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>

 
    </div>
@endsection

@section('footer')
    <script>
        const tbody = $('tbody');
        const history_products = Object.entries(JSON.parse(@json($history->product))); 
        const isRetail = "{{$history->isRetail}}";
        const products         = {{Js::from($products)}};
        let  Quantity = 0


        const date = new Date({{Js::from($history->created_at)}}).toLocaleDateString('th-TH', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' 
        })


        for (let[productSerial, productNum] of history_products) {
            const product = products.find((item)=>{
                return item.serial === productSerial && item.isRetail == isRetail
            });

  
            if (product) {
                tbody.append(`
                    <tr>
                        <td>${productSerial}</td>
                        <td>${product.name}</td>
                        <td>${new Intl.NumberFormat('th-TH', { style: 'currency', currency: 'thb' }).format(product.price)}</td>
                        <td>${new Intl.NumberFormat().format(productNum)}</td>
                    </tr>
                `)

                Quantity += productNum
            }

        } 

        $('#date').html(date);
        $('#all-items-num').html(new Intl.NumberFormat().format(Quantity)+' รายการ')
    </script>
@endsection
