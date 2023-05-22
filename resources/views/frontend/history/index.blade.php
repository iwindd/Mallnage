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
        <header class="my-2 d-flex align-items-center">
            <h1 class="h2">ประวัติการซื้อขาย</h1>
        </header>
        <hr>
        @if (count($histories) > 0)
            <section class="px-lg-5 table-responsive">
                <table class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0" id="historyTable">
                    <thead>
                        <tr>
                            <th class="w-10">#</th>
                            <th>หมายเหตุ
                                <i class="fa-solid fa-circle-info ms-2" style="color: grey;"
                                    title="ชื่อผู้ใช้ รหัสการสั่งจอง คำอธิบาย ข้อมูล คำชี้แจงเพิ่มเติม หรือ อื่นๆ"
                                ></i>
                                
                            </th>
                            <th>ประเภท</th>
                            <th>จำนวน</th>
                            <th>ยอดรวม</th>
                            <th>วิธีการชำระเงิน</th>
                            <th>ทำรายการเมื่อ</th>
                            <th>อื่นๆ</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </section>
        @else
        <h2 class="text-center m-5 h3">ไม่มีประวัติการซื้อขาย</h2> 
        @endif



        
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
                        <td>ค้า${history['isRetail'] == "1" ? "ส่ง":"ปลีก"}</td>
                        <td>${NumFormat(JSON.parse(history['product']))}</td>
        
                        /* PRICE */
                        <td>${MoneyFormat(history['price'])}</td>
                        
                        /* PAYMENT */
                        <td>${history['qrcode'] == 1 ? 'โอนเงิน':'เงินสด'}</td>


                        /* DATE */
                        <td
                            data-toggle="tooltip"
                            data-placement="top"
                            title="${DateFormat(history['created_at'])}"
                        >${DateFormat(history['created_at'])}</td>

                        /* ETC */
                        <td>
                            <a href="#" id="view" class="btn btn-primary" data-id="${history['id']}">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                เพิ่มเติม
                            </a>
                        </td>
                    </tr>
                `)
            }

            $(document).on('click', '#view', function(){
                const self = $(this);
                const id   = self.data('id');
                if (!id) return;
                window.location.href = ` {{ URL::to('/history/${id}') }} `;
            })
            $('table').DataTable();
        } )
    </script>
@endsection

