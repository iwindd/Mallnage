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



    <div class="container mt-3 py-2 ">
        <header>
            <div class="d-flex justify-content-between">
                <h1 class="h2">ผู้ใช้ : {{@session('management:name')}}</h1>
                <div>
                    <a class="btn btn-success ms-2" href="#"  data-bs-toggle="modal" data-bs-target="#addReceipt"><i class="fa-solid fa-plus"></i></a> {{-- ADD USER --}}
                </div>
            </div>
            <hr>
        </header>

        <div class="row">
            <div class="col-sm-12 col-lg-3 mb-3">
                @include('backend.management.layouts.menu')
            </div>
            <div class="col-sm-12 col-lg-9 pe-4">
                @if (session('alert'))
                    <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show">
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                        {{ session('alert') }}
                    </div>
                @endif

                <section class="px-lg-3 table-responsive">
                    <table class="table table-striped dt-responsive display nowrap" cellspacing="0">
                        <thead>
                            <th class="w-10">#</th>
                            <th>รายละเอียด</th>
                            <th>ราคา</th>
                            <th>วันที่</th>
                        </thead>
                        <tbody>
                            @foreach ($receipts as $receipt)
                                <tr>
                                    <td>{{$receipt->id}}</td>
                                    <td>{{$receipt->description}}</td>
                                    <td>{{$receipt->price}}</td>
                                    <td>{{DateThai($receipt->created_at)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('footer')
<div class="modal fade " id="addReceipt" tabindex="-1" data-bs-focus="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มใบกำกับภาษี</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{route('admin.managements.receipt.insert')}}" method="post" id="addReceiptForm">
                    @csrf
                    <label for="description">ชื่อ / รายละเอียด</label>
                    <input type="text" name="description" id="description" max="255" class="form-control">

                    <label for="price" class="mt-2">ราคา</label>
                    <input type="number" name="price" id="price" class="form-control" min="0" max="1000000">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" form="addReceiptForm">เพิ่ม</button>
            </div>
        </div>
    </div>
</div>
@endsection