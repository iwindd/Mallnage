@extends('layouts.app')

@php
    $redirectCookie     = empty($_COOKIE["redirect_route"]) ? 'stock':$_COOKIE["redirect_route"];
    $saveMode           = $redirectCookie == 'stock' ? true:false;
@endphp

@section('content')
    <link rel="stylesheet" href="{{asset('css/selectize.bootstrap3.min.css')}}">
    <script src="{{asset('js/selectize.min.js')}}"></script>

    <style>
        .hover-slide{
            transform: translateX(60%) !important;
            transition: transform 0.2s ease;
        }

        li.list-group-item:hover .hover-slide{
            transform: translateX(0%) !important;
        }

        li.list-group-item{
            cursor: pointer;
        }
    </style>
    
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{route('product')}}" class="text-decoration-none">สินค้า</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$data->name}}</li>
            </ol>
        </div>
    </nav>

    <div class="container  mt-1 pt-3">
        <form action="{{route('product_remove', ['serial' => $data->serial])}}" method="get" id="deleteForm">
            <input type="hidden" name="serial" value="{{$data->serial}}">
            <input type="hidden" name="retail" value="{{$isRetail}}">
        </form>
       
        <section class="w-75 mx-auto">

  

            <div class="card">
                <div class="card-header">แก้ไขสินค้า :  <span>{{$data->name}}</span></div>
                <div class="card-body">
                    <form action="{{route('product_update', $data->serial)}}" method="POST" enctype="multipart/form-data" id="saveProduct">
                        @csrf


                        <input type="hidden" name="retail" value="{{$isRetail}}">
                        <div class="my-3">
                            <label for="product_serial" class="form-label">รหัสสินค้า : </label>
                            <input type="text" placeholder="รหัสสินค้า" class="form-control" value="{{ $data->serial }}" disabled name="product_serial">
                        </div>
        
                        <div class="my-3">
                            <label for="product_name" class="form-label">ชื่อสินค้า : </label>
                            <input type="text" placeholder="ชื่อสินค้า" class="form-control" value="{{ $data->name }}" name="product_name">
                        </div>
                        @error('product_name')
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button class="btn-close" data-bs-dismiss="alert"></button>
                                {{$message}}
                            </div>
                        @enderror
                        <div class="my-3">
                            <label for="product_category" class="form-label">ประเภทสินค้า : </label>
                            <select type="text" placeholder="ประเภทสินค้า" class="form-control" value="{{ $data->name }}" id="product_category" name="product_category"></select>
                        </div>
                        @error('product_category')
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button class="btn-close" data-bs-dismiss="alert"></button>
                                {{$message}}
                            </div>
                        @enderror

                                           
                        <script>
                            let selectize;
                            const categories = {{Js::From($categories)}};

                            $(document).ready(function () {
                                let items = [ /* DEFAULT */
                                    {
                                        value: 0,
                                        name: 'ไม่มีประเภท',
                                        category_name: 'ไม่มีประเภท',
                                        id: 0
                                    }
                                ]

                                items = items.concat(categories);
                                
                
                                items.forEach((element, num) => {
                                    items[num].value = items[num].id;
                                    items[num].name  = items[num].category_name;
                                });

                     

                                selectize = $('#product_category').selectize({
                                    sortField: 'text',
                                    maxOptions: 300,
                                    options: items,
                                    labelField: 'name',
                                    searchField: ['name'],
                                    sortField: 'name',
                                    create: false
                                });

                                const selectize2 = selectize[0].selectize;
                                selectize2.setValue({{Js::From($data->categoryId)}});
                            });
                        </script>
        
                        <div class="my-3">
                            <label for="product_price" class="form-label">ราคาสินค้า : </label>
                            <input type="text" placeholder="ราคาสินค้า" class="form-control" value="{{ $data->price }}" name="product_price">
                        </div>  
                        @error('product_price')
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button class="btn-close" data-bs-dismiss="alert"></button>
                                {{$message}}
                            </div>
                        @enderror
        
                        <div class="my-3">
                            <label for="product_cost" class="form-label">ราคาทุน : </label>
                            <input type="text" placeholder="ราคาทุน" class="form-control" value="{{ $data->cost }}" name="product_cost">
                        </div>  
                        @error('product_cost')
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button class="btn-close" data-bs-dismiss="alert"></button>
                                {{$message}}
                            </div>
                        @enderror
        
                        <div class="my-3">
                            <label for="product_amount" class="form-label">จำนวนคงเหลือ : </label>
        
                            <input type="text" placeholder="จำนวนคงเหลือ" class="form-control" value="{{ $saveMode == true ? $data->Quantity:$data->Quantity+1}}" name="product_amount">
        
                        </div>
                        @error('product_amount')
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button class="btn-close" data-bs-dismiss="alert"></button>
                                {{$message}}
                            </div>
                        @enderror
        
                
        
                    </form>
                </div>
                <div class="card-footer">
                    <div class=" d-flex gap-1 justify-content-start">
                        <button type="submit" form="saveProduct" class="btn btn-success">บันทึก</button>

                        <div class="ms-auto">
             {{--                <a href="{{route('productBarcode', ['id' => $serial])}}" class="btn btn-primary ">Barcode</a> --}}
                            <a href="#" onclick="confirm('{{$data->serial}}')" class="btn btn-danger">ลบสินค้า</a>
                        </div>

                    </div>
                </div>
            </div>
            
        </section>


    </div>



@endsection

@section('footer')
<script>
    const confirm = (serial) =>{
        Swal.fire({
            title: 'ต้องการที่จะลบสินค้าหรือไม่?',
            text: "คุณต้องการที่จะลบสินค้า {{$data->name}} หรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'แน่นอน'
        }).then((result) => {
            if (result.isConfirmed) {
               /*  window.location.href = ` {{ URL::to('/product/db/delete/${serial}') }} `; */
               $("#deleteForm").submit()
            }
        })
    }
</script>
@endsection