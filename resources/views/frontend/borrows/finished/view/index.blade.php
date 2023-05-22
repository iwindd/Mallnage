@extends('layouts.app')



@section('content')
<nav aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{route('borrows')}}" class="text-decoration-none">การเบิก</a></li>
            <li class="breadcrumb-item"><a href="{{route('borrowsFinished')}}" class="text-decoration-none">การเบิกที่เสร็จสิ้นแล้ว</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายการเบิกที่เสร็จสิ้นแล้ว</li>
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
            <div class="col-md-6 ">
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
                                    เสร็จสิ้นแล้ว
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
            <div class="col-md-6 ">
                <div class="card h-100">
                    <div class="card-header">รายละเอียดการเบิกสินค้า</div>
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
                                    {{empty($borrow->note2) ? 'ไม่มีหมายเหตุ':$borrow->note2}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 col-form-label text-md-end" >วันที่ :</div>
                                <div class="col-sm-6 col-form-label">
                                    {{$dateEnd}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 col-form-label text-md-end" >เวลา :</div>
                                <div class="col-sm-6 col-form-label">
                                    {{$timeEnd}}
                                </div>
                            </div>
          
      
                            
                
                            <div class="row mb-2">
                                <div class="col-sm-4 col-form-label text-md-end" >จบรายการทั้งหมด :</div>
                                <div class="col-sm-6 col-form-label">
                                    {{$borrow->used}}
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
                title: 'แจ้งเตือน?',
                text: "ต้องการที่จะยกเลิกรายการหรือไม่!",
                icon: 'warning',
                input: 'text',
                inputPlaceholder: 'หมายเหตุ',
                inputAttributes: {
                    autocapitalize: 'off'
                }, 
                showCancelButton: true,
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ยืนยัน'
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
