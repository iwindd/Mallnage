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
    
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{route('categories')}}" class="text-decoration-none">ประเภทสินค้า</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$data->category_name}}</li>
            </ol>
        </div>
    </nav>
    <div class="container  mt-1 pt-3">
        
       
        <section class="w-75 mx-auto">

  

            <div class="card">
                <div class="card-header">แก้ไขประเภทสินค้า :  <span>{{$data->category_name }}</span></div>
                <div class="card-body">
                    <form action="{{route('categoriesUpdate')}}" id="saveCategory" method="post">
                        @csrf

                        <div class="my-3">
                            <label for="category_name" class="form-label">ชื่อประเภทสินค้า : </label>
                            <input type="text" placeholder="..." class="form-control" value="{{ $data->category_name }}"  name="category_name" required maxlength="50">
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <input type="hidden" name="oldName" value="{{ $data->category_name }}">

                            @error('category_name')
                                <div class="alert alert-danger alert-dismissible fade show mt-2">
                                    <button class="btn-close" data-bs-dismiss="alert"></button>
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                    </form>
                </div>
                <div class="card-footer">
                    <div class=" d-flex gap-1 justify-content-start">
                        <button type="submit" form="saveCategory" class="btn btn-success">บันทึก</button>

                        <div class="ms-auto">
                            <a href="#" id='delete' class="btn btn-danger">ลบประเภทสินค้า</a>
                        </div>

                    </div>
                </div>
            </div>
            
        </section>


        <form action="{{route('categoriesDelete')}}" method="post" id="deleteForm">
            @csrf
            <input type="hidden" name="id" value="{{$data->id}}">
            <input type="hidden" name="name" value="{{$data->category_name}}">
        </form>

    </div>



@endsection

@section('footer')
<script>
    $(document).ready(() => {
        $('#delete').on('click', () => {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: "คุณต้องการที่จะลบประเภทสินค้า {{$data->category_name}} หรือไม่!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'แน่นอน'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm').submit();
                }
            })
        })
    })

</script>
@endsection