@extends('layouts.app')

@section('content')
    <div class="container mt-3 py-2 ">
        <header>
            <h1 class="h2">ผู้ใช้ : {{ @session('management:Quantity') }}</h1>
            <hr>
        </header>

        <div class="row">
            <div class="col-sm-12 col-lg-3 mb-3">
                @include('backend.management.layouts.menu')
            </div>
            <div class="col-sm-12 col-lg-9 pe-4">
                @if (session('alert'))
                    <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show">
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('alert') }}
                    </div>
                @endif
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.managements.history')}}" class="text-decoration-none">ประวัติการซื้อขาย</a></li>
                        <li class="breadcrumb-item active" aria-current="page">ดูประวัติการซื้อขาย</li>
                    </ol>
                </nav>

                <section>
        
                    <div class="row ">
                        <div class="col-sm-12 col-md-12 ">
                            <div class="card h-100">
                                <div class="card-header">
                                    หมายเหตุ
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
                                    <p>@convertToBath($history->price)</p>
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
                </section>
        </div>
    </div>
    </div>
@endsection

@section('footer')
<script>
    const tbody = $('tbody');
    const history_products = Object.entries(JSON.parse(@json($history->product))); 
    const products         = {{Js::from($products)}};
    let  Quantity = 0

    const date = new Date({{Js::from($history->created_at)}}).toLocaleDateString('th-TH', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' 
    })


    for (let[productSerial, productNum] of history_products) {
        const product = products.find((item)=>{
            console.log(products)
            return item.serial === productSerial
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
    $('#all-items-num').html(Quantity+' ชิ้น')
</script>
@endsection
