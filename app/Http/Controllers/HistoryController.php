<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

/* MODEL */
use App\Models\History;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

use PDF;
use DataTables;

class HistoryController extends Controller
{
    public function get(Request $request){
        if ($request->ajax()) {
            $data = null;

            $isEmployees = Auth::user()->employees != -1 ? true:false;
        
            if (!$isEmployees) {
                $data = History::where('cooperative', '=', Auth::user()->id)->get([
                    'id', 'note', 'product', 'price', 'qrcode', 'created_at', 'isRetail'
                ]);
            }else{
                $data = History::where([
                    ['cooperative', '=', Auth::user()->employees],
                    ['created_by', '=', Auth::user()->id]
                ])->get([
                    'id', 'note', 'product', 'price', 'qrcode', 'created_at', 'isRetail'
                ]);
            }
    
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("historyView", ['id' => $row['id']]).'" class="btn btn-primary btn-sm"> <i class="fa-solid fa-magnifying-glass"></i> เพิ่มเติม</a>';
                    return $btn;
                })
                ->addColumn("productData", function($row){
                    return $row['product'];
                })
                ->rawColumns(['action'])
                ->make(true);
        }

       return view('frontend.history.index');
    }

    public function view(Int $id){
        $isEmployees = Auth::user()->employees != -1 ? true:false;
        $cooperativeId = Auth::user()->employees != -1 ? Auth::user()->employees:Auth::user()->id;

        $history = null;
        $products = null;

        if (!$isEmployees) {
            $history = History::where('id', '=', $id)->where('cooperative', '=', Auth::user()->id)->first(['id', 'note', 'product', 'price', 'qrcode', 'created_at', 'created_by', 'isRetail']);
            $products = Product::where('cooperative', '=', Auth::user()->id)->get(['serial', 'name', 'price', 'isRetail']);
        }else{
            $history = History::where('id', '=', $id)->where([
                ['cooperative', '=', $cooperativeId],
                ['created_by', '=', Auth::user()->id]
            ])->first(['id', 'note', 'product', 'price', 'qrcode', 'created_at', 'created_by']);

            $products = Product::where('cooperative', '=', $cooperativeId)->get(['serial', 'name', 'price']);
        }
        
        $created_by_fullname = Auth::user()->fullname;

        if ($history->created_by != Auth::user()->id && $history->created_by != -1){
            $query = User::where([
                ['id', $history->created_by]
            ])->first(['fullname']);
            $created_by_fullname = $query->fullname;
        }

        return view('frontend.history.view.index', [
            'history' => $history,
            'products' => $products,
            'created_by_fullname' => $created_by_fullname
        ]);
    }
    
    public function get_receipt(Int $id){
        return view('frontend.history.receipt_confirmation', [
            'id' => $id
        ]);
    }

    public function receipt(Request $request){
        $id = $request->id;

        $isEmployees = Auth::user()->employees != -1 ? true:false;
        $cooperativeId = Auth::user()->employees != -1 ? Auth::user()->employees:Auth::user()->id;

        $history = null;

        if (!$isEmployees) {
            $history = History::where('id', '=', $id)->where('cooperative', '=', Auth::user()->id)->first([
                'id', 'product', 'product_borrows', 'price', 'created_at', 'firstname', 'lastname',
                'qrcode', 'address', 'district', 'area', 'province', 'postalcode', 'note',
                'department', 'created_by'
            ]);
        }else{
            $history = History::where('id', '=', $id)->where([
                ['cooperative', '=', Auth::user()->employees],
                ['created_by', '=', Auth::user()->id]
            ])->first([
                'id', 'product', 'product_borrows', 'price', 'created_at', 'firstname', 'lastname',
                'qrcode', 'address', 'district', 'area', 'province', 'postalcode', 'note',
                'department', 'created_by'
            ]);
        }
        

        $products = [];
        $result = [];
        $buyed = json_decode($history->product);
        $borrows = json_decode($history->product_borrows);
        
        foreach (Product::where('cooperative', '=', $cooperativeId)->get(['serial', 'name', 'price']) as $key) {
            $products[$key->serial] = $key;
        }


        foreach ($buyed as $serial => $quantity) {
            if ($products[$serial]) {
                $result[$serial] = $products[$serial];
                $result[$serial]['quantity'] = $quantity;
                $result[$serial]['borrow'] = 'no-borrow';

            }
        }

        if (isset($borrows)) {
            foreach ($borrows as $serial) {
                if ($result[$serial]) {
                    $result[$serial]['borrow'] = 'borrow';
                }
            }
        }

        $created_by_fullname = Auth::user()->fullname;



        $date = Carbon::parse($history->created_at)    
            ->addHours(23)
            ->addMinutes(59)
            ->addSeconds(59)
            ->toDateTimeString();

        $pdf = PDF::loadView('frontend.history.receipt', [
            'products' => $result,
            'id'       => $history->id,
            'payment'  => $history->qrcode == 1 ? 'โอน':'เงินสด',
            'firstname' => $history->firstname,
            'lastname' => $history->lastname,
            'department' => $history->department,

            'address' => $history->address,
            'district' => $history->district,
            'area' => $history->area,
            'province' => $history->province,
            'postalcode' => $history->postalcode,
            'note' => $history->note,
            'nameget' => $request->name,
            'created_by_fullname' => $created_by_fullname,
			'address_shop' => (auth()->user()->address.' '.auth()->user()->province.' '.auth()->user()->area.' '.auth()->user()->district.' '.auth()->user()->postalcode),


            'title'    => Auth::user()->name,
            'date'     => $this->DateThai($date)
        ]);



        return  $pdf -> stream('receipt.pdf');
    }

    public function _get(){
        $this->isAdmin();

        return view('backend.management.history.index', [
            'histories' => History::where('cooperative', '=', Session::get('management:id'))->get([
                'id', 'note', 'product', 'price', 'qrcode', 'created_at'
            ])
        ]);
    }

    public function _view(String $id){
        $this->isAdmin();
        if (!isset($id)) return redirect()->back();

        $data = history::find($id);

        return view('backend.management.history.view.index', [
            'history' => History::where([
                ['id', $id],
                ['cooperative', Session::get('management:id')]
            ])->first(
                ['id', 'note', 'product', 'qrcode', 'price', 'created_at'
            ]),
            'products' => Product::where('cooperative', '=', Session::get('management:id'))->get(
                ['serial', 'name', 'price'
            ])
        ]);
    }
}
