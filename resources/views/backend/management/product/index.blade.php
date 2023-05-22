@extends('layouts.app')

@section('content')
    <div class="container mt-3 py-2 ">
        <header>
            <div class="d-flex justify-content-between">
                <h1 class="h2">ผู้ใช้ : {{@session('management:name')}}</h1>
                <div>
                    <a class="btn btn-success ms-2" href="#"  data-bs-toggle="modal" data-bs-target="#addProduct"><i class="fa-solid fa-plus"></i></a> {{-- ADD USER --}}
                </div>
            </div>
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

                <section class="px-lg-3 table-responsive">
                    <table class="table table-striped dt-responsive display nowrap" cellspacing="0">
                        <thead>
                            <th>#</th>
                            <th>จำนวนสินค้าในสต๊อก</th>
                            <th>จำนวนสินค้าในสต๊อก</th>
                            <th>จำนวนในสต๊อก</th>
                            <th>ยอดขาย</th>
                            <th>อื่นๆ</th>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{$product->serial}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>@convertToBath($product->price)</td>
                                    <td>@formatNumber($product->Quantity)</td>
                                    <td>@formatNumber($product->sold)</td>
                                    <td><a href="{{route('admin.managements.product.view', $product->serial)}}" class="btn btn-primary">แก้ไข</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('footer')
<div class="modal fade " id="addProduct" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มสินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.managements.product_add')}}" method="post" id="addProductForm" enctype="multipart/form-data">
                    @csrf
                    <section> {{-- PRODUCT SERIAL --}}
                        <label for="product_serial" class="mb-1">รหัสสินค้า : </label>
                        <input type="text" class="form-control mb-2  @error('product_serial') is-invalid @enderror" name="product_serial" placeholder="รหัสสินค้า" required>
                        
                        @error('product_serial')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            <script>
                                $(document).ready(()=>{
                                    $('#addProduct').modal('show');
                                })
                            </script>
                        @enderror
                    </section>
                    <section> {{-- PRODUCT NAME --}}
                        <label for="product_name" class="mb-1">ชื่อสินค้า : </label>
                        <input type="text" class="form-control mb-2  @error('product_name') is-invalid @enderror" name="product_name" placeholder="ชื่อสินค้า" required>
                        
                        @error('product_name')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            <script>
                                $(document).ready(()=>{
                                    $('#addProduct').modal('show');
                                })
                            </script>
                        @enderror
                    </section>
                    <section> {{-- PRODUCT PRICE --}}
                        <label for="product_price" class="mb-1">ราคาสินค้า : </label>
                        <input type="number" class="form-control mb-2  @error('product_price') is-invalid @enderror" name="product_price" placeholder="ราคาสินค้า" required>
                        
                        @error('product_price')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            <script>
                                $(document).ready(()=>{
                                    $('#addProduct').modal('show');
                                })
                            </script>
                        @enderror
                    </section>
                    <section> {{-- PRODUCT COST --}}
                        <label for="product_cost" class="mb-1">ราคาทุน : </label>
                        <input type="number" class="form-control mb-2  @error('product_cost') is-invalid @enderror" name="product_cost" placeholder="ราคาทุน" required>
                        
                        @error('product_cost')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            <script>
                                $(document).ready(()=>{
                                    $('#addProduct').modal('show');
                                })
                            </script>
                        @enderror
                    </section>
                    <section> {{-- PRODUCT STOCK --}}
                        <label for="product_Quantity" class="mb-1">จำนวนสินค้าในสต๊อก : </label>
                        <input type="number" class="form-control mb-2  @error('product_Quantity') is-invalid @enderror" name="product_Quantity" placeholder="จำนวนสินค้าในสต๊อก" required>
                        
                        @error('product_Quantity')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            <script>
                                $(document).ready(()=>{
                                    $('#addProduct').modal('show');
                                })
                            </script>
                        @enderror
                    </section>

  {{--                   <section>
                        <label for="product_image" class="form-label">รูปสินค้า :</label>
                        <input type="hidden" name="product_image_old">
                        <input 
                            type="file" 
                            class="form-control" 
                            name="product_image"
                            accept="image/png, image/jpeg"
                        >
                    </section> --}}
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="addProductForm">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>
<script>
        $(document).ready( function () {
            $('table').DataTable({
                order: [[4, 'desc']],
            });
        } );
</script>
@endsection