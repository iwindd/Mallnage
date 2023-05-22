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

    
    <style>
        *{
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
        }
        body {
            font-family: 'sarabun', sans-serif;
        }

    </style>
</head>
<body>
    {{-- FORM --}}
    <div >
        <img 
            src="image/pdf/cooperative.png" 
            style="height:100%; width:100%; border:1px solid rgb(255,255,255);" 
            alt=""
        >
    </div>


    {{-- ANS --}}

    <div style="position: absolute; top: 15.38%; left: 57%; font-size:20px; font-weight: 600;">{{$timeTo}}</div>
    <div style="position: absolute; top: 40.95%; left: 23%; font-size:20px; font-weight: 600;">{{$timeNow}}</div>
    <div style="position: absolute; top: 40.95%; left: 67.5%; font-size:20px; font-weight: 600;">@formatNumber2($totalPrice) บาท</div>
    <div style="position: absolute; top: 43%; left: 14.5%; font-size:20px; font-weight: 600;">({{baht_text($totalPrice)}})</div>
</body>
</html>