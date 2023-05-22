@extends('layouts.app')

@section('content')
    <div class="container mt-3 py-2 ">
        <header>
            <h1 class="h2">ผู้ใช้ : {{ @session('management:name') }}</h1>
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
                        <li class="breadcrumb-item"><a href="{{route('admin.managements.product')}}" class="text-decoration-none">สินค้า</a></li>
                        <li class="breadcrumb-item active" aria-current="page">แก้ไขสินค้า</li>
                    </ol>
                </nav>

                <section>
                    <div class="card">
                        <div class="card-header">แก้ไขสินค้า</div>

                        <div class="card-body p-2">
                            <form action="{{route('admin.managements.product_edit')}}" method="post" id="editProduct" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_productSerial", value="{{$product->serial}}">
                                {{-- SERIAL --}}
                                <div class="row mb-3">
                                    <label for="serial" class="col-md-4 col-form-label text-md-end">รหัสสินค้า : </label>

                                    <div class="col-md-6">
                                        <input id="serial" type="text" value="{{$product->serial}}" placeholder="รหัสสินค้า" disabled
                                            class="form-control @error('serial') is-invalid @enderror" name="serial"
                                            required autocomplete="current-serial">

                                        @error('serial')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- NAME --}}
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">ชื่อสินค้า : </label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" value="{{$product->name}}" placeholder="ชื่อสินค้า"
                                            class="form-control @error('name') is-invalid @enderror" name="name" required
                                            autocomplete="current-name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- STOCK QUANLITY --}}
                                <div class="row mb-3">
                                    <label for="Quantity" class="col-md-4 col-form-label text-md-end">จำนวนในสต๊อก : </label>
                                    <div class="col-md-6">
                                        <input id="Quantity" type="text" value="{{$product->Quantity}}" placeholder="จำนวนในสต๊อก"
                                            class="form-control @error('Quantity') is-invalid @enderror" name="Quantity"
                                            required autocomplete="current-Quantity">
                                        @error('Quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- PRICE --}}
                                <div class="row mb-3">
                                    <label for="price" class="col-md-4 col-form-label text-md-end">ราคาสินค้า : </label>

                                    <div class="col-md-6">
                                        <input id="price" type="number" value="{{$product->price}}" placeholder="ราคาสินค้า"
                                            class="form-control @error('price') is-invalid @enderror" name="price" required
                                            autocomplete="current-price">

                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>         

                                {{-- cost --}}

                                <div class="row mb-3">
                                    <label for="cost" class="col-md-4 col-form-label text-md-end">ราคาทุน : </label>

                                    <div class="col-md-6">
                                        <input id="cost" type="number" value="{{$product->cost}}" placeholder="ราคาทุน"
                                            class="form-control @error('cost') is-invalid @enderror" name="cost" required
                                            autocomplete="current-cost">

                                        @error('cost')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>         

                                {{-- IMAGE --}}
{{--                                 <div class="row mb-3">
                                    <div class="col-md-4 col-form-image text-md-end">
                                        <div class="div float-lg-end" id="preview-image" style="width: 10rem;">
                                            <img class="col-md-4 col-form-image text-md-end" style="width: 10rem;" src="{{ asset(($product->image == '' ? 'image/products/default.jpg':$product->image )) }}" alt="" class="w-100">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="hidden" name="product_image_old" value="{{$product->image}}">
                                        <label for="product_image" class="form-label">รูปสินค้า :</label>
                                        <input 
                                            type="file" 
                                            class="form-control" 
                                            name="product_image"
                                            accept="image/png, image/jpeg"
                                        >
                                    </div>
                                </div> --}}
                            </form>
                            <form action="{{route('admin.managements.product_remove')}}" method="post" id="deleteProduct">
                                @csrf
                                <input type="hidden" name="_productSerial", value="{{$product->serial}}">
                            </form>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{route('admin.managements.product')}}" class="btn btn-secondary">ยกเลิก</a>
                                    <button class="btn btn-success" data-apply-form="editProduct">บันทึก</button>
                                </div>
                                <div>
                                    <a id='delete' class="btn btn-danger">ลบ</a>
                                </div>
                            </div>
  
                        </div>
                    </div>
            </div>
            </section>
        </div>
    </div>
    </div>
@endsection

@section('footer')
<script>
    $('#delete').on('click', ()=>{
        Swal.fire({
            title: 'ต้องการที่จะลบสินค้าหรือไม่?',
            text: "คุณต้องการที่จะลบสินค้า {{$product->name}} หรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'แน่นอน'
        }).then((result) => {
            const form = $(`#deleteProduct`);
            form.submit();
        })
            
    })
</script>
@endsection
