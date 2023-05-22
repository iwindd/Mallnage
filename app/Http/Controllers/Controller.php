<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Session;
use Phattarachai\LineNotify\Facade\Line;

/* MODEL */
use App\Models\Product;
use App\Models\Trade;
use App\Models\User;

class Controller extends BaseController
{
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function isOwnedProduct(String $serial){
        return empty($serial) ? false:( (Product::where('serial', '=', $serial)->where('cooperative', '=', Auth::user()->id)->first('cooperative')) == null ? false:true );
    }

    protected function DateThai($strDate){
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

    protected function GetTime($strDate){
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
 

        return "$strHour:$strMinute";
    }

    protected function randstr ($len=10, $abc="aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789") {
        $letters = str_split($abc);
        $str = "";
        for ($i=0; $i<=$len; $i++) {
            $str .= $letters[rand(0, count($letters)-1)];
        };
        return $str;
    }

    protected function isManagement(Int $id = 0){
        return Session::get('management:id') == $id ? true:false;
    }

    protected function getGroupLabel($group = 0){
        if ($group == 0) return  'ผู้ใช้ปกติ';
        if ($group == 1) return  'แอดมิน';
        if ($group == -1) return 'ถูกระงับการใช้บริการชั่วคราว';

        if ($group == "user") return 'ผู้ใช้ปกติ';
        if ($group == "admin") return 'แอดมิน';
        if ($group == "ban") return 'ถูกระงับการใช้บริการชั่วคราว';
    }

    protected function getGradeLabel($grade = 0){
        if ($grade == 0) return  'Basic';
        if ($grade == 1) return  'Pro';

        if ($grade == "basic") return 'Basic';
        if ($grade == "pro") return 'Pro';
    }

    protected function isAdmin(){
        if (Auth::user()->isAdmin != 1) return redirect()->back(); /* CHECK ADMIN */
    }

    protected function sendLine(String $message){
        if (Auth::user()->lineToken !== null) {
            $lineToken = null;

            if (Auth::user()->employees != -1) {
                $query = User::where([
                    ['id', Auth::user()->employees]
                ])->first('lineToken');
                $lineToken = $query->lineToken;
            }else{
                $lineToken = Auth::user()->lineToken;
            }
            
            try {
                Line::setToken($lineToken);
                Line::send($message);
            } catch (\Throwable $th) {
                return false;
            }
        }

    }

    protected function genEan($number){
        $code = '200' . str_pad($number, 9, '0');
        $weightflag = true;
        $sum = 0;

        for ($i = strlen($code) - 1; $i >= 0; $i--)
        {
            $sum += (int)$code[$i] * ($weightflag?3:1);
            $weightflag = !$weightflag;
        }
        $code .= (10 - ($sum % 10)) % 10;
        return $code;
    }

    protected function checkEan($digits){
        dd($digits);
        if($digits <= 0) return 0;
        while(strlen($digits) < 13){
            $digits = '0'.$digits;
        }
        $digits=preg_split("//",$digits,-1,PREG_SPLIT_NO_EMPTY);
        $a=$b=0;
        for($i=0;$i<6;$i++){
            $a+=(int)array_shift($digits);
            $b+=(int)array_shift($digits);
        }
        $total=($a*1)+($b*3);
        $nextten=ceil($total/10)*10;
        return $nextten-$total==array_shift($digits);
    }

    protected function getBasket(String $basketName = "basket"){
        $basket = Session::get($basketName);

        if ($basket == null){
            Session::put($basketName, []);
            return [];
        }

        return $basket;
    }

    protected function getPriceOfTrade($from, $to, $counType = 1){

        $trade  = Trade::where([ /* ALL */
            ['cooperative',  Auth::user()->id], 
        ])
        ->whereBetween('created_at', [$from, $to])
        ->get([
            'trade_quantity',
            'trade_price'
        ]);

/*         if ($counType == 1) {

        }else{
            if ($counType == 2) {
                $trade  = Trade::where([
                    ['cooperative',  Auth::user()->id],
                ])
                ->whereBetween('created_at', [$from, $to])
                ->get([
                    'trade_quantity',
                    'trade_price'
                ]); 
            }else{ 
                $trade  = Trade::where([
                    ['cooperative',  Auth::user()->id],
                ])
                ->whereBetween('created_at', [$from, $to])
                ->get([
                    'trade_quantity',
                    'trade_price'
                ]);
            }
        } */


        $tradePrice = 0;

        foreach($trade as $item) {
            $tradePrice += ($item->trade_quantity*$item->trade_price);
        }


        return $tradePrice;
    }
    
}
