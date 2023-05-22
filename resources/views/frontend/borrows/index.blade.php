@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/selectize.bootstrap3.min.css')}}">
    <script src="{{asset('js/selectize.min.js')}}"></script>

    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">การเบิก</li>
            </ol>
        </div>
    </nav>

    <style>
        .card{
            transition: 0.05s linear;
            cursor: pointer;
        }
        .card:hover{
            background: rgb(236, 236, 236);
        }

        .row > div{
            margin-bottom: 1em;
        }
    </style>
    
    <div class="container mt-3 py-3">
        <form action="{{route('borrowsInProcess')}}" method="get" id="borrowsInProcess"></form>
        <form action="{{route('borrowsFinished')}}" method="get" id="borrowsFinished"></form>
        <form action="{{route('borrowsCanceled')}}" method="get" id="borrowsCanceled"></form>


        <div class="row">

            <div class="col-sm-12 mb-3 ">
                <a class="btn btn-success text-nowrap "   data-bs-toggle="modal" data-bs-target="#addBorrow">
                    <i class="fa-solid fa-plus"></i>
                    เบิกสินค้า
                </a>
            </div>
            <div class="col-sm-12">
                @if (session('status'))
                    <div class="alert alert-{{ session('class') }} alert-dismissible fade show">
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('status') }}
                    </div>
                @endif
                <hr>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card" style="border-bottom: 3px solid #fd7e14;" data-apply-form="borrowsInProcess">

                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <h2 class="mt-2 mb-5">กำลังดำเนินการ</h2>
                            <footer class="blockquote-footer float-end">@formatNumber($process) รายการ</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card" style="border-bottom: 3px solid #198754;" data-apply-form="borrowsFinished">

                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <h2 class="mt-2 mb-5">สำเร็จ</h2>
                            <footer class="blockquote-footer float-end">@formatNumber($success) รายการ</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card" style="border-bottom: 3px solid #dc3545;" data-apply-form="borrowsCanceled">

                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <h2 class="mt-2 mb-5">ยกเลิก</h2>
                            <footer class="blockquote-footer float-end">@formatNumber($canceled) รายการ</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('footer')


<div class="modal fade " id="addBorrow" tabindex="-1" data-bs-focus="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เบิกสินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('borrowsAdd') }}"method="post" id="addBorrowForm">
                    @csrf

        
                    <label for="product_serial" class="mb-1">รหัสสินค้า : </label>

                    <select id="product_serial" name="product_serial" placeholder="รหัสสินค้า" required>
                    </select>
                    
                    @error('product_serial')
                      <p class="text-danger">
                          {{ $message }}
                      </p>
                      <script>
                          $(document).ready(() => {
                              $('#addProduct').modal('show');
                          })
                      </script>
                    @enderror
                    
                    <script>
                        let selectize;
                        $(document).ready(function () {
                            let items = {{Js::From($selectize)}}
                                 
                            items.forEach((element, num) => {
                                items[num].value = items[num].serial;
                                items[num].name  = `${items[num].quantity} x `+items[num].name;
                            });


                            selectize = $('#product_serial').selectize({
                                sortField: 'text',
                                options: items,
                                labelField: 'name',
                                searchField: ['serial', 'name'],
                                sortField: 'name',
                                create: false
                            });
                        });
                    </script>


                    @if (isset($select))
                    <script>
                        $(document).ready(() => {
                            $('#addBorrow').modal('show');
                        })
                    </script>
                    @endif


                    <label for="product_quantity" class="mb-1">จำนวน : </label>
                    <input type="number" class="form-control mb-2  @error('product_quantity') is-invalid @enderror"
                        name="product_quantity" id="add_product_quantity" min='1' placeholder="จำนวนสินค้า" value="1" required>
                    @error('product_quantity')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                        <script>
                            $(document).ready(() => {
                                $('#addBorrow').modal('show');
                            })
                        </script>
                    @enderror

                    <label for="product_note" class="mb-1">หมายเหตุ : </label>
                    <i class="fa-solid fa-circle-info ms-2" style="color: grey;"
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="ชื่อผู้ใช้ รหัสการสั่งจอง คำอธิบาย ข้อมูล คำชี้แจงเพิ่มเติม หรือ อื่นๆ"
                    ></i>


                    <input type="text" class="form-control mb-2  @error('product_note') is-invalid @enderror"
                        name="product_note" id="add_product_note" placeholder="หมายเหตุ" >
                    @error('product_note')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                        <script>
                            $(document).ready(() => {
                                $('#addBorrow').modal('show');
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
                                $('#addProduct').modal('show');
                            })
                        </script>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="addBorrowForm">เบิก</button>
            </div>
        </div>
    </div>
</div>

@endsection
