@extends('layouts.app')

@section('content')
    <div class="container mt-3 pt-2 ">
        <header >
            <h1 class="h2">รายงาน</h1>
        </header>
        <hr>
        <div class="row mb-2">
            <div class="col-sm-12 col-md-4 col-lg-3">
                @include('frontend.report.template.menu')
            </div>
            <div class="col-sm-12 col-md-8 col-lg-9 ">
                @php
                    $totalTodayCash = $today['priceCash'] + $today2['priceCash'];
                    $totalMonthCash = $month['priceCash'] + $month2['priceCash'];
                    $totalYearCash = $year['priceCash'] + $year2['priceCash'];

                    $totalToday = $today['price'] + $today2['price'];
                    $totalMonth = $month['price'] + $month2['price'];
                    $totalYear = $year['price'] + $year2['price'];

                    $totalTodayAll = $totalTodayCash + $totalToday;
                    $totalMonthAll = $totalMonthCash + $totalMonth;
                    $totalYearAll = $totalYearCash + $totalYear;
                @endphp

                <div class="row">
                    {{-- ยอดขาย --}}
                    <div class="col-sm-12 col-lg-4 p-1">
                        <div class="card">
                            <div class="card-header">
                                ยอดขายวันนี้
                            </div>
                            <div class="card-body">
                                <span>@formatNumber($today['sold'] + $today2['sold']) ชิ้น</span>
                                <blockquote class="blockquote mb-0">
                                    <p></p>
                                    <footer class="blockquote-footer">
                                        ยอดขายทั้งหมดในวันนี้
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 p-1">
                        <div class="card">
                            <div class="card-header">
                                ยอดขายเดือนนี้
                            </div>
                            <div class="card-body">
                                <span>@formatNumber($month['sold'] + $month2['sold']) ชิ้น</span>
                                <blockquote class="blockquote mb-0">
                                    <p></p>
                                    <footer class="blockquote-footer">
                                        ยอดขายทั้งหมดในเดือนนี้
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 p-1">
                        <div class="card">
                            <div class="card-header">
                                ยอดขายปีนี้
                            </div>
                            <div class="card-body">
                                <span >@formatNumber($year['sold'] + $year2['sold']) ชิ้น</span>
                                <blockquote class="blockquote mb-0">
                                    <p></p>
                                    <footer class="blockquote-footer">
                                        ยอดขายทั้งหมดในปีนี้
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>

                    {{-- ยอดเงิน  --}}
                    <div class="col-sm-12 col-lg-4 p-1">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>ยอดเงินวันนี้</div>
                                    <div>
                                        <a href="{{ route('reportPdf') }}"><i class="fa-solid fa-file-export link-primary" id="export-pdf-today"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <span>รวม @convertToBath($totalTodayAll) </span> <br>
                                <span>เงินสด @convertToBath(($totalTodayCash)) </span><br>
                                <span>เงินโอน @convertToBath($totalToday) </span><br>
                                <blockquote class="blockquote mb-0">
                                    <p></p>
                                    <footer class="blockquote-footer">
                                        ยอดเงินทั้งหมดในวันนี้
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 p-1">
                        <div class="card">
                            <div class="card-header">
                                ยอดเงินเดือนนี้
                            </div>
                            <div class="card-body">
                                <span>รวม @convertToBath($totalMonthAll) </span> <br>
                                <span>เงินสด @convertToBath(($totalMonthCash)) </span><br>
                                <span>เงินโอน @convertToBath($totalMonth) </span><br>
                                <blockquote class="blockquote mb-0">
                                    <p></p>
                                    <footer class="blockquote-footer">
                                        ยอดเงินทั้งหมดในเดือนนี้
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 p-1">
                        <div class="card">
                            <div class="card-header">
                                ยอดเงินปีนี้
                            </div>
                            <div class="card-body">
                                <span>รวม @convertToBath($totalYearAll) </span> <br>
                                <span>เงินสด @convertToBath(($totalYearCash)) </span><br>
                                <span>เงินโอน @convertToBath($totalYear) </span><br>
                                <blockquote class="blockquote mb-0">
                                    <p></p>
                                    <footer class="blockquote-footer">
                                        ยอดเงินทั้งหมดในปีนี้
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>


                    {{-- กำไร --}}
                    <div class="col-sm-12 col-lg-4 p-1">
                        <div class="card">
                            <div class="card-header">
                                กำไรวันนี้
                            </div>
                            <div class="card-body">
                                <span>@convertToBath($today['profit'] + $today2['profit'])</span>
                                <blockquote class="blockquote mb-0">
                                    <p></p>
                                    <footer class="blockquote-footer">
                                        กำไรทั้งหมดในวันนี้
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 p-1">
                        <div class="card">
                            <div class="card-header">
                                กำไรเดือนนี้
                            </div>
                            <div class="card-body">
                                <span>@convertToBath($month['profit'] + $month2['profit'])</span>
                                <blockquote class="blockquote mb-0">
                                    <p></p>
                                    <footer class="blockquote-footer">
                                        กำไรทั้งหมดในเดือนนี้
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 p-1">
                        <div class="card">
                            <div class="card-header">
                               กำไรปีนี้
                            </div>
                            <div class="card-body">
                                <span>@convertToBath($year['profit'] + $year2['profit'])</span>
                                <blockquote class="blockquote mb-0">
                                    <p></p>
                                    <footer class="blockquote-footer">
                                        กำไรทั้งหมดในปีนี้
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <hr>

                <div class="row mb-5">
                    <div class="col-sm-12 col-md-12 col-lg-4{{--  d-flex justify-content-center align-items-center --}}">
                        <div>
                        {{--     @if (Auth::user()->grade == 1)
                                <a href="#" data-bs-target="#pdfModal" data-bs-toggle="modal" class="btn btn-primary my-2">PDF <i class="fa-solid fa-download"></i></a>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
{{--     @if (Auth::user()->grade == 1)
        <div class="modal fade " id="pdfModal" tabindex="-1" data-bs-focus="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Export PDF</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('reportPdf') }}"method="get" id="GET_PDF">
                            <select name="EXPORT_TYPE" id="EXPORT_TYPE" class="form-select">
                                <option value="default">ค่าเริ่มต้น</option>
                            </select>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary" Form="GET_PDF">EXPORT</button>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    <script> /* DATE SYSTEM */
        const getCurrentDate = () => {
            const date = new Date();

            const year = date.getFullYear();
            const day = date.getDate() <= 9 ? (`0${date.getDate()}`) : (date.getDate());
            const month = (date.getMonth()+1) <= 9 ? (`0${date.getMonth()}`) : ((date.getMonth()+1));

            return `${year}-${month}-${day}`
        }

        const getDayAgo = () => {
            const date = new Date();
            date.setDate(date.getDate() - 1);

            const year = date.getFullYear();
            const day = date.getDate() <= 9 ? (`0${date.getDate()}`) : (date.getDate());
            const month = ((date.getMonth()+1) <= 9 ? (`0${date.getMonth()}`) : ((date.getMonth()+1)));


            return `${year}-${month}-${day}`
        }

        const getDateLastest = () => {
            const startDate = getCookie('date[start]') == '' ? undefined:getCookie('date[start]')
            const endDate  =  getCookie('date[end]')   == '' ? undefined:getCookie('date[end]')

            setDateLastest(
                startDate == undefined ? true:false,
                endDate   == undefined ? true:false
            )

            return {
                'start': startDate == undefined ? getDayAgo():startDate,
                'end': endDate     == undefined ? getCurrentDate():endDate
            }
        }

        const setDateLastest = (
            updateStart = true, 
            updateEnd   = true,

            startDate = getDayAgo(), 
            endDate   = getCurrentDate(),

            refreshPage = false,
        ) => {
            if (updateStart) { setcookie('date[start]', startDate) }
            if (updateEnd)   { setcookie('date[end]'  , endDate)   }
            if (refreshPage) { location.reload()                   }
        }

        const updateDate = () =>{
            const dateStart = $(`#startDate`);
            const dateEnd   = $(`#endDate`);

            /* SET MIN,MAX */
            dateStart.attr('max', getDayAgo())
            dateEnd.attr('max', getCurrentDate());

            console.log(getDayAgo())
            /* SETDATA */
            const data = getDateLastest();
            

            dateStart.val(data.start);
            dateEnd.val(data.end) 
        }

        $('#startDate').on('change', function() { setDateLastest(true, false, $(this).val(), undefined, true) })
        $('#endDate').on('change',   function() { setDateLastest(false, true, undefined, $(this).val(), true) })
        $(document).ready(() => updateDate())

    </script>
@endsection


