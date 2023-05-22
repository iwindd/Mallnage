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

    </style>

    <div class="container  mt-3 p-2">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        ชื่อผู้รับเงิน
                    </div>
                    <div class="card-body">
                        <form action="{{route('historyRealReceipt')}}" method="post" id="applyForm">
                            @csrf
                            <input type="hidden" name="id" value="{{$id}}">
                            <input type="text" class="form-control" name="name" placeholder="ชื่อผู้รับเงิน" required>
                        </form>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-success" type="submit" form="applyForm">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@endsection

