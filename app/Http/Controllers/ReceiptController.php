<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

/* MODEL */
use App\Models\Receipt;


use PDF;

class ReceiptController extends Controller{

    public function get(){
        $receipts = Receipt::where([['cooperative', Auth::user()->id]])->get();

        return view("frontend.receipt.index", [
            'receipts' => $receipts
        ]);
    }

    public function _get(){
        $target = Session::get('management:id');
        $receipts = Receipt::where([['cooperative',  $target]])->get();

        return view('backend.management.receipt.index', [
            'receipts' => $receipts
        ]);

    }

    public function insert(Request $request){
        $request->validate([
            'description' => 'required|max:255',
            'price' => 'required'
        ]);

        $target = Session::get('management:id');
        Receipt::create([
            'cooperative' =>$target,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return redirect()->back()
            ->with('alert', 'เพิ่มใบกำกับภาษีสำเร็จ!')
            ->with('alert-type', 'success');
    }

    public function export(Int $id){

        $data = Receipt::where([
            ['cooperative', Auth::user()->id],
            ['id', $id]
        ])->first();




        return view('frontend.receipt.export', [
            'data' => $data,
            'user' => Auth::user()
        ]); 
    }
}
