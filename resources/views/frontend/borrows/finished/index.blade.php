@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>

    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{route('borrows')}}" class="text-decoration-none">การเบิก</a></li>
                <li class="breadcrumb-item active" aria-current="page">การเบิกที่เสร็จสิ้นแล้ว</li>
            </ol>
        </div>
    </nav>

    <div class="container mt-3 pt-2">
        <header>
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-between">
                
                    <div>
                        <h1 class="h2">การเบิก</h1>
                    </div>
                    <div >
                        <form action="{{route('borrowsFetchSummary')}}" method="POST" class="d-flex gap-2" >
                            @csrf
                            <div><input class="form-control" id="chooseDate" type="date" name="date" min="{{auth()->user()->created_at->toDateString('Y-m-d')}}"  max="{{ now()->toDateString('Y-m-d') }}"" required></div>
                            <div><input type="submit" class="btn btn-primary" value="สรุปผล" >  </div>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <hr>


        <style>
            .aSubmitBtn{
                background: none;
                border: none;
                outline: none;
                transition: color 0.1s;
            }

            .aSubmitBtn:hover{
                color: #0d6efd;
            }
        </style>


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
        <div class="row">
            <div class="col-12">

                @if (!$getData)
                    <form  class="d-flex justify-content-center">
                        <input type="hidden" name="get" value="1">
                        <input type="submit" class="mt-5 aSubmitBtn" value="โหลดข้อมูลเพิ่มเติม">
                    </form>
                @else
                    @if (isset($data) && count($data) > 0)
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ชื่อสินค้า</th>
                                    <th>จำนวนสินค้า</th>
                                    <th>หมายเหตุ</th>
                                    <th>สถานะ</th>
                                    <th>เบิกวันที่</th>
                                    <th>เสร็จสิ้นวันที่</th>
                                    <th>เครื่องมือ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $borrow)
                                    <tr>
                                        <td>{{$borrow->name}}</td>
                                        <td>@formatNumber($borrow->quantity)</td>
            
                                        <td>{{empty($borrow->note2) ? '-':formatStr($borrow->note2, 15, '..')}}</td>
                                        <td>เสร็จสิ้นแล้ว</td>
                                        <td title="วว/ดด/ปป">@formatDateAndTime($borrow->created_at) </td>
                                        <td title="วว/ดด/ปป">@formatDateAndTime($borrow->updated_at) </td>
                                        <td>
                                            <a href="{{route('borrowsFinishedView', ['borrowsId' => $borrow->id])}}" class="btn btn-primary">จัดการ</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $data->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="text-center mt-3"> 
                            <h6>ไม่พบข้อมูล</h6>
                        </div>
                    @endif
                @endif

            </div>
        </div>



        <script>
                    

/*             $(document).ready(() => {
                  const startAccount = $('#chooseDate').attr('created_at');
                  const startAccountDate = new Date(startAccount);
                  const toDayDate        = new Date();

                  function formatDate(date) {
                      var d = new Date(date),
                          month = '' + (d.getMonth() + 1),
                          day = '' + d.getDate(),
                          year = d.getFullYear();

                      if (month.length < 2) 
                          month = '0' + month;
                      if (day.length < 2) 
                          day = '0' + day;

                      return [year, month, day].join('-');
                  }

                  $('#chooseDate').attr('min', formatDate(startAccountDate));
                  $('#chooseDate').attr('max', formatDate(toDayDate));

              })  */
          </script>
    </div>
@endsection

