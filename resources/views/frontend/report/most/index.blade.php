@extends('layouts.app')

@section('content')
    <div class="container mt-3 pt-2 ">
        <header>
            <h1 class="h2">รายงาน</h1>
        </header>
        <hr>
        <div class="row mb-2">
            <div class="col-sm-12 col-md-4 col-lg-3">
                @include('frontend.report.template.menu')
            </div>
            <div class="col-sm-12 col-md-8 col-lg-9 ">
                <section>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 d-flex justify-content-between align-items-center mb-2 ">
                            <label for="" class="w-25">เริ่มต้น : </label>
                            <div class="flex-grow-1"><input id="startDate" min="{{auth()->user()->created_at->toDateString('Y-m-d')}}" max="{{ now()->toDateString('Y-m-d') }}" name="startDate" class="form-control"
                                    type="date" /></div>
                        </div>
                        <div class="col-sm-12 col-md-6 d-flex justify-content-between align-items-center mb-2 ">
                            <label for="" class="w-25">สิ้นสุด : </label>
                            <div class="flex-grow-1"><input id="endDate" min="{{auth()->user()->created_at->toDateString('Y-m-d')}}"  max="{{ now()->toDateString('Y-m-d') }}"  name="endDate" class="form-control"
                                    type="date" /></div>
                        </div>

                    </div>
                </section>

                <hr>
                <table class="table table-striped">
                    <thead>
                        <th>รหัสสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>ยอดขาย</th>
                        <th>ยอดขายทั้งหมด</th>
                        <th>กำไร</th>
                        <th>ราคา</th>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <td class="text-muted">{{$item['serial']}}</td>
                                <td >{{$item['name']}}</td>
                                <td >@formatNumber($item['sold'])</td>
                                <td >@formatNumber($item['sold_all'])</td>
                                <td >@convertToBath($item['profit'])</td>
                                <td >@convertToBath($item['price'])</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
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
/*             dateStart.attr('max', getDayAgo())
            dateEnd.attr('max', getCurrentDate()); */

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






