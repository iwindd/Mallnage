<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

function Convert($amount_number){
    $amount_number = number_format($amount_number, 2, ".","");
    $pt = strpos($amount_number , ".");
    $number = $fraction = "";
    if ($pt === false) 
        $number = $amount_number;
    else
    {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }
    
    $ret = "";
    $baht = ReadNumber ($number);
    if ($baht != "")
        $ret .= $baht . "บาท";
    
    $satang = ReadNumber($fraction);
    if ($satang != "")
        $ret .=  $satang . "สตางค์";
    else 
        $ret .= "ถ้วน";
    return $ret;
}

class ConvertController extends Controller{
    public function baht_text($number)
    {
        $txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
        $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
        $number = str_replace(",","",$number);
        $number = str_replace(" ","",$number);
        $number = str_replace("บาท","",$number);
        $number = explode(".",$number);
        if(sizeof($number)>2){
        return 'ทศนิยมหลายตัวนะจ๊ะ';
        exit;
        } $strlen = strlen($number[0]);
        $convert = '';
        for($i=0;$i<$strlen;$i++){
        $n = substr($number[0], $i,1);
        if($n!=0){
        if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; }
        elseif($i==($strlen-2) AND $n==2){ $convert .= 'ยี่'; }
        elseif($i==($strlen-2) AND $n==1){ $convert .= ''; }
        else{ $convert .= $txtnum1[$n]; }
        $convert .= $txtnum2[$strlen-$i-1];
        }
        }
        $convert .= 'บาท';
        if($number[1]=='0' OR $number[1]=='00' OR $number[1]==''){
        $convert .= 'ถ้วน';
        }else{
        $strlen = strlen($number[1]);
        for($i=0;$i<$strlen;$i++){
        $n = substr($number[1], $i,1);
        if($n!=0){
        if($i==($strlen-1) AND $n==1){$convert .= 'เอ็ด';}
        elseif($i==($strlen-2) AND $n==2){$convert .= 'ยี่';}
        elseif($i==($strlen-2) AND $n==1){$convert .= '';}
        else{ $convert .= $txtnum1[$n];}
        $convert .= $txtnum2[$strlen-$i-1];
        }
        }
        $convert .= 'สตางค์';
        }
        return $convert;
    }
}


