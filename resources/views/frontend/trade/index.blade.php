@extends('layouts.app')

@section('content')

<div class="container mt-3 py-2">
    <header>
        <div class="row">
            <div class="col-md-12 col-lg-3">
                <h1 class="h2">ซื้อสินค้า</h1>
                <span class="text-muted">
                    การซื้อขายวันนี้ : @convertToBath($priceOfTrade) บาท
                </span>
            </div>
            <div class="col-md-12 col-lg-9 d-flex justify-content-end align-item-center">
                <div>
                    <a class="btn btn-success text-nowrap"   data-bs-toggle="modal" data-bs-target="#addTrade">
                        <i class="fa-solid fa-plus"></i>
                        เพิ่มการซื้อขาย
                    </a>
                </div>
            </div>
            <div class="col-12 my-0 py-9">
                @if (session('status') && session('added') !== true)
                    <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show">
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('status') }}
                    </div>
                @endif
                <hr>

            </div>
        </div>
    </header>
    <section>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวน</th>
                    <th>ราคา</th>
                    <th>ราคารวม</th>
                    <th>วันที่เพิ่ม</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)

                    <tr>
                        <td>{{$item->trade_item}}</td>
                        <td>@formatNumber($item->trade_quantity)</td>
                        <td>@convertToBath($item->trade_price)</td>
                        <td>@convertToBath($item->trade_price*$item->trade_quantity)</td>
                        <td title="วว/ดด/ปป">@formatDateAndTime($item->created_at)</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script>
            $(document).ready( function () {
                $('table').DataTable();
            } );
        </script>
    </section>
</div>

@endsection

@section('footer')

<div class="modal fade " id="addTrade" tabindex="-1" data-bs-focus="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เบิกสินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tradeAdd') }}"method="post" id="addTradeForm">
                    @csrf
        
                    <label for="product_name">ชื่อสินค้า : </label>
                    <input type="text" class="form-control mb-2" name="product_name" placeholder="ชื่อสินค้า">
                    @error('product_name')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                        <script>
                            $(document).ready(() => {
                                $('#addTrade').modal('show');
                            })
                        </script>
                    @enderror

                    <label for="product_quantity">จำนวน : </label>
                    <input type="number" value="0" class="form-control mb-2" name="product_quantity" placeholder="จำนวน">
                    @error('product_quantity')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                        <script>
                            $(document).ready(() => {
                                $('#addTrade').modal('show');
                            })
                        </script>
                    @enderror

                    <label for="product_price">ราคา (ต่อชิ้น) : </label>
                    <input type="number" value="0" class="form-control mb-2" name="product_price" placeholder="ราคา">
                    @error('product_price')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                        <script>
                            $(document).ready(() => {
                                $('#addTradeForm').modal('show');
                            })
                        </script>
                    @enderror

                    @if (session('status') && session('added') === true)
                        <div class="alert alert-success alert-dismissible fade show">
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('added') === true)
                        <script>
                            $(document).ready(() => {
                                $('#addTrade').modal('show');
                            })
                        </script>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="addTradeForm">เพิ่มการซื้อขาย</button>
            </div>
        </div>
    </div>
</div>
@endsection
