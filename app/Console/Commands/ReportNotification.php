<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Phattarachai\LineNotify\Facade\Line;
/* MODELS */
use App\Models\User;
use App\Models\Log;

class ReportNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:notification_day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    private function GetProfitAndSold($id){
        $start   = Carbon::yesterday()->startOfDay()->addHours("14")->toDateTimeString();
        $end     = Carbon::now()->startOfDay()->addHours("14")->toDateTimeString();

        $soldTodayQuery = Log::where([
            ['logs.cooperative', $id], 
            ['logs.type', 3],
            ['logs.amount', '>=', 1],
            ['logs.qrcode', 0]
        ])
        ->whereBetween('logs.created_at', [$start, $end])
        ->leftJoin('products', [
            ['logs.serial', 'products.serial'],
            ['logs.cooperative', 'products.cooperative']
        ])->get([
            'logs.amount', 'products.price', 'products.cost'
        ]);
        
        $sold   = 0;
        $profit = 0;

        foreach($soldTodayQuery as $item){
            $_profit = (($item->price)-($item->cost))*($item->amount);

            $sold  += $item->amount;
            $profit += $_profit;
        }

        return [
            'sold'   => $sold, 
            'profit' => $profit
        ];
    }

    private function DateThai(String $strDate){
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

    public function handle()
    {

        $start   = Carbon::yesterday()->startOfDay()->addHours("14")->toDateTimeString();
        $end     = Carbon::now()->startOfDay()->addHours("14")->toDateTimeString();


        $users = User::whereNotNull('lineToken')->get(["id","lineToken"]);
        foreach($users as $user){

            $profitAndSold = $this->GetProfitAndSold($user->id);
            $currentDate   = $this->DateThai(date("Y-m-d"));

            $message = "(รายวัน) รายงานผล วันที่ $currentDate \n";
            $message = $message."กำไรทั้งหมด : ".($profitAndSold['profit'])." บาท\n";
            $message = $message."ยอดขายทั้งหมด : ".($profitAndSold['sold'])." ครั้ง";

            Line::setToken($user->lineToken);
            Line::send($message);
        } 

        return 0;
    }
}
