@extends('layouts.app')

@section('content')


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
    
    <div class="container border mt-5 d-flex pt-2">
        <section class="p-3 w-100">
            <h2>เพิ่มสินค้า</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('product')}}" class="text-decoration-none">สินค้า</a></li>
                    <li class="breadcrumb-item active" aria-current="page">เพิ่มสินค้า</li>
                </ol>
            </nav>
            <hr>
            <div>
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('status') }}
                    </div>
                @endif
                <form id="addproduct_form" action="{{route('product_add')}}" method="POST">
                    @csrf
                    <div class="input-group mb-3  mt-3">
                        <input type="text" class="form-control" name="product_serial" id="product_serial_input" placeholder="รหัสสินค้า" autofocus>
                        <input type="submit" class="btn btn-outline-success" value="เพิ่ม">
                    </div>
                    @error('product_serial')
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                        {{$message}}
                    </div>
                    @enderror
                </form>
            </div>

        </section>
    </div>



@endsection

@section('footer')
<script>

</script>
@endsection