@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{route('borrows')}}" class="text-decoration-none">การเบิก</a></li>
                <li class="breadcrumb-item active" aria-current="page">กำลังดำเนินการ</li>
            </ol>
        </div>
    </nav>

    <div class="container mt-3 pt-2">
        <header>
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-between">
                    <h1 class="h2">การเบิก</h1>
 
                </div>
            </div>
        </header>
        <hr>
        @if (session('status'))
            <div class="alert alert-{{ session('class') }} alert-dismissible fade show">
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
        @if (count($borrows) > 0)
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>ชื่อสินค้า</th>
                        <th>จำนวนสินค้า</th>
                        <th>หมายเหตุ</th>
                        <th>สถานะ</th>
                        <th>วันที่</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrows as $borrow)
                        <tr>
                            <td>{{$borrow->name}}</td>
                            <td>@formatNumber($borrow->quantity)</td>

                            <td>{{empty($borrow->note) ? '-':formatStr($borrow->note, 15, '..')}}</td>
                            <td>{{$borrow->status == 0 ? 'กำลังดำเนินการ':'สิ้นสุดแล้ว'}}</td>
                            <td title="วว/ดด/ปป">@formatDateAndTime($borrow->created_at) </td>
                            <td>
                                <a href="{{route('borrowsInProcessView', ['borrowsId' => $borrow->id])}}" class="btn btn-primary">จัดการ</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                {{ $borrows->links('pagination::bootstrap-4') }}
            </div>
        @else
            <h2 class="text-center m-5 h3">ไม่พบรายการเบิก</h2>
        @endif
    </div>
@endsection

