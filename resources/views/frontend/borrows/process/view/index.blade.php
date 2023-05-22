@extends('layouts.app')



@section('content')
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{route('borrows')}}" class="text-decoration-none">การเบิก</a></li>
                <li class="breadcrumb-item"><a href="{{route('borrowsInProcess')}}" class="text-decoration-none">กำลังดำเนินการ</a></li>
                <li class="breadcrumb-item active" aria-current="page">การเบิก #{{$borrow->id}}</li>
            </ol>
        </div>
    </nav>

    <div class="container mt-3 py-2 ">
                
        <header class="d-flex justify-content-start align-items-center pe-3">
            <h1 class="h2">รายละเอียดการเบิกสินค้า</h1>
            <h2 class="h4 text-muted ms-auto">#{{$borrow->id}}</h2>
        </header>

        <hr>
        @if (session('status'))
            <div class="alert alert-{{ session('class') }} alert-dismissible fade show">
                <button class="btn-close" data-bs-dismiss="alert"></button>
                {{ session('status') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-8 mb-2">
                <div class="card">
                    <div class="card-header">ทำรายการสินค้า</div>
                    <div class="card-body">
                        <form action="{{route('borrowsWork')}}" enctype="multipart/form-data" method="POST" id="borrows_work_form" @php if($borrow->status != 0) { echo 'disabled'; } @endphp>
                            @csrf
                            <div class="row mb-3 justify-content-center">
                                <div class="col-8">
                                    
                                    <input type="hidden" name="target" value="{{$borrow->id}}">

                                    <div class="row mb-2">
                                        <div class="col-md-4 col-form-label text-md-end" >จำนวนที่จะทำรายการ</div>
                                        <div class="col-md-6">
                                            <input id="quantity" type="number" min="1" value="{{$borrow->quantity}}" @php if($borrow->status != 0) { echo 'disabled'; } @endphp max="{{$borrow->quantity}}" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required autocomplete="quantity" autofocus>
            
                                            @error('quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
    
                                    <div class="row mb-2">
                                        <div class="col-md-4 col-form-label text-md-end" >
                                            <i class="fa-solid fa-circle-info ms-1" style="color: grey;"
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="ชื่อผู้ใช้ รหัสการสั่งจอง คำอธิบาย ข้อมูล คำชี้แจงเพิ่มเติม หรือ อื่นๆ"
                                            ></i>

                                            
                                            หมายเหตุ

                       
                                        </div>
                                        <div class="col-md-6">
                                            <input id="note" type="text" min="0" max="255"placeholder="หมายเหตุ"  @php if($borrow->status != 0) { echo 'disabled'; } @endphp class="form-control @error('note') is-invalid @enderror" name="note" value="{{ old('note') }}"  autocomplete="note" autofocus>
            
                                            @error('note')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
    
                                    <div class="row mb-2">
                                        <div class="col-md-4 col-form-label text-md-end" >วิธีการชำระเงิน</div>
                                        <div class="col-md-6">
                                            <select class="form-select" name="payment" @php if($borrow->status != 0) { echo 'disabled'; } @endphp id="payment">
                                                <option value="0">เงินสด</option>
                                                <option value="1">โอน</option>
                                            </select>
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </form>
                    </div>
                    @if ($borrow->quantity > 0)
                        <div class="card-footer">
                            <button type="submit" class=" btn btn-success" @php if($borrow->status != 0) { echo 'disabled'; } @endphp form="borrows_work_form">
                                ทำรายการสินค้า
                            </button>
                            
                            <button type="button" id="deleteTheBorrow" @php if($borrow->status != 0) { echo 'disabled'; } @endphp class="float-end btn btn-danger" >
                                ยกเลิกการเบิก
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="card h-100">
                    <div class="card-header">รายละเอียด</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="row mb-2">
                                <div class="col-sm-4 col-form-label text-md-end" >
                                    <i class="fa-solid fa-circle-info ms-1" style="color: grey;"
                                        data-toggle="tooltip" 
                                        data-placement="top" 
                                        title="ชื่อผู้ใช้ รหัสการสั่งจอง คำอธิบาย ข้อมูล คำชี้แจงเพิ่มเติม หรือ อื่นๆ"
                                    ></i>
                                    หมายเหตุ :</div>
                                <div class="col-sm-6 col-form-label">
                                    {{empty($borrow->note) ? 'ไม่มีหมายเหตุ':$borrow->note}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 col-form-label text-md-end" >วันที่ :</div>
                                <div class="col-sm-6 col-form-label">
                                    {{$date}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 col-form-label text-md-end" >เวลา :</div>
                                <div class="col-sm-6 col-form-label">
                                    {{$time}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 col-form-label text-md-end" >สถานะ :</div>
                                <div class="col-sm-6 col-form-label">
                                    {{$borrow->status == 0 ? 'กำลังดำเนินการ':'สิ้นสุดแล้ว'}}
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-sm-4 col-form-label text-md-end" >ชื่อสินค้า :</div>
                                <div class="col-sm-6 col-form-label">
                                    {{$borrow->name}}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-4 col-form-label text-md-end" >จำนวนสินค้า :</div>
                                <div class="col-sm-6 col-form-label">
                                    @formatNumber($borrow->quantity)
                                </div>
                            </div>
                        </div>
                    </div>
           
                </div>
            </div>

        </div>
    </div>

    <form action="{{route('borrowsClose')}}" class="d-none" id="FormCloseTheBorrows" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$borrow->id}}">
        <input type="hidden" name="notes" id="noteClose">
    </form>
@endsection

@section('footer')


<script>
    $(document).ready(() => {
        $('#deleteTheBorrow').on('click', () => {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: "ต้องการที่จะยกเลิกรายการหรือไม่ ?",
                icon: 'warning',
                input: 'text',
                inputPlaceholder: 'หมายเหตุ เช่น ชื่อผู้ใช้ รหัสการสั่งจอง หรือ อื่นๆ',
                inputAttributes: {
                    autocapitalize: 'off'
                }, 
                showCancelButton: true,
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ตกลง'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#noteClose').val(result.value);
                    const form = $(`#FormCloseTheBorrows`);

                    form.submit();
                }
            })
        })
    })
</script>
@endsection
