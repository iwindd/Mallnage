@extends('layouts.app')
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
@section('content')
<div class="container mt-3 py-3">
    <form action="{{route('employees')}}" method="get" id="employees"></form>
    <form action="{{route('report')}}" method="get" id="report"></form>
    <form action="{{route('receipt')}}" method="get" id="receipt"></form>
    <form action="{{route('categories')}}" method="get" id="categories"></form>
    <form action="{{route('trade')}}" method="get" id="tradeForm"></form>

    @if (session('status'))
    <div class="alert alert-{{ session('class') }} alert-dismissible fade show">
        <button class="btn-close" data-bs-dismiss="alert"></button>
        {{ session('status') }}
    </div>
    @endif

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card h-100" data-apply-form="employees">
                <div class="card-header" style="background: #f39c12 !important; color: white;">
                    พนักงาน
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>มีพนักงานทั้งหมด @formatNumber($employees) คน</p>
                        <footer class="blockquote-footer">พนักงานของคุณ</footer>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card h-100" data-apply-form="report">
                <div class="card-header" style="background: #a0b92a !important; color:white;">
                    รายงาน
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>มีการซื้อขายไปแล้ว @formatNumber($histories) รายการ</p>
                        <footer class="blockquote-footer">รายงานบัญชี</footer>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card h-100" data-apply-form="receipt" >
                <div class="card-header" style="background: #605ca8 !important; color:white;">
                    ใบเสร็จของฉัน
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>มีใบเสร็จทั้งหมด @formatNumber($receipt) รายการ</p>
                        <footer class="blockquote-footer">รายการใบเสร็จ</footer>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card h-100" data-apply-form="categories">
                <div class="card-header" style="background: #dd4b39 !important; color:white;">
                    ประวัติการซื้อขาย
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>มีประเภทสินค้าทั้งหมด @formatNumber($categories) รายการ</p>
                        <footer class="blockquote-footer">ประเภทสินค้า</footer>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card h-100" data-apply-form="">
                <div class="card-header" style="background: #3972dd !important; color:white;">
                    สรุปผล
                </div>
                <div class="card-body">

                    <blockquote class="blockquote mb-0">
                        <p class="my-0">    
                            <form action="{{route('productSummary')}}" class="d-flex gap-2" method="post" id="summary">
                                @csrf
                                
                                <input type="date" class="form-control" min="{{auth()->user()->created_at->toDateString('Y-m-d')}}" name="date" id="selectDate" max="{{ now()->toDateString('Y-m-d') }}" required>
                                <input type="submit" value="สรุปผล" class="btn btn-primary">
                            </form>
                        </p>
                        <footer class="blockquote-footer">
                            สรุปการขายภายในร้าน
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 ">
            <div class="card h-100" data-apply-form="categories">
                <div class="card-header" style="background: #c239dd !important; color:white;">
                    ประเภทสินค้า
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>มีประเภทสินค้าทั้งหมด @formatNumber($categories) รายการ</p>
                        <footer class="blockquote-footer">ประเภทสินค้า</footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')



@endsection

