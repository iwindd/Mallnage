@php
function baht_text(float $amount): string
{
    [$integer, $fraction] = explode('.', number_format(abs($amount), 2, '.', ''));

    $baht = convert($integer);
    $satang = convert($fraction);

    $output = $amount < 0 ? 'ลบ' : '';
    $output .= $baht ? $baht.'บาท' : '';
    $output .= $satang ? $satang.'สตางค์' : 'ถ้วน';

    return $baht.$satang === '' ? 'ศูนย์บาทถ้วน' : $output;
}

function convert(string $number): string
{
    $values = ['', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
    $places = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];
    $exceptions = ['หนึ่งสิบ' => 'สิบ', 'สองสิบ' => 'ยี่สิบ', 'สิบหนึ่ง' => 'สิบเอ็ด'];

    $output = '';

    foreach (str_split(strrev($number)) as $place => $value) {
        if ($place % 6 === 0 && $place > 0) {
            $output = $places[6].$output;
        }

        if ($value !== '0') {
            $output = $values[$value].$places[$place % 6].$output;
        }
    }

    foreach ($exceptions as $search => $replace) {
        $output = str_replace($search, $replace, $output);
    }

    return $output;
}
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงาน</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <style>
        body {
            font-family: 'sarabun', sans-serif;
        }

        
        .container{

            padding: 0px;
        }


        header div{
            width: 33%;
            float: left;
            padding: 0px;
        }

        section#box1{
            border: 0.5px solid black;
            width: 90%;
            height: 6%;
            box-sizing: border-box;
            padding: 5px;
            font-weight: bold;
            font-size: 18px;
            float: right;
            transform: translate(-50%, -50%);
        } 

        section#box1 p{
            font-weight: 400 !important;
            margin: 0;
            padding: 0;
            line-height: 1.5em;
        }
        
        
        .divTitle{
            widows: 100% !important;
            border: 0px solid black;
        }



        article p{
            font-size: 18px;

        }

        article b{
            font-weight: 28px !important;
        }


    </style>
</head>
<body>
    {{-- FORM --}}
    <div class="container" style="width: 90%;">
        <header>
            <div style="height: 12%;">
                <img 
                src="https://chomphunutdocumentary.files.wordpress.com/2018/11/e0b884e0b8a3e0b8b8e0b891e0b89ee0b988e0b8b2e0b8abe0b98c-e0b8a3e0b8b2e0b88ae0b881e0b8b2e0b8a3e0b983e0b899e0b89be0b8a3e0b8b0e0b980e0b897.png" 
                width="64px"
                style="margin-top: 25%;"
                alt="">
            </div>
            <div style="height: 12%; display:flex; align-items:flex-end;">
                <h1
                    style="font-size: 40px;
                        padding-top: 40%;

                        font-weight: bold;
                        text-align:center;
                    "
                >บันทึกข้อความ</h1>
            </div>
            <div>
                <section id="box1">
                    <label>ฝ่ายแผนงานและความร่วมมือ</label>
                    <article>
                        <p>
                            เลขรับที่...................................................<br>
                            วันที่.........................................................<br>
                            เวลา........................................................<br>
                        </p>
                    </article>
                </section>
            </div>
        </header>
        <article>
            <p>
                <b style="font-weight: bold; font-size:25px;">ส่วนราชการ </b> ...............................................................................................................................................................................................<br>
                <b style="font-weight: bold; font-size:25px;">ที่</b><span>......................................................................................................</span> 
                <b style="font-weight: bold; font-size:25px;">วันที่</b><span >.......................................................................................................</span><br>
                <b style="font-weight: bold; font-size:25px;">เรื่อง </b><span>................................................................................................................................................................................................................</span><br>
                เรียน ผู้อำนวยการวิทยาลัยอาชีวศึกษาสุราษฎร์ธานี
                <p style=" padding-top: -15px; text-indent: 50px;  white-space: normal; word-wrap: break-word;">
                    ตามคำสั่งวิทยาลัยอาชีวศึกษาสุราษฎร์ธานีเลขที่  520/2565  ลงวันที่  2  มิถุนายน  2565  มอบหมายหน้าที่ให้คณะกรรมการดำเนินสหการร้านค้า วิทยาลัยอาชีวศึกษาสุราษฎร์ธานี  ดำเนินโครงการส่งเสริมผลิตผล การค้าและประกอบธุรกิจในสถานศึกษา เพื่อส่งเสริมให้ครู นักเรียน นักศึกษา และบุคลากรในสถานศึกษาดำเนินการทำธุรกิจขนาดย่อม ประกอบอาชีพอิสระ 
                    รับงานการค้ารับจัดทำ รับบริการรับจ้างผลิตเพื่อจำหน่ายหารายได้ระหว่างเรียนและกิจกรรมสหการร้านค้าวิทยาลัยอาชีวศึกษาสุราษฎร์ธานี เพื่อสร้างรายได้ให้สอดคล้องกับการเรียนการสอนและงานสหการร้านค้าของสถานศึกษานั้น
                </p>
                <p style=" padding-top: -15px; text-indent: 50px;  white-space: normal; word-wrap: break-word;">
                    ในการนี้ข้าพเจ้า นางณัฐกาญจน์  เพราแก้ว ตำแหน่ง ครู  ทำหน้าที่ คณะกรรมการฝ่ายจัดจำหน่าย  มีหน้าที่ นำส่งเงินสดจากการจำหน่ายสินค้าสหการร้านค้าวิทยาลัยอาชีวศึกษาสุราษฎร์ธานี     ประจำวันที่ {{$timeNow}} ณ เวลา 14.00 น.  รวมจำนวนเงินทั้งหมด @formatNumber2($totalPrice) บาท 
                    <br>({{baht_text($totalPrice)}})<br>
                    <p style="text-indent: 100px; font-size: 18px;">จึงเรียนมาเพื่อโปรดทราบ</p>
                </p>
    
               
                <section style="font-size: 18px; margin-left: 350px;">
                    <div style="text-align: center">(นางณัฐกาญจน์  เพราแก้ว)</div>
                    <div style="text-align: center">ครู คศ.1</div>
                </section>
            </p>
            <section id="box2" style="">
                <div style="width: 45%; float:left; font-size: 18px;">
                    ความเห็นของคณะกรรมการฝ่ายการเงินและบัญชี
                    ......................................................................................................................................................................................................
                    <b style="font-weight: bold">ลงชื่อ</b>..........................................................................................
                    <div style="font-size: 18px; text-align:center;">(นางอภิญญา พงศ์ธิติเมธี)</div>
                </div>
                <div style="width: 45%; float:right; font-size: 18px;">
                    ความเห็นของรองผู้อำนวยการฝ่ายแผนกงานฯ
                    ......................................................................................................................................................................................................
                    <b style="font-weight: bold">ลงชื่อ</b>..........................................................................................
                    <div style="font-size: 18px; text-align:center;">(นายกิจติพงศ์ บู้หลง)</div>
                </div>
            </section>
            <section id="box3" style="width: 60%; margin: 15px auto; ; font-size: 18px;">
                ความเห็นของรองผู้อำนวยการฝ่ายแผนกงานฯ
            
         
            </section>
            {{-- CHECKBOX1 --}}
            <div>
                <div style="width:19px; height: 19px; margin: -20px 20%;  border: 1px solid black;"></div>
            </div>
            <div style="width:50px; height: 19px;  margin: 0px 24%; font-size: 18px;">ทราบ</div>

            {{-- CHECKBOX2 --}}
            <div>
                <div style="width:19px; height: 19px; margin: -5px 20%;  border: 1px solid black;"></div>
            </div>
            <div style="width:500px; height: 19px;  margin: -15px 24%; font-size: 18px;">มอบฝ่ายการเงินสหการร้านค้า วอศ.สุราษฎร์ธานี</div>

            <section id="box3" style="width: 60%; margin: -5px auto; ; font-size: 18px;">
               ........................................................................................................................................................................................................................................................................
               <b style="font-weight: bold">ลงชื่อ</b>............................................................................................................................
               <div style="font-size: 18px; text-align:center;">(นายกิจติพงศ์ บู้หลง)</div>
               <div style="font-size: 18px; text-align:center;">ผู้อำนวยการวิทยาลัยอาชีวศึกษาสุราษฎร์ธานี</div>
            </section>
        </article>
    </div>

    {{-- ANS --}}
    <div style="position: absolute; top: 16.4%; left: 21.5%; font-size:18px;">วอศ.สุราษฎร์ธานี ฝ่ายแผนงานและความร่วมมือ งานส่งเสริมผลิตผล การค้าและประกอบ</div>
    <div style="position: absolute; top: 23%; left: 15.5%; font-size:18px;">ขอนำส่งเงินจากการจำหน่ายสินค้าสหการร้านค้าวิทยาลัยอาชีวศึกษาสุราษฎร์ธานี</div>
    <div style="position: absolute; top: 19.7%; left: 53%; font-size:18px;">{{$timeTo}}</div>
</body>
</html>