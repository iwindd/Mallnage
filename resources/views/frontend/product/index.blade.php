@extends('layouts.app')

@section('content')

    <style>
        .product-image{
            width: 32px;
            height: 32px;
        }

        .badge:hover{
            transition: transform 0.15s ease;
            transform: scale(1.2);
            cursor: pointer
        }

        .card-header{
            height: 18rem;
            overflow: hidden;

            background-size: 60%;
            background-repeat: no-repeat;
            background-position: center;
        }

        .card-header img{
            width: 100%;
        }



    </style>
    
    <div class="container border mt-5 pt-2">
        <header class="my-2">
            <div class="row">
                <div class="col-sm-12 col-lg-8">
                    <h1 class="h2">สินค้า</h1>
                </div>
                <div class="col-sm-12 col-lg-4">
        
                    <div class="ms-auto d-flex">

                        <input type="text" id='product-filter' placeholder="ค้นหา" class="form-control">
                        <a class="btn btn-primary ms-2" id="search-btn"><i class="fa-solid fa-magnifying-glass"></i></a> {{-- SEARCH PRODUCT --}}
                        <a class="btn btn-secondary ms-2" href="{{route('product')}}" ><i class="fa-solid fa-arrows-rotate"></i></a>
                        <a class="btn btn-success ms-2" href="{{route('productAdd')}}" onclick="add()"><i class="fa-solid fa-plus"></i></a> {{-- ADD PRODUCT --}}
                    </div>
                </div>
            </div>
        </header>
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                <button class="btn-close" data-bs-dismiss="alert"></button>
                {{ session('status') }}
            </div>
        @endif
        <hr class="my-2">

        @if (count($products) > 0)
            <div class="row">

                @foreach ($products as $product)
                    <div class="col-lg-3 col-sm-6 d-flex justify-content-center align-items-center my-2 product-columns-card-search-key" id="{{$product->product_serial}}" data-edit-product="{{$product->serial}}">
                        <div class="card text-center" style="width: 18rem;" >
                            @if($product->image !== '')
                                <div class="card-header" style="background-image: url('{{asset($product->image)}}')"></div>
                            @else
                                <div class="card-header" style="background-image: url('{{asset('image/products/default.jpg')}}')"></div>
                            @endif
                        
                            <h4 class="card-title my-2 product-item" data-search="true">{{$product->name}} </h4>
                            <div class="card-body d-flex p-0 text-muted">
                                <div class="w-50 p-2">@convertToBath($product->price)</div>
                                <div class="w-50 p-2">@formatNumber($product->Quantity) <i class="fa-solid fa-boxes-stacked ms-2"></i></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            <div>
            <div class="d-flex justify-content-center mt-3">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        @else
            <h2 class="text-center m-5 h3">ไม่พบสินค้า</h2> 
        @endif
    </div>       



@endsection

@section('footer')
    <script>
        const add = () =>{
            setcookie('redirect_route', 'productAdd', 30, "/");
        }


        const search = () =>{
            const input = $('#product-filter').val();
            if (input.length <= 0) return;          
            window.location.href = `{{ URL::to('/product/search/${input}') }}`
        }

        $('#product-filter').on('keypress', (e) => { /* ENTER TO SEARCH */
            if (e.which === 13) {
                search();
            }
        })

        $('#search-btn').on('click', () => search())

        $('[data-edit-product]').on('click', function(){
            const serial = $(this).data('edit-product');
            setcookie('redirect_route', 'product', 30, "/");
            window.location.href = ` {{ URL::to('/product/edit/${serial}') }} `;
        })

        document.addEventListener('keydown', (e) => { /* REFRESH FIX */
            e = e || window.event;
            if (e.which == 116) {
                e.preventDefault();
                window.location.href = `{{route('product')}}`;
            }
        })

    </script>
@endsection