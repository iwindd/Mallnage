@extends('layouts.app')

@section('content')


    <div class="container  mt-3 pt-2">
        <header>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 d-flex align-items-center">
                    <h1 class="h2">พนักงาน</h1>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="row">
                        <div class="col-sm-12 d-flex">
       

                            <div class="ms-auto">
                                <a class="btn btn-success ms-2 text-nowrap" href="{{route('employeesAdd')}}"> 
                                    <i class="fa-solid fa-plus"></i>
                                    เพิ่มพนักงาน
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <hr>
        @if (session('status'))
            <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show">
                <button class="btn-close" data-bs-dismiss="alert"></button>
                {{ session('status') }}
            </div>
        @endif
        @if (count($employees) > 0)
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>ชื่อพนักงาน</th>
                        <th>ชื่อผู้ใช้</th>
                        <th>วันที่เริ่มทำงาน</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{$employee->fullname}}</td>
                            <td>{{$employee->username}}</td>
                            <td>{{$employee->created_at}}</td>
                            <td>
                                <a href="{{route('employeesManage', ['id' => $employee->id])}}" class="btn btn-primary">จัดการ</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <h2 class="text-center m-5 h3">ไม่พบพนักงาน</h2>
        @endif
    </div>
@endsection
