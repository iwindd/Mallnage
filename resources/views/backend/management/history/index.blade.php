@extends('layouts.app')

@section('content')
    <div class="container mt-3 py-2 ">
        <header>
            <h1 class="h2">ผู้ใช้ : {{@session('management:name')}}</h1>
            <hr>
        </header>

        <div class="row">
            <div class="col-sm-12 col-lg-3 mb-3">
                @include('backend.management.layouts.menu')
            </div>
            <div class="col-sm-12 col-lg-9 pe-4">
                <section class="px-lg-3 table-responsive">
                    <table class="table table-striped dt-responsive display nowrap" cellspacing="0">
                        <thead>
                            <th class="w-10">#</th>
                            <th>หมายเหตุ</th>
                            <th>จำนวน</th>
                            <th>ยอดรวม</th>
                            <th>ทำรายการเมื่อ</th>
                            <th>อื่นๆ</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('footer')
<script>
    const products = {{Js::from($histories)}};

    $(document).ready(() => { 
   
        
        const shortText = (value) => {
    
            if(value.length <= 10) {
                return value;
            }
                    
            return value.substring(0, 10) + '...'; 
        } 
        
        const NumFormat = (object) =>{
            let Quantity_all = 0
            for(let[product, Quantity] of Object.entries(object)) {
                Quantity_all += Quantity
            }

            return (new Intl.NumberFormat().format(Quantity_all))
        }

        const MoneyFormat = (value) =>{
            return new Intl.NumberFormat('th-TH', { style: 'currency', currency: 'thb' }).format(value)
        }  

        const DateFormat = (timestamp) =>{
            return  new Date(timestamp).toLocaleDateString('th-TH')
        }

        for (let[i, history] of Object.entries(products)){
            $('table tbody').append(`
                <tr>
                    /* ID */
                    <td>${history['id']}</td>

                    /* NAME */
                    <td
                        data-toggle="tooltip"
                        data-placement="top"
                        title="${history['note']}"
                    >${shortText(history['note'])}</td>

                    /* QUANLITY */
                    <td>${NumFormat(JSON.parse(history['product']))}</td>
    
                    /* PRICE */
                    <td>${MoneyFormat(history['price'])}</td>

                    /* DATE */
                    <td
                        data-toggle="tooltip"
                        data-placement="top"
                        title="${DateFormat(history['created_at'])}"
                    >${DateFormat(history['created_at'])}</td>

                    /* ETC */
                    <td><a href="#" id="view" class="btn btn-primary" data-id="${history['id']}">รายละเอียด</a></td>
                </tr>
            `)
        }

        $(document).on('click', '#view', function(){
            const self = $(this);
            const id   = self.data('id');
            if (!id) return;
            window.location.href = ` {{ URL::to('/admin/user/history/${id}') }} `;
        })
        $('table').DataTable();
    } )
</script>
@endsection