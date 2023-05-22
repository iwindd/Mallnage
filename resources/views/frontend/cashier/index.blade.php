@extends('layouts.app')
@php
    $isEmployees = Auth::user()->employees != -1 ? true:false;
@endphp
@section('content')

    <link rel="stylesheet" href="{{asset('css/selectize.bootstrap3.min.css')}}">
    <script src="{{asset('js/selectize.min.js')}}"></script>
    <style>
        .hover-slide {
            transform: translateX(70%) !important;
            transition: transform 0.2s ease;
        }

        li.list-group-item:hover .hover-slide {
            transition-delay:0.1s;

            transform: translateX(0%) !important;
        }

        li.list-group-item:hover .hover-slide .count{
            transition-delay:0.1s;

            opacity: 0;
        }

        .count{
            transition: all 0.2s ease;
        }

        li.list-group-item {
            cursor: pointer;
        }

        .editCount,
        .removeItem{
            transition: background 0.2s ease;
        }

        .editCount:hover{
            background: #0d61df !important;
            height: 100%;
        }

        .removeItem:hover{
            background: #c22837 !important;
        }

        .is-borrow{
            background: #e6cbbb;
        }
    </style>

    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">ขายสินค้า</li>
            </ol>
        </div>
    </nav>


    <div class="container  mt-3 py-3">
        <div class="row">
            <div class="col-sm-12 col-lg-9">
                <h2>ขายสินค้า</h2>

                <hr>
                <div>
                    <form id="addBasketForm" action="{{ route('basketAdd') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3  mt-3">

                            <input type="text" class="form-control" placeholder="รหัสสินค้า" 
                                name="product_serial" id="product_serial" autofocus>

                            <input type="hidden" name="product_quantity" id="product_quantity" value="1">
                            <input type="hidden" name="product_edit" id="product_edit" value="0">

                            <input type="submit" class="btn btn-outline-success" id="product_search" value="เพิ่ม">


                                
                        </div>
                    </form>
                </div>

                <div>
                    @if (session('status'))
                        <div class="alert alert-{{ session('class') }} alert-dismissible fade show">
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                            @php
                                echo session('status');
                            @endphp
                        </div>
                    @endif
                </div>

                <hr>
         
                <div id="products">

                    <div class="accordion mb-2" id="products">
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                              สินค้าภายในร้าน
                            </button>
                          </h2>
                          <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                           
                                <table class="mt-2 mb-1 table table-striped product-table">
                                    <thead>
                                        <th>รหัสสินค้า</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>จำนวนคงเหลือ</th>
                                        <th>ราคา</th>
                                        <th>อื่นๆ</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{$product->serial}}</td>
                                                <td>{{$product->name}}</td>
                                                <td>@formatNumber($product->quantity)</td>
                                                <td>@convertToBath($product->price)</td>
                                                <td>
                                                   {{--  <a href="#" class="btn btn-success">เพิ่ม</a> --}}
                                                   <form id="addBasketForm" action="{{ route('basketAdd') }}" method="POST">
                                                        @csrf
                                                         <input type="hidden" name="product_quantity" id="product_quantity" value="1">
                                                        <input type="hidden" name="product_serial" value="{{$product->serial}}">
                                                        <button type="submit" class="btn btn-success">เพิ่ม</button>
                                                        <input type="hidden" name="retail" value="{{$isRetail}}">
                                                        @if (!$isEmployees)
                                                            <a href="{{ route('productEdit', ['serial' => $product->serial, 'retail' => $isRetail]) }}" class="btn btn-primary">จัดการ</a>  
                                                        @endif
                                                   </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                          </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-sm-12 col-lg-3 border-start">
                <h2>ตะกร้า</h2>
                <hr>

                
                <form action="{{route('basketRemove')}}" method="post" id="basketRemoveForm">
                    @csrf
                    <input type="hidden" name="serial" id="removeSerial">
                    <input type="hidden" name="amount" id="removeAmount">
                </form>

       
                @if (count($basket) > 0)
                    <ul class="list-group">
                        @foreach ($basket as $product)
                            <li class="list-group-item @if ($product['borrow'] === true) is-borrow  @endif justify-content-between d-flex align-items-center p-0 overflow-hidden  "
                            data-toggle="dropdown">
                                <div class="w-25 text-nowrap">
                                    <a href="#" class="text-black text-decoration-none ms-2 f" amount="{{$product['quantity']}}" id="{{ $product['serial'] }}">{{$product['name']}}</a>
                                </div>

                            
                                <div class="d-flex align-items-center hover-slide">

                                    <div class="me-5 count">
                                        <span class="badge bg-primary rounded-pill">{{ $product['quantity'] }}</span>
                                    </div>

                                    <div class="py-2 px-3 bg-primary editCount-btn" data-serial = "{{$product['serial']}}">
                                        <i class="fa-solid fa-pencil text-light"></i>
                                    </div>

                                    <div class="py-2 px-3 bg-danger removeItem-btn" data-serial = "{{$product['serial']}}">
                                        <i class="fa-solid fa-trash text-light"></i>
                                    </div>
                                </div>

                            </li>

  
                        @endforeach
                    </ul>
                @else
                    <h3 class="h6 text-center">ไม่มีสินค้าในตะกร้า</h3>
                @endif

                <hr>{{-- TOTAL --}}
                <p>
                <div class="p-2 d-flex justify-content-between">
                    ราคาทั้งหมด : <span class="realPrice" id="total-price">@convertToBath($price)</span>
                </div>
                </p>
         
                <div class="buttons">
                    <button class="btn btn-success w-100 mb-2" id="confirmOrders" data-bs-target="#cashierConfirmation" data-bs-toggle="modal">คิดเงิน</button>
                    <button class="btn btn-secondary w-100 mb-2" id="clear">ล้าง!</button>
                </div>

                <div class="border rounded my-2 p-3">
                    <label for="moneyInput" class="mb-1">เครื่องคิดเงิน : </label>
                    <input type="number" class="form-control" min="0" name="moneyInput" id="moneyInput" placeholder="จำนวน" >
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>ผลลัพธ์</div>
                        <div id="ChangeMoney">฿0.00</div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>

@endsection

@section('footer')


    
    <!-- Modal -->
    <div class="modal fade " id="cashierConfirmation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">รายละเอียดการคิดเงิน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('basketEnd')}}" method="post" id="basketEnd">
                        @csrf
                        <input type="hidden" name="retail" value="{{$isRetail}}">
                        
                        <div class="row">
                            <div class="col-lg-4 col-md-12 border-end">
                                <label for="noted" class="mb-1">หมายเหตุ : </label>
                                <i class="fa-solid fa-circle-info ms-1" style="color: grey;"
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="ชื่อผู้ใช้ รหัสการสั่งจอง คำอธิบาย ข้อมูล คำชี้แจงเพิ่มเติม หรือ อื่นๆ"
                                ></i>
                                <input type="text" name="noted" id="noted" class="form-control mb-2" placeholder="หมายเหตุ">
    
                                <label for="noted" class="mb-1">วิธีการชำระเงิน : </label>
                                <select class="form-select" name="payment" id="payment">
                                    <option value="0">เงินสด</option>
                                    <option value="1">โอน</option>
                                </select>
    

                                <input type="hidden" name="price" value="{{$price}}">

                                <hr>
                                <div class="d-flex justify-content-between">
                                    <label for="">ราคาทั้งหมด : </label><span >@convertToBath($price)</span>
                                </div>
         
                            </div>
                            <div class="col-lg-8 col-md-12">
                                <div>
                                    <h4 class="my-3">รายละเอียดผู้ซื้อ</h4>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <label for="noted" class="mb-1">ชื่อ : </label>
                                            <input type="text" name="firstname" id="firstname" class="form-control mb-2" placeholder="ชื่อ">            
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <label for="noted" class="mb-1">นามสกุล : </label>
                                            <input type="text" name="lastname" id="lastname" class="form-control mb-2" placeholder="นามสกุล">
                                        </div>
                                    </div>
                                    @if (auth()->user()->grade == 1)
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <label for="noted" class="mb-1">แผนก : </label>
                                                <input type="text" name="department" id="department" class="form-control mb-2" placeholder="ชื่อแผนก">            
                                            </div>
                                        </div>
                                    @endif
                                    <script>
                                        let selectize;
                                        $(document).ready(function () {
                                            let items = {{Js::From($selectize)}}
                                                 
                                            items.forEach((element, num) => {
                                                items[num].value = items[num].label;
                                            });
            
            
                                            selectize = $('#department').selectize({
                                                sortField: 'text',
                                                options: items,
                                                labelField: 'label',
                                                searchField: ['id', 'label'],
                                                sortField: 'label',
                                                maxItems: 1,
                                            });
                                        });
                                    </script>
                                </div>
                                <div>
                                    <h4 class="my-3">ที่อยู่</h4>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <label for="noted" class="mb-1">ที่อยู่ : </label>
                                            <input type="text" name="address" id="address" class="form-control mb-2" placeholder="ที่อยู่">            
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <label for="noted" class="mb-1">ตำบล : </label>
                                            <input type="text" name="district" id="district" class="form-control mb-2" placeholder="ตำบล">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <label for="noted" class="mb-1">อำเภอ : </label>
                                            <input type="text" name="area" id="area" class="form-control mb-2" placeholder="อำเภอ">            
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <label for="noted" class="mb-1">จังหวัด : </label>
                                            <input type="text" name="province" id="province" class="form-control mb-2" placeholder="จังหวัด">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <label for="noted" class="mb-1">รหัสไปรษณีย์ : </label>
                                            <input type="text" name="postalcode" id="postalcode" class="form-control mb-2" placeholder="รหัสไปรษณีย์">            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" form="basketEnd" class="btn btn-primary">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>


    <form action="{{route("basketDestroy")}}" method="get" id='basketDestroyForm'>
        <input type="hidden" name="retail" value="{{$isRetail}}">
    </form>

    <script>
        const price = {{Js::from($price)}};

        $(document).ready(() => {
            $('.product-table').DataTable();

            $('#clear').on('click', () => {
                Swal.fire({
                    title: 'แจ้งเตือน?',
                    text: "ต้องการที่จะยกเลิกรายการหรือไม่!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonText: 'แน่นอน'
                }).then((result) => {
                    if (result.isConfirmed) $("#basketDestroyForm").submit();
                })
            })

            $('.editCount-btn').on('click', function(){
                let serial = $(this).attr('data-serial');
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: "คุณต้องการที่จะแก้ไขสินค้าหรือไม่!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonText: 'แน่นอน'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'แจ้งเตือน',
                            text: "กรุณาป้อนจำนวนที่จะแก้ไข!",
                            input: 'number',
                            inputValue: 1,
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            icon: 'warning',
                            showCancelButton: true,
                            cancelButtonText: 'ยกเลิก',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                amount = Number(result.value);

                                $('#product_serial').val(serial);
                                $('#product_quantity').val(amount);
                                $('#product_edit').val('1');
                                $('#addBasketForm').submit();
                            }
                        })
                    }
                })
            })

            $('.removeItem-btn').on('click',  function(){
                let serial = $(this).attr('data-serial');
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: "คุณต้องการที่จะลบสินค้าออกจากตะกร้าหรือไม่!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonText: 'แน่นอน'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'แจ้งเตือน',
                            text: "กรุณาป้อนจำนวนที่จะลบ!",
                            input: 'number',
                            inputValue: 1,
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            icon: 'warning',
                            showCancelButton: true,
                            showDenyButton: true,
                            denyButtonText: 'ทั้งหมด',
                            cancelButtonText: 'ยกเลิก',
                            confirmButtonText: 'ตามจำนวนที่ฉันเลือก'
                        }).then((result) => {
                            let amount = 0
                            let element = $(`#${serial}`);

                            if (result.isConfirmed) {
                                amount = Number(result.value);
                            } else if (result.isDenied) {
                                amount = Number(element.attr('amount'));
                            }

                            if (result.isDismissed === false) {
                                // DELETE
                                $('#basketRemoveForm #removeSerial').val(serial);
                                $('#basketRemoveForm #removeAmount').val(amount);
                                $('#basketRemoveForm').submit();

                            }
                        })
                    }
                })
            })
  
            $("#moneyInput" ).keyup(function() {
                const val = $("#moneyInput").val();
                
                let convert = (val) => {
                    return new Intl.NumberFormat('th-TH', {
                        style: 'currency',
                        currency: 'thb'
                    }).format(val)
                }

                const change = parseInt(val) - price;
                const IsEnough = change < 0 ? false:true;
       
                let Text    = change < 0 ? `ต้องการเพิ่ม ${convert(Math.abs(change))}`: `เงินทอน ${convert(change)}`;
                if (isNaN(parseInt(val))) {
                    Text = `$0.00`;
                }

                $('#ChangeMoney').html(Text);
            });

            $(document).on("keydown", (e) => {
                if (e.which == 13) {
                    e.preventDefault()
                    Swal.fire({
                        title: 'แจ้งเตือน',
                        text: "กรุณาเลือกวิธีการชำระเงิน!",
                        icon: 'warning',
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonColor: "#198754",
                        denyButtonColor: "#0d6efd",
                        denyButtonText: 'โอนเงิน',
                        cancelButtonText: 'ปิด',
                        confirmButtonText: 'เงินสด'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#basketEnd #payment").val("0").change();
                        }else if(result.isDenied){
                            $("#basketEnd #payment").val("1").change();
                        }else{
                            return
                        }

                        $('#basketEnd').submit();
                    })
                }
            })
        })
    </script>
@endsection 
