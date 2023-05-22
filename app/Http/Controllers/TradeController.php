<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/* MODEL */
use App\Models\Trade;



class TradeController extends Controller{
    public function index(){
        $startDay   = Carbon::now()->startOfDay()->toDateTimeString();
        $endDay     = Carbon::now()->endOfDay()->toDateTimeString();

        $items = Trade::where([
            ['cooperative', Auth::user()->id]
        ])->get();
        $price = $this->getPriceOfTrade($startDay, $endDay);


        return view('frontend.trade.index', [
            'items' => $items,
            'priceOfTrade' => $price
        ]);
    }

    public function add(Request $request){
        $request -> validate([
            'product_name' => 'required|max:255',
            'product_quantity' => 'required|integer|max:100000|min:1',
            'product_price' => 'required|integer|max:100000|min:0'
        ]);

        Trade::create([
            'cooperative' => Auth::user()->id,
            'trade_item'  => $request->product_name,
            'trade_quantity' => $request->product_quantity,
            'trade_price' => $request->product_price
        ]);

        return redirect()->route('trade')
            ->with('status', "เพิ่มการซื้อสินค้าสำเร็จแล้ว")
            ->with('alert-type', 'success'); 
    }
}
