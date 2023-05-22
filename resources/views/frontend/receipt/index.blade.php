@extends('layouts.app')

@section('content')



    <div class="container  mt-3 pt-2">
        <header>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 d-flex align-items-center">
                    <h1 class="h2">รายการใบเสร็จ</h1>
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


        @if (155 > 0)
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>รายละเอียด</th>
                        <th>ราคา</th>
                        <th>วันที่</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receipts as $receipt)
                        <tr>
                            <td>{{$receipt->description}}</td>
                            <td>@convertToBath($receipt->price)</td>
                            <td >
                                @formatDateAndTime($receipt->created_at)
                            </td>
                            <td>
                                <a href="{{route('exportReceipt', $receipt->id)}}" class="btn btn-primary">พิมพ์</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
             {{--    {{ $categories->links('pagination::bootstrap-4') }} --}}
            </div>
        @else
            <h2 class="text-center m-5 h3">ไม่พบรายการใบเสร็จ</h2>
        @endif
    </div>
@endsection

@section('footer')
@endsection
