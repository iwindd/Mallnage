

@extends('layouts.app')

@php
    
    function DateThai($strDate){
        $strDate = gettype($strDate) !== 'string' ? date('y-m-d'):$strDate;

        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];

        return "$strDay $strMonthThai $strYear";
    }
@endphp

@section('content')
    <div class="container  mt-2 pt-2">
        <div class="row">
            <div class="col-sm-12 pt-2">
                <div class="row">
                    <div class="col-sm-12 col-md-9">
                        <h1 class="h2">แผนก</h1>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="d-flex justify-content-end align-items-center">
                            <a class="btn btn-success ms-2 text-nowrap"  data-bs-toggle="modal" data-bs-target="#addDepartment">
                                <i class="fa-solid fa-plus"></i>
                                เพิ่มแผนก
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                @error('departmentName')
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                        {{$message}}
                    </div>
                @enderror
                @if (session('alert'))
                    <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show">
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('alert') }}
                    </div>
                @endif
                <hr>
                <table class="table table-striped">
                    <thead>
                        <th>#ไอดี</th>
                        <th>ชื่อแผนก</th>
                        <th>เครื่องมือ</th>
                    </thead>
                    <tbody>
                        @foreach ($items as $department)
                            <tr>
                                <td>{{$department->id}}</td>
                                <td>{{$department->label}}</td>
                                <td>
                                    <a class="btn btn-primary ms-2 text-nowrap editDepartmentbtn"   data-bs-toggle="modal" data-departId="{{$department->id}}" data-dapartName="{{$department->label}}" data-bs-target="#editDepartment">
                                        <i class="fa-solid fa-pen"></i>
                                        แก้ไข
                                    </a>
                                    <a class="btn btn-danger ms-2 text-nowrap deleteDepartment"  data-bs-toggle="modal" data-departId="{{$department->id}}" >
                                        <i class="fa-solid fa-trash"></i>
                                        ลบ
                                    </a>
                                    <form action="{{route('admin.departments.delete')}}" id="deleteForm" method="post">
                                        @csrf
                                        <input type="hidden" class="targetClass" name="target">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  
@endsection

@section('footer')

    <div class="modal fade " id="addDepartment" tabindex="-1" data-bs-focus="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มแผนก</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.departments.add')}}" method="POST" id="addDepartmentForm">
                        @csrf
                        <label for="department_name" class="mb-2">ชื่อแผนกที่ต้องการจะเพิ่ม : </label>
                        <input type="text" placeholder="ชื่อแผนก" name="departmentName" class="form-control">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" form="addDepartmentForm">เพิ่ม</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade " id="editDepartment" tabindex="-1" data-bs-focus="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขแผนก</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.departments.edit')}}" method="POST" id="editForm">
                        @csrf
                        <input type="hidden" name="target" class="targetClass">
                        <label for="department_name" class="mb-2">ชื่อที่ต้องการจะเปลี่ยน : </label>
                        <input type="text" placeholder="ชื่อแผนก" name="departmentName" id="departCurrentName" class="form-control">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success" form="editForm">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function () {
            $('table').DataTable();

            $('.deleteDepartment').on('click', function(){
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: "คุณต้องการที่จะลบสินค้าออกจากตะกร้าหรือไม่!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonText: 'แน่นอน'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const item = $(this).attr('data-departId');
                        $(".targetClass").val(item);
                        $("#deleteForm").submit(); 
                    }
                })
            })

            $('.editDepartmentbtn').on('click', function(){
                const item = $(this).attr('data-departId');
                const label = $(this).attr('data-dapartName');

                console.log(label)
                $(".targetClass").val(item);
                $("#departCurrentName").val(label);
            })
        });


    </script>


@endsection

