<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Http\Controllers\ConvertController as convert;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('convertToBath', function ($money) {
            return "<?php echo '฿'.number_format($money, 2); ?>";
        });

        Blade::directive('convertToBath2', function ($val) {
            $val = convert::baht_text($val);
        
            return "<?php echo $val; ?>";
        });


        
        Blade::directive('formatNumber', function ($val) {
            return "<?php echo number_format($val, 0); ?>";
        });

        Blade::directive('formatNumber2', function ($val) {
            return "<?php echo number_format($val, 2); ?>";
        });

        Blade::directive('jsonDecode', function ($json) {
            return "<?php echo json_decode($json, false); ?>";
        });

        Blade::directive('GroupLabel', function ($group = 0) {
            if ($group == 1) return  'แอดมิน';
            if ($group == 0) return  'ผู้ใช้ปกติ';
            if ($group == -1) return 'ถูกระงับการใช้บริการชั่วคราว';
    
            if ($group == "admin") return 'แอดมิน';
            if ($group == "user") return 'ผู้ใช้ปกติ';
            if ($group == "ban") return 'ถูกระงับการใช้บริการชั่วคราว';
        });

        Blade::directive('formatDateAndTime', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y H:i'); ?>";
        });

    }
}
