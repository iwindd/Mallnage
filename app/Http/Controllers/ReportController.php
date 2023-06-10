<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/* OPTIONAL */
use Carbon\Carbon;
use PDF;

/* MODEL */
use App\Models\Product;
use App\Models\Log;
use App\Models\History;
use App\Models\Trade;

class ReportController extends Controller
{
    /* PRIVATE */

    private function GetBestAndOldSeller($from, $to){
        $log           = Log::where([
                            ['logs.cooperative', '=', Auth::user()->id],
                            ['logs.type', '=', 3],
                            ['logs.qrcode' , 0]
                        ])
                        ->whereBetween('logs.created_at', [$from, $to])
                        ->leftJoin('products', [
                            ['logs.serial', '=', 'products.serial'],
                            ['logs.cooperative', '=', 'products.cooperative']
                        ])
                        ->get([
                            'logs.serial',
                            'logs.amount',
                            'products.name',
                            'products.price'
                        ]);
        $logMerge = [];
        $logArrayRaw = [];
        $totalPrice  = 0;
     

        /* MERGE ITEM AND GET PRICE */
        for ($i=1; $i<count($log); $i++){
            $xItem = $log[$i];
            $item  = [
                'product_serial' => $xItem->serial,
                'product_name'   => $xItem->name,
                'product_sold'   => $xItem->amount,
                'product_price'  => $xItem->price
            ];

            $totalPrice += ($item['product_sold']*$item['product_price']);

            if (empty($logMerge[$item['product_serial']])) {
                $logMerge[$item['product_serial']] = $item; 
            }else{
                $logMerge[$item['product_serial']]['product_sold'] += $item['product_sold'];
            }
        }
 
        /* GET ARRAY VALUE TO SORT */
        foreach($logMerge as $serial => $data){
            array_push($logArrayRaw, $data['product_sold']);
        }
    
        /* GET DESC AND ASC ARRAY */
        $logArrayDesc = $logArrayRaw; /* BEST */
        $logArrayAsc = $logArrayRaw; /* BAD */

        rsort($logArrayDesc);
        sort($logArrayAsc);
 

        /* GET TOP 5 BEST AND BAD */

        $BestRaw   = $logMerge;
        $BadRaw    = $logMerge;
   
        $bestSeller    = [];
        $badSeller     = [];


        for ($i=0; $i<5; $i++){
            $bestNum = isset($logArrayDesc[$i]) ? $logArrayDesc[$i]:null;
            $badNum  = isset($logArrayAsc[$i])  ? $logArrayAsc[$i]:null;

            if ($bestNum !== null) {
                foreach($BestRaw as $serial => $data){
                    if ($data['product_sold'] == $bestNum) {
                        $data['product_number'] = ($i+1);
                        $bestSeller[$i+1] = $data;
                        unset($BestRaw[$serial]);
                        break;
                    }
                }
            }

            if ($badNum !== null){
                foreach($BadRaw as $serial => $data){
                    if ($data['product_sold'] == $badNum) {
                        $data['product_number'] = ($i+1);
                        $badSeller[$i+1] = $data;
                        unset($BadRaw[$serial]);
                        break;
                    }
                }
            }
        }

        /* RETURN DATA */
        return [
            'most' => $bestSeller,
            'least' => $badSeller,
            'totalPrice' => $totalPrice
        ];
    }

    private function GetDisplayData($from, $to, $retail = false){
        $isRetail = $retail ? 1:0;
        $soldTodayQuery = Log::where([
            ['logs.cooperative', Auth::user()->id], 
            ['logs.type', 3],
            ['logs.amount', '>=', 1],
            ['logs.isRetail', $isRetail]
        ])
        ->whereBetween('logs.created_at', [$from, $to])
        ->leftJoin('products', [
            ['logs.serial', 'products.serial'],
            ['logs.cooperative', 'products.cooperative'],
            ['logs.isRetail', 'products.isRetail']
        ])->get([
            'logs.amount', 'products.price', 'products.cost', 'logs.qrcode'
        ]);

        $sold   = 0;
        $profit = 0;
        $price = 0;
        $priceCash = 0;
        $tradePrice = $this->getPriceOfTrade($from, $to);

        foreach($soldTodayQuery as $item){
            $_profit = (($item->price)-($item->cost))*($item->amount);

            if ($item->qrcode == "1"){
                $price  += ($item->price)*($item->amount);
            }else{
                $priceCash += ($item->price)*($item->amount);
            }

            $sold  += $item->amount;
            $profit += $_profit;
       
        }

        $profit = $profit-$tradePrice;

        return [
            'sold'   => $sold, 
            'price'  => $price,
            'priceCash' => $priceCash,
            'profit' => $profit
        ];
    }

    /* PUBLIC */

    public function get(Type $var = null){
        /* DAY */
        $startDay   = Carbon::now()->startOfDay()->toDateTimeString();
        $endDay     = Carbon::now()->endOfDay()->toDateTimeString();

        /* MONTH */
        $startMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endMonth   = Carbon::now()->endOfMonth()->toDateTimeString();

        /* YEAR */
        $startYear  = Carbon::now()->startOfYear()->toDateTimeString();
        $endYear    = Carbon::now()->endOfYear()->toDateTimeString();


        /* INFORMATON */
        $information                    = [];
        $information['today'] = $this->GetDisplayData($startDay, $endDay);
        $information['month'] = $this->GetDisplayData($startMonth, $endMonth);
        $information['year'] = $this->GetDisplayData($startYear, $endYear);
        $information['today2'] = $this->GetDisplayData($startDay, $endDay, true);
        $information['month2'] = $this->GetDisplayData($startMonth, $endMonth, true);
        $information['year2'] = $this->GetDisplayData($startYear, $endYear, true);

        return view('frontend.report.report.index', $information);
    }

    public function most(){
        $from = empty($_COOKIE["date"]['start']) ? date("Y-m-d"):$_COOKIE["date"]['start'];
        $to = empty($_COOKIE["date"]['end']) ? date("Y-m-d"):$_COOKIE["date"]['end'];


        $to = Carbon::parse($to)    
            ->addHours(23)
            ->addMinutes(59)
            ->addSeconds(59)
            ->toDateTimeString();

        
        $log   = Log::where([
                                    ['logs.cooperative', '=', Auth::user()->id],
                                    ['logs.type', '=', 3]
                                ])
                                ->whereBetween('logs.created_at', [$from, $to])
                                ->leftJoin('products', [
                                    ['logs.serial', '=', 'products.serial'],
                                    ['logs.cooperative', '=', 'products.cooperative']
                                ])
                                ->get([
                                    'logs.serial',
                                    'logs.amount',
                                    'products.name',
                                    'products.price',
                                    'products.sold',
                                    'products.cost'
                                ]);
        $Seller    = [];
        $SellerNumCount = 0;
        $data = [];

        /* ทำเผื่อในอนาคตไม่ใช้ datatable */
        for($i=0; $i<count($log); $i++){
            $item = $log[$i];

            
            if(isset($Seller[$item->serial])) {
       
                $Seller[$item->serial] += $item->amount;
            }else{
                $Seller[$item->serial] = $item->amount;
                $data[$item->serial] = $item;
                $SellerNumCount += 1;

            }
        }

        $sortNum = $Seller;        
        usort($sortNum, function($a, $b){
            return $b <=> $a;
        });

        $order = [];

        for($i=0; $i<($SellerNumCount); $i++){
            $num = isset($sortNum[$i]) ? $sortNum[$i]:0;
            $serial = null;
            $Quantity = 0;
            $ticket = isset($sortNum[$i]) ? true:false;
            

            foreach($Seller as $serialRaw => $QuantityRaw) {
                if ($QuantityRaw == $num) {
                   
                    $serial = $serialRaw;
                    $Quantity = $QuantityRaw;
 
                    unset($Seller[$serial]);
            
                    break;
                }
            }

            
            if ($serial == null) continue;

            $itemData = $data[$serial];

            array_push($order, [
                'serial' => $serial,
                'sold' => $Quantity == null ? 0:$Quantity,
                'sold_all' => $itemData->sold,
                'profit' => (($itemData->price)-($itemData->cost))*($Quantity == null ? 0:$Quantity), 
                'name' => $itemData->name,
                'price' => $itemData->price
            ]);
        }
        

        return view('frontend.report.most.index', [
            'products' => $order
        ]);
    }

    public function least(){
        $from = empty($_COOKIE["date"]['start']) ? date("Y-m-d"):$_COOKIE["date"]['start'];
        $to = empty($_COOKIE["date"]['end']) ? date("Y-m-d"):$_COOKIE["date"]['end'];
        $to = Carbon::parse($to)    
            ->addHours(23)
            ->addMinutes(59)
            ->addSeconds(59)
            ->toDateTimeString();
        
        $log           = Log::where([
                                    ['logs.cooperative', '=', Auth::user()->id],
                                    ['logs.type', '=', 3]
                                ])
                                ->whereBetween('logs.created_at', [$from, $to])
                                ->leftJoin('products', [
                                    ['logs.serial', '=', 'products.serial'],
                                    ['logs.cooperative', '=', 'products.cooperative']
                                ])
                                ->get([
                                    'logs.serial',
                                    'logs.amount',
                                    'products.name',
                                    'products.price',
                                    'products.sold',
                                    'products.cost'
                                ]);
        $Seller    = [];
        $data = [];
        $SellerNumCount = 0;

        /* ทำเผื่อในอนาคตไม่ใช้ datatable */
        for($i=0; $i<count($log); $i++){
            $item = $log[$i];

            
            if(isset($Seller[$item->serial])) {
                $Seller[$item->serial] += $item->amount;
            }else{
                $Seller[$item->serial] = $item->amount;
                $data[$item->serial] = $item;
                $SellerNumCount += 1;
            }
        }


        $sortNum = $Seller;        
        usort($sortNum, function($a, $b){
            return $a <=> $b;
        });

        $order = [];

        for($i=0; $i<($SellerNumCount); $i++){
            $num = isset($sortNum[$i]) ? $sortNum[$i]:0;
            $serial = null;
            $Quantity = 0;
            $ticket = isset($sortNum[$i]) ? true:false;
            

            foreach($Seller as $serialRaw => $QuantityRaw) {
                if ($QuantityRaw == $num) {
                   
                    $serial = $serialRaw;
                    $Quantity = $QuantityRaw;
 
                    unset($Seller[$serial]);
            
                    break;
                }
            }

            
            if ($serial == null) continue;

            $itemData = $data[$serial];

            array_push($order, [
                'serial' => $serial,
                'sold' => $Quantity == null ? 0:$Quantity,
                'sold_all' => $itemData->sold,
                'profit' => (($itemData->price)-($itemData->cost))*($Quantity == null ? 0:$Quantity), 
                'name' => $itemData->name,
                'price' => $itemData->price
            ]);
        }

        return view('frontend.report.least.index', [
            'products' => $order
        ]);
    }

    public function pdf(){
        if (Auth::user()->grade !== 1) return redirect()->route('home');
        /* GET TIME */
        $from = date("Y-m-d");
        $to   = date("Y-m-d");

        $from = Carbon::parse($to)    
            ->addHours(0)
            ->addMinutes(0)
            ->addSeconds(0)
            ->toDateTimeString();

        $to = Carbon::parse($to)    
            ->addHours(23)
            ->addMinutes(59)
            ->addSeconds(59)
            ->toDateTimeString();
        
        //dd($from, $to);
        $log           = Log::where([
            ['logs.cooperative', '=', Auth::user()->id],
            ['logs.type', '=', 3],
            ['logs.qrcode' , 0]
        ])
        ->whereBetween('logs.created_at', [$from, $to])
        ->leftJoin('products', [
            ['logs.serial', '=', 'products.serial'],
            ['logs.cooperative', '=', 'products.cooperative']
        ])
        ->get([
            'logs.amount',
            'products.price'
        ]);
        $totalPrice  = 0;

        foreach($log as $item) {
            $totalPrice += $item->price*$item->amount;
        }

        $tradePrice = $this->getPriceOfTrade($from, $to);
        $totalPrice = $totalPrice-$tradePrice;
        $totalPrice = $totalPrice < 0 ? 0:$totalPrice;

        $pdf = PDF::loadView('frontend.report.pdf.index', [
            'timeFrom' => $this->DateThai($from),
            'timeTo'   => $this->DateThai($to),
            'timeNow'  => $this->DateThai(date('Y-m-d')),
 
            'totalPrice' => $totalPrice
        ]);

        return  $pdf -> stream('pdf.pdf');
    }
}
