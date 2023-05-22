<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/* MODEL */
use App\Models\Product;
use App\Models\Departments;

class CashierController extends Controller
{
    public function index(Request $request){
        $isRetail = $request->retail ? 1:0;

        $Selectize = Departments::all(['id', 'label']);
        $basket = $this->getBasket($isRetail ? "basket2":"basket");
        $price = 0;

        foreach ($basket as $item){
            $price += ($item['quantity']*$item['price']);
        }

        $cooperativeId = Auth::user()->employees != -1 ? Auth::user()->employees:Auth::user()->id;

        return view('frontend.cashier.index', [
            'products' => Product::where([
                ['cooperative', $cooperativeId],
                ['isRetail', $isRetail]
            ])->get(['serial', 'price', 'name', 'quantity', 'isRetail']),
            'basket'   => $basket,
            'price'    => $price,
            'isRetail' => $isRetail,
            'selectize' => $Selectize
        ]);
    }
}
