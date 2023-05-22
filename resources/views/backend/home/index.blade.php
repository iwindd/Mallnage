@extends('layouts.app')

@section('content')
    <style>
        .card{
            transition: 0.05s linear;
            cursor: pointer;
        }
        .card:hover{
            background: rgb(236, 236, 236);
        }

        .row > div{
            margin-bottom: 1em;
        }
    </style>
    <div class="container my-3 py-3">
        <form action="{{route('admin.users')}}" method="get" id="users"><input type="hidden" name="t" value="1"></form>
        <form action="{{route('admin.users')}}" method="get" id="request"><input type="hidden" name="t" value="2"></form>
        <form action="{{route('admin.users')}}" method="get" id="allowed"><input type="hidden" name="t" value="3"></form>
        <form action="{{route('admin.users')}}" method="get" id="banned"><input type="hidden" name="t" value="4"></form>
        <form action="{{route('admin.departments')}}" method="get" id="departments"></form>
        
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="card h-100" data-apply-form="users">
                    <div class="card-header" style="background: #f39c12 !important; color: white;">
                        ผู้ใช้ทั้งหมด
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>ผู้ใช้ทั้งหมด @formatNumber($users) รายการ</p>
                            <footer class="blockquote-footer">ผู้ใช้ทั้งหมดภายในระบบ</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="card h-100" data-apply-form="request">
                    <div class="card-header" style="background: #a0b92a !important; color:white;">
                        กำลังใช้งาน
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>ผู้ใช้ที่กำลังใช้งานระบบมีทั้งหมด @formatNumber($allowed) รายการ</p>
                            <footer class="blockquote-footer">ผู้ใช้ที่กำลังใช้งานระบบทั้งหมด</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="card h-100" data-apply-form="allowed" >
                    <div class="card-header" style="background: #605ca8 !important; color:white;">
                        การขอเข้าใช้งาน
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>ผู้ใช้ที่กำลังขอเข้าใช้งานระบบมีทั้งหมด @formatNumber($unallowed) รายการ</p>
                            <footer class="blockquote-footer">ผู้ใช้ที่กำลังขอเข้าใช้งานระบบทั้งหมด</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="card h-100" data-apply-form="banned">
                    <div class="card-header" style="background: #dd4b39 !important; color:white;">
                        การถูกระงับการใช้งาน
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>ผู้ใช้ที่ถูกระงับการใช้งานมีทั้งหมด @formatNumber($banned) รายการ</p>
                            <footer class="blockquote-footer">ถูกระงับการใช้งาน / หมดอายุการใช้งาน</footer>
                        </blockquote>
                    </div>
                </div>
                
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="card h-100" data-apply-form="departments">
                    <div class="card-header" style="background: #3972dd !important; color:white;">
                        แผนก
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>ขณะนี้มีแผนกทั้งหมด @formatNumber($departments) รายการ</p>
                            <footer class="blockquote-footer">แผนกทั้งหมด</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')



@endsection

