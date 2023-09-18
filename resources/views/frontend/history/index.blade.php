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
        <section class="px-lg-5 table-responsive">
            <table class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0" id="historyTable">
                <thead>
                    <tr>
                        <th class="w-10"># ลำดับ</th>
                        <th>หมายเหตุ
                            <i class="fa-solid fa-circle-info ms-2" style="color: grey;"
                                title="ชื่อผู้ใช้ รหัสการสั่งจอง คำอธิบาย ข้อมูล คำชี้แจงเพิ่มเติม หรือ อื่นๆ"
                            ></i>
                        </th>
                        <th>ประเภท</th>
                        <th>ยอดรวม</th>
                        <th>วิธีการชำระเงิน</th>
                        <th>ทำรายการเมื่อ</th>
                        <th># ลำดับใบเสร็จ</th>
                        <th>ออกใบเสร็จเมื่อ</th>
                        <th>อื่นๆ</th>
                    </tr>
                </thead>
            </table>
        </section>
      



        
    </div>
@endsection

@section('footer')
    <script>
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
                return new Date(timestamp).toLocaleDateString('th-TH', { year: 'numeric', month: 'long', day: 'numeric' })
            }

  
            $(document).on('click', '#view', function(){
                const self = $(this);
                const id   = self.data('id');
                if (!id) return;
                window.location.href = ` {{ URL::to('/history/${id}') }} `;
            })

            $('table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('history')}}",
                columns:[
                    {data: 'id', name: 'id'},
                    {data: 'note', name: 'note'},
                    {data: 'isRetail', name: 'isRetail', render : (data) => {return data == "1" ? "ส่ง":"ปลีก"}},
                    {data: 'price', name: 'price', render : MoneyFormat},
                    {data: 'qrcode', name: 'qrcode', render : (data) => {return data == 1 ? 'โอนเงิน':'เงินสด'}},
                    {data: 'created_at', name: 'created_at', render: DateFormat },
                    {data: 'receipted', name: 'receipted', render : (data) => {return data == 0 ? '-':data}},
                    {data: 'receipted_at', name: 'receipted_at', render: (data) => {return data ? DateFormat(data):"-"} },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        } )
    </script>
@endsection

