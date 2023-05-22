

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
    <div class="container  mt-2 pt-2">
        <div class="row">
            <div class="col-sm-12 pt-2">
                <div class="row">
                    <div class="col-sm-12 col-md-9">
                        <h1 class="h2">ผู้ใช้ทั้งหมด</h1>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <select name="filter" id="filter" class="form-select">
                            <option value="1" @php if ($t == 1) { echo 'selected'; } @endphp>ทั้งหมด</option>
                            <option value="2" @php if ($t == 2) { echo 'selected'; } @endphp>กำลังใช้งาน</option>
                            <option value="3" @php if ($t == 3) { echo 'selected'; } @endphp>ขอการเข้าใช้งาน</option>
                            <option value="4" @php if ($t == 4) { echo 'selected'; } @endphp>หมดอายุการใช้งาน</option>
                            <option value="5" @php if ($t == 5) { echo 'selected'; } @endphp>ถูกระงับการใช้งาน</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="col-sm-12">
                <hr>
                <table class="table table-striped" id='users'>
                    <thead>
                        <th>ชื่อผู้ใช้งาน</th>
                        @if ($t == 1)
                            <th>อนุมัติเข้าใช้งาน</th>
                        @endif
                        <th>ชื่อร้านค้า</th>
                        <th>ระดับผู้ใช้งาน</th>
                        @if ($t != 3)
                            <th>อายุการใช้งาน</th>
                        @else
                            <th>เบอร์โทรศัพท์</th>
                            <th>LINE ID</th>
                        @endif
                        <th>เครื่องมือ</th>
                    </thead>
                    <tbody>
                        @foreach ($result as $user)
                            <tr>
                                <td>{{$user->username}}</td>
                                @if ($t == 1)
                                    @if ($user->allowed == 0)
                                        <td>อนุมัติ</td>
                                    @else
                                        <td>ไม่อนุมัติ</td>
                                    @endif
                                @endif
                                <td>{{$user->name}}</td>
                                <td>
                                    @php
                                        $grade = $user->grade;
                                        
                                        if ($grade >= 1){
                                            echo 'Pro';
                                        }else{
                                            echo 'Basic';
                                        }
                                    @endphp

                                </td>
                                @if ($t != 3)
                                    <td title="{{$user->accountAge}}">
                                        @php
                                            $now      = new DateTime();
                                            $age = new DateTime($user->accountAge);
                                            $format = $age->diff($now);

                                            $ts_now = $now->getTimestamp();
                                            $ts_age = $age->getTimestamp();
                                            $noTime = ($ts_age-$ts_now) <= 0 ? true:false;

                                            if ($t != 3) {
                                                if (!$noTime){
                                                    echo DateThai($user->accountAge); 
                                                }else{
                                                    echo '<span class="text-danger">หมดอายุการใช้งาน</span>';
                                                }
                                            }
                                        @endphp
                                    </td>
                                @else
                                    <td>{{$user->tel}}</td>
                                    <td>{{$user->lineId}}</td>
                                @endif
                                <td>
                                    <a  href="{{route('admin.managements', ['id' => $user['id']])}}"  class="btn btn-primary">แก้ไข</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <form id="filterSearchForm" method="get">
        <input type="hidden" name="t" id="filterInput" value="__none">
    </form>
@endsection

@section('footer')

<script>
    const filter = (e) => {
        const _FV      = $('select#filter').find('option:selected').val();
        const FV  = _FV == null ? '__none':_FV;

        $('#filterInput').val(FV);
        $('#filterSearchForm').submit();
    }

    $(document).ready(()=>{
        $('table#users').DataTable();
    })

    $('select#filter').on('change', filter)

</script>

@endsection

