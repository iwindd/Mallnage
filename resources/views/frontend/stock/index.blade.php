@extends('layouts.app')

@section('content')


    <link rel="stylesheet" href="{{asset('css/selectize.bootstrap3.min.css')}}">
    <script src="{{asset('js/selectize.min.js')}}"></script>

    <style>
        .card-header {
            height: 250px;
            background-size: 60%;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .option{
            cursor: pointer;
        }
    </style>

    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">สินค้า</li>
            </ol>
        </div>
    </nav>
    
    @if (session('randSerial'))
        <form action="{{route('product_add')}}" method="post" id="quickStore___Form">
            @csrf
            <input type="hidden" name="product_serial" value="{{session('randSerial')}}">
            <input type="hidden" name="retail" value="{{$isRetail}}">
        </form>

        <script>
            $(document).ready(() => {
                $('#quickStore___Form').submit();
            })
        </script>

    @endif

    <div class="container  mt-3 pt-2">
        <header>
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 d-flex align-items-center">
                    <h1 class="h2">สินค้า</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="col-sm-12 col-md-5 col-lg-4 mb-2">
                            <select name="filter" id="filter" class="form-select">
                                <option value="all" @if ($_filter == "all") selected @endif>ทั้งหมด</option>
                                <option value="1" @if ($_filter == "1") selected @endif>สินค้าที่คงเหลือ</option>
                                <option value="2" @if ($_filter == "2") selected @endif>สินค้าที่หมดแล้ว</option>
                                <option value="3" @if ($_filter == "3") selected @endif>สินค้าที่ถูกค้าง</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-8 d-flex">
                            <div class="flex-grow-1">
                                <input type="text" class="form-control search" placeholder="ค้นหา" value="{{$_search}}">
                            </div>

                            <div class="w-auto">
                                <a class="btn btn-primary ms-2 search">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </a> 
                            </div>
                            <div>
                                <a class="btn btn-success ms-2 text-nowrap"  data-bs-toggle="modal" data-bs-target="#addProduct">
                                    <i class="fa-solid fa-plus"></i>
                                    เพิ่มสินค้า
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <hr>

        @if (session('status') && session('added') !== true)
            <div class="alert alert-success alert-dismissible fade show">
                <button class="btn-close" data-bs-dismiss="alert"></button>
                {{ session('status') }}
            </div>
        @endif
        @php
            function formatStr($string, $num, $concat)
            {
                if (strlen($string) > $num) {
                    $string = mb_substr($string, 0, $num) . $concat;
                }
            
                return $string;
            }
            
        @endphp
        @if (count($products) > 0)
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ชื่อสินค้า</th>
                        <th>ประเภทสินค้า</th>
                        <th>ราคา</th>
                        <th>จำนวน</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($products as $product)
                    
                        <tr>
                            @php
                                $name = $product->name;
                                $serial = $product->serial;
                                
                                $name = formatStr($name, 100, '...');
                                $serial = formatStr($serial, 10, '...');
                            @endphp
                            <td title="{{ $product->serial }}">{{ $serial }}</td>
                            <td title="{{ $product->name }}">{{ $name }}</td>
                            <td>{{isset($product->category_name) ? $product->category_name:'ไม่มีประเภท'}}</td>
                            <td>@convertToBath($product->price)</td>
                            <td>@formatNumber($product->Quantity)</td>
                            <td>

                                <a href="{{
                                    route('productEdit', [
                                        'serial' => $product->serial,
                                        'retail' => $isRetail
                                    ])
                                }}" class="redirect btn btn-primary text-nowrap">
                                    <i class="fa-solid fa-pencil"></i>
                                    แก้ไข
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        @else
            <h2 class="text-center m-5 h3">ไม่พบสินค้า</h2>
        @endif
    </div>
@endsection

@section('footer')
    <div class="modal fade " id="addProduct" tabindex="-1" data-bs-focus="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มสินค้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('product_add') }}" id="customAddForm" method="post">
                        @csrf
                        <input type="hidden" name="retail" value="{{$isRetail}}">
                        <input type="hidden" name="product_serial" id="customAdd">
                    </form>
                    <form action="{{ route('product_add') }}"method="post" id="addProductForm">
                        @csrf
 
                        <input type="hidden" name="retail" value="{{$isRetail}}">
        
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
                                });


                                selectize = $('#product_serial').selectize({
                                    sortField: 'text',
                                    options: items,
                                    labelField: 'name',
                                    searchField: ['serial', 'name'],
                                    sortField: 'name',
                                    create: function (input) {
                                        $('#customAdd').val(input);
                                        $('#customAddForm').submit();
                                    },

                                });
                            });
                        </script>

                        
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
                    <form action="{{route('product_quickadd')}}" method="post" id="quickAddForm">
                        @csrf
                        <input type="hidden" name="retail" value="{{$isRetail}}">
                    </form>
                    <button type="button" class="btn btn-secondary float-start" data-apply-form="quickAddForm">เพิ่มสินค้าทันที</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" data-apply-form="addProductForm">เพิ่ม</button>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        $('.redirect').on('click', function(e) {
            e.preventDefault();
            setcookie('redirect_route', 'product', 30, "/");
            window.location.href = $(this).attr('href');
        })

        $('#addProduct').on('shown.bs.modal', function() {
            setcookie('redirect_route', 'product', 30, "/");

            if (selectize) {
                const selectize2 = selectize[0].selectize;
                selectize2.focus();

            }

        })
    </script>

    <form action="{{route('product')}}" id="filterSearchForm" method="get">
        <input type="hidden" name="filter" id="filterInput" value="__none">
        <input type="hidden" name="search" id="searchInput" value="">
        <input type="hidden" name="retail" value="{{$isRetail}}">
    </form>

    <script>
        const filter = (e) => {
            const _SV      = $('input.search').val();
            const _FV      = $('select#filter').find('option:selected').val();
            const SV  = _SV == null ? '__none':_SV;
            const FV  = _FV == null ? '__none':_FV;

            $('#searchInput').val(SV);
            $('#filterInput').val(FV);

            $('#filterSearchForm').submit();
        }
        

        $('input.search').on('keypress', (e) => {
            /* ENTER TO SEARCH */
            if (e.which === 13) {
                filter({
                    type: 'click'
                })
            }
        })


        $('select#filter').on('change', filter)
        $('.btn.search').on('click', filter)

    </script>
@endsection
