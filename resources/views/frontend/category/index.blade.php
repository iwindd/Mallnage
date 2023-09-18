@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">ประเภทสินค้า</li>
            </ol>
        </div>
    </nav>

    <div class="container  mt-3 pt-2">
        <header>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 d-flex align-items-center">
                    <h1 class="h2">ประเภทสินค้า</h1>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="row">
                        <div class="col-sm-12 d-flex">
                            <div class="flex-grow-1">
                                <form action="{{route('categories')}}" method="get" id="searchForm">
                                    <input type="text" name="search" class="form-control search float-end" value="{{$_search}}" placeholder="ค้นหา"> 
                                </form>
                            </div>

                            <div class="w-auto">
                                <button type="submit" form="searchForm" class="btn btn-primary ms-2 search">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button> 
                            </div>
                            <div>
                                <a class="btn btn-success ms-2 text-nowrap"  data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    <i class="fa-solid fa-plus"></i>
                                    เพิ่มประเภทสินค้า
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <hr>

        @if (session('status') && session('added') !== true)
            <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show">
                <button class="btn-close" data-bs-dismiss="alert"></button>
                {{ session('status') }}
            </div>
        @endif


        @if (count($categories) > 0)
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>ชื่อประเภท</th>
                        <th>วันที่เพิ่ม</th>
                        <th>จำนวนสินค้ารวมคงเหลือ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td >{{ $category['category_name'] }}</td>
                            @php
                                //format to thai date
                                $category['created_at'] = date('d/m/Y', strtotime($category['created_at']));
                            @endphp
                            <td title="วว/ดด/ปป">{{$category['created_at']}}</td>
                            @php
                                $category['total_quantity'] = number_format($category['total_quantity']);
                            @endphp
                            <td>{{$category['total_quantity']}}</td>
                            <td>
                                <a href="{{
                                    route('categoriesEdit', [
                                        'id' => $category['id']
                                    ])
                                }}" class="btn btn-primary text-nowrap">
                                    <i class="fa-solid fa-pencil"></i>
                                    แก้ไข
                                </a>
                                <a href="{{
                                    route('categoriesPDF', [
                                        'id' => $category['id']
                                    ])
                                }}" 
                                
                                target="_blank"
                                class="btn btn-primary text-nowrap">
                                   <i class="fa-solid fa-file-export"></i>
                                    PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                {{ $categories->links('pagination::bootstrap-4') }}
            </div>
        @else
            <h2 class="text-center m-5 h3">ไม่พบประเภทสินค้า</h2>
        @endif
    </div>
@endsection

@section('footer')
    <div class="modal fade " id="addCategoryModal" tabindex="-1" data-bs-focus="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มประเภทสินค้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('categoriesStore') }}"method="post" id="addCategory">
                        @csrf
 
                        <label for="category_name">ชื่อประเภทสินค้า : </label>
                        <input type="text" class="mt-2 form-control" max="50" name="category_name" placeholder="..." required>

                        
                        @if (session('status') && session('added') === true)
                            <div class="alert alert-success alert-dismissible fade show">
                                <button class="btn-close" data-bs-dismiss="alert"></button>
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('added') === true)
                            <script>
                                $(document).ready(() => {
                                    $('#addCategoryModal').modal('show');
                                })
                            </script>
                        @endif
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" data-apply-form="addCategory">เพิ่ม</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('keydown', (e) => {
            /* REFRESH FIX */
            e = e || window.event;
            if (e.which == 116) {
                e.preventDefault();
                window.location.href = `{{ route('categories') }}`;
            }
        })
    </script>

@endsection
