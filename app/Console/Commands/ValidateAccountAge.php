<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Phattarachai\LineNotify\Facade\Line;
/* MODELS */
use App\Models\User;

class ValidateAccountAge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:validateAccountAge';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate Account Age';

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

    protected function Alert7Day()
    {
        # code...
    }

    public function handle()
    {

        $startYears = Carbon::now()->startOfYear()->toDateString();
        $today   = Carbon::now()->endOfDay()->toDateTimeString();
        $result  = User::whereBetween('accountAge', [$startYears, $today])
            ->where([
                ['isAdmin', 0],
                ['lineToken', '!=', 'null'],
                ['employees', '-1']
            ])->get('lineToken');


        $update  = User::whereBetween('accountAge', [$startYears, $today])
            ->where([
                ['isAdmin', 0]
            ])->update([
                'isAdmin' => -1
            ]);


        $message = 'บัญชีของคุณหมดอายุการใช้งานแล้ว! ระบบจะทำการระงับบัญชีของคุณชั่วคราว จนกว่าจะเปิดใช้งานอีกครั้ง!';

        foreach($result as $user){
            Line::setToken($user->lineToken);
            Line::send($message);
        }

        $this->Alert7Day();
        return 0;
    }
}
