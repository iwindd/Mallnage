<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
/* MODELS */
use App\Models\Borrows;
use App\Models\Product;
use App\Models\Log;
use App\Models\History;

class BorrowController extends Controller
{
    public function get(){


        $borrowsProcess  = Borrows::where([
            ['cooperative', Auth::user()->id],
            ['status', 0],
            ['closeType', 0]
        ])->count();

        $borrowsSuccess  = Borrows::where([
            ['cooperative', Auth::user()->id],
            ['status', 1],
            ['closeType', 0]
        ])->count();

        $borrowsCanceled = Borrows::where([
            ['cooperative', Auth::user()->id],
            ['status', 1],
            ['closeType', 1]
        ])->count();

        $selectize = Product::where([
            ['cooperative', '=', Auth::user()->id]
        ])->get(['serial', 'name', 'quantity']);


        return view('frontend.borrows.index', [
            'process' => $borrowsProcess,
            'success' => $borrowsSuccess,
            'canceled' => $borrowsCanceled,

            'selectize' => $selectize
        ]);
    }


    public function borrow(Request $request){
        $request->validate([
            'product_serial' => ['required'],
            'product_quantity' => ['required', 'integer', 'min:1', 'max:100000'],
            'product_note' => ['max:255']
        ]);


        $hasProduct = Product::where([
            ['cooperative', Auth::user()->id],
            ['serial', $request->product_serial]
        ])->first(['id', 'name', 'quantity']);

        if (!$hasProduct) return redirect()->back()
                                        ->with('class', 'danger')
                                        ->with('status', 'ไม่พบสินค้านี้');
        if ($hasProduct->quantity < $request->product_quantity) return redirect()->back()
                                        ->with('class', 'danger')
                                        ->with('status', "สินค้า $hasProduct->name คงเหลือไม่เพียงพอ (คงเหลือ $hasProduct->quantity รายการ)");

        Borrows::create([
            'cooperative' => Auth::user()->id,
            'note' => $request->product_note,
            'product' => $hasProduct->id,
            'quantity' => $request->product_quantity
        ]);

        $usedQuantity = $request->product_quantity;
        $newQuantity =  ($hasProduct->quantity)-($usedQuantity) < 0 ? 0:$hasProduct->quantity-($usedQuantity);

        Product::find($hasProduct->id)->update([
            'quantity' => $newQuantity,
        ]);

        Log::create([
            'cooperative' => Auth::user()->id,
            'serial' => $request->product_serial,
            'type'   => 4,
            'qrcode'  => 0,
            'amount' => $usedQuantity
        ]);

        $note = empty($request->product_note) ? '-':$request->product_note;
        $_date = $this->DateThai(date("Y-m-d-H-i"), true).'   '.date('H:i');

        $message = "คุณได้เบิกสินค้า $hasProduct->name จำนวน $request->product_quantity ชิ้น เรียบร้อยแล้ว!\n";
        $message = $message."หมายเหตุ : $note\n";
        $message = $message."วันที่ : $_date";
        $this->sendLine($message);

        return redirect()->route('borrows')
            ->with('class', 'success')
            ->with('status', 'เบิกสินค้าสำเร็จแล้ว!');
    }

    public function work(Request $request){
        $request->validate([
            'target' => ['required'],
            'quantity' => ['required', 'integer', 'min:1', 'max:1000000'],
            'note' => ['max:255'],
            'payment' => ['required']
        ]);


        $data = Borrows::where([
            ['borrows.cooperative', Auth::user()->id],
            ['borrows.id', $request->target]
        ])->leftJoin('products', [
            ['borrows.product', 'products.id']
        ])->first(['borrows.quantity', 'products.serial', 'products.price', 'products.name', 'borrows.status']);

        if (!$data) return redirect()->back()
                                        ->with('class', 'danger')
                                        ->with('status', 'ไม่พบการเบิกนี้');
        if ($data->status != 0) return redirect()->back() 
                                        ->with('class', 'danger')
                                        ->with('status', 'ไม่สามารถทำรายการได้เนื่องจากรายการนี้สิ้นสุดลงแล้ว!');

        $request -> validate([
            'quantity' => ['required', 'integer', 'min:1', "max:".$data->quantity]
        ]);

        $productdata = Product::where([
            ['cooperative', Auth::user()->id],
            ['serial', $data->serial]
        ])->first(['quantity', 'id']);

        /* UPDATE NEW QUANTITY */

        $borrowQuantity = $data->quantity;
        $usedQuantity   = $request->quantity;
        $remaining      = ($borrowQuantity-$usedQuantity) < 0?0:($borrowQuantity-$usedQuantity);

        /* $defaultQuantity =$productdata->quantity;
        $usedQuantity = $request->quantity;
        $remaining = ($defaultQuantity-$usedQuantity) < 0?0:($defaultQuantity-$usedQuantity); */
        
        /* UPDATE BORROWS */
        $note = empty($request->note) ? '-':$request->note;

        $update = Borrows::where([
            ['cooperative', Auth::user()->id],
            ['id', $request->target],
            ['status', 0]
        ])->update([
            'used' =>  $usedQuantity,
            'note2' => $note,
            'status' => 1
        ]);

        /* UPDATE LOG */
        
        Log::create([
            'cooperative' => Auth::user()->id,
            'serial' => (string)  $data->serial,
            'amount' => (int) $request->quantity,
            'qrcode' => $request -> payment,
            'type' => 3
        ]);

        if ($remaining > 0) {
            Log::create([
                'cooperative' => Auth::user()->id,
                'serial' => $data->serial,
                'amount' => $remaining,
                'qrcode' => 0,
                'type'   => 1
            ]);

            Product::find($productdata->id)->update([
                'quantity' => ($productdata->quantity)+$remaining
            ]); 
        }

        /* SEND LINE */

        $note = empty($request->note) ? '-':$request->note;
        $_date = $this->DateThai(date("Y-m-d-H-i"), true).'   '.date('H:i');


        $items = [];
        $items[$data->serial] = $request->quantity;

        History::create([
            'cooperative' => Auth::user()->id,
            'note'        => $note,
            'product'     => json_encode($items),
            'qrcode'      => $request->payment,
            'price'       => $data->price*$request->quantity
        ]);

        $message = "การเบิกสินค้า $data->name สิ้นสุดลงแล้ว!\n";
        $message = $message."เบิกทั้งหมด : ".($borrowQuantity)." ชิ้น\n";
        $message = $message."ยอดคงเหลือ : ".($remaining)." ชิ้น\n";
        $message = $message."วิธีการชำระเงิน : ".($request->payment == 1 ? "โอนเงิน":"เงินสด")."\n";
        $message = $message."วันที่ : $_date";
        $this->sendLine($message);

        return redirect()->route('borrowsInProcess')
            ->with('class', 'success')
            ->with('status', 'ทำรายการเสร็จสิ้นแล้ว!');
    }

    public function close(Request $request){
        $data = Borrows::where([
            ['borrows.cooperative', Auth::user()->id],
            ['borrows.id', $request->id],
            ['borrows.status', 0]
        ])->leftJoin('products', [
            ['borrows.product', 'products.id']
        ])->first(['borrows.quantity', 'products.serial', 'borrows.product', 'products.price', 'products.name', 'borrows.status']);
        
        if (!$data) return redirect()->back()
                    ->with('class', 'danger')
                    ->with('status', 'ไม่พบการเบิกนี้');

        if ($data->status != 0) return redirect()->back() 
                    ->with('class', 'danger')
                    ->with('status', 'ไม่สามารถทำรายการได้เนื่องจากรายการนี้สิ้นสุดลงแล้ว!');
        $note = empty($request->notes) ? '-':$request->notes;

        $update = Borrows::find($request->id)->update([
            'status' => 1,
            'closeType' => 1,
            'note2' => $note
        ]);

        $productdata = Product::where([
            ['cooperative', Auth::user()->id],
            ['serial', $data->serial]
        ])->first(['quantity', 'id']);

        $added = Product::find($data->product)->update([
            'quantity' => $productdata->quantity + $data->quantity
        ]);

        $log   = Log::create([
            'cooperative' => Auth::user()->id,
            'serial' => $data->serial,
            'amount' => $data->quantity,
            'qrcode' => 0,
            'type'   => 1
        ]);

        $_date = $this->DateThai(date("Y-m-d-H-i"), true).'   '.date('H:i');

        $message = "การเบิกสินค้า $data->name ถูกยกเลิกแล้ว!\n";
        $message = $message."วันที่ : $_date";
        $this->sendLine($message);

        return redirect()->route('borrows')
                        ->with('class', 'success')
                        ->with('status', 'ยกเลิกรายการเรียบร้อยแล้ว');
    }

    public function inProcess(){
        $borrows = Borrows::where([
            ['borrows.cooperative', Auth::user()->id],
            ['borrows.status', 0],
            ['borrows.closeType', 0]
        ])->leftJoin('products', [
            ['borrows.product', 'products.id'],
            ['borrows.cooperative', 'products.cooperative']
        ])->paginate(30, [
            'borrows.id',
            'borrows.quantity',
            'borrows.note',
            'borrows.status',
            'products.name',
            'borrows.created_at'
        ]);
        
        return view('frontend.borrows.process.index', [
            'borrows' => $borrows
        ]);
    }
    
    public function inProcessView (Int $id){

        $borrows           = Borrows::where([
            ['borrows.id', $id],
            ['borrows.cooperative', Auth::user()->id]
        ])->leftJoin('products', [
                ['borrows.product', 'products.id'],
                ['borrows.cooperative', 'products.cooperative']
            ])->first([
                'borrows.id',
                'borrows.quantity',
                'borrows.note',
                'borrows.status',
                'borrows.created_at',
                'products.name'
            ]);



        return view('frontend.borrows.process.view.index', [
            'borrow' => $borrows,
            'date'   => $this->DateThai($borrows->created_at->toDateTimeString()),
            'time'   => $this->GetTime($borrows->created_at->toDateTimeString())
        ]);
    }

    public function finished(Request $request) {
        $loadData = isset($request->get) ? true:false;
        if (!$loadData && isset($request->page)) {
            $loadData = true;
        }
        $data = false;

        if ($loadData) {
            $data = Borrows::where([
                ['borrows.cooperative', Auth::user()->id],
                ['borrows.status', 1],
                ['borrows.closeType', 0]
            ])->leftJoin('products', [
                ['borrows.product', 'products.id'],
                ['borrows.cooperative', 'products.cooperative']
            ])->paginate(15, [
                'borrows.id',
                'borrows.quantity',
                'borrows.note',
                'borrows.note2',
                'borrows.status',
                'borrows.created_at',
                'borrows.updated_at',
                'borrows.used',
                'products.name'
            ]);
        }

        return view('frontend.borrows.finished.index', [
            'getData' => $loadData,
            'data'    => $data
        ]);
    }

    public function borrowsFinishedView (Int $id){
        $borrows           = Borrows::where([
            ['borrows.id', $id],
            ['borrows.cooperative', Auth::user()->id]
        ])->leftJoin('products', [
                ['borrows.product', 'products.id'],
                ['borrows.cooperative', 'products.cooperative']
            ])->first([
                'borrows.id',
                'borrows.quantity',
                'borrows.note',
                'borrows.note2',
                'borrows.used',
                'borrows.status',
                'borrows.created_at',
                'borrows.updated_at',
                'products.name'
            ]);



        return view('frontend.borrows.finished.view.index', [
            'borrow' => $borrows,
            'date'   => $this->DateThai($borrows->created_at->toDateTimeString()),
            'time'   => $this->GetTime($borrows->created_at->toDateTimeString()),
            'dateEnd'   => $this->DateThai($borrows->updated_at->toDateTimeString()),
            'timeEnd'   => $this->GetTime($borrows->updated_at->toDateTimeString())
        ]);
    }


    public function canceled(){
        $borrows = Borrows::where([
            ['borrows.cooperative', Auth::user()->id],
            ['borrows.status', 1],
            ['borrows.closeType', 1]
        ])->leftJoin('products', [
            ['borrows.product', 'products.id'],
            ['borrows.cooperative', 'products.cooperative']
        ])->paginate(30, [
            'borrows.id',
            'borrows.quantity',
            'borrows.note',
            'borrows.note2',
            'borrows.status',
            'products.name',
            'borrows.created_at',
            'borrows.updated_at'
        ]);
        
        return view('frontend.borrows.canceled.index', [
            'borrows' => $borrows
        ]);
    }

    public function borrowsCanceledView (Int $id){
        $borrows           = Borrows::where([
            ['borrows.id', $id],
            ['borrows.cooperative', Auth::user()->id]
        ])->leftJoin('products', [
                ['borrows.product', 'products.id'],
                ['borrows.cooperative', 'products.cooperative']
            ])->first([
                'borrows.id',
                'borrows.quantity',
                'borrows.note',
                'borrows.note2',
                'borrows.status',
                'borrows.created_at',
                'borrows.updated_at',
                'products.name'
            ]);



        return view('frontend.borrows.canceled.view.index', [
            'borrow' => $borrows,
            'date'   => $this->DateThai($borrows->created_at->toDateTimeString()),
            'time'   => $this->GetTime($borrows->created_at->toDateTimeString()),
            'dateEnd'   => $this->DateThai($borrows->updated_at->toDateTimeString()),
            'timeEnd'   => $this->GetTime($borrows->updated_at->toDateTimeString())
        ]);
    }


    /* SUMM */

    public function fetchSummary(Request $request){
        $request->validate([
            'date' => ['required']
        ]);

        $startOfDay = Carbon::parse($request->date)->startOfDay()->toDateTimeString();
        $endOfDay   = Carbon::parse($request->date)->endOfDay()->toDateTimeString();
        $dateThai   = $this->DateThai($request->date);

        $data = Borrows::where([
            ['borrows.cooperative', Auth::user()->id],
            ['borrows.status', 1],
            ['borrows.closeType', 0]
        ])->whereBetween('borrows.updated_at', [$startOfDay, $endOfDay])
          ->leftJoin('products', [
            ['borrows.product', 'products.id']
        ])->leftJoin('categories', [
            ['products.categoryId', 'categories.id']
        ])->get([
            'borrows.product',
            'borrows.used',
            'products.categoryId',
            'products.name',
            'products.price',
            'categories.category_name'
        ]);

        if (count($data) > 0){
            return view('frontend.borrows.finished.summary.index',[
                'data' => $data,
                'date' => $dateThai
            ]);

        }else{
            return redirect()->route('borrowsFinished')
                ->with('status', "ไม่พบการเบิกสินค้าในวันที่ $dateThai")
                ->with('class', "danger");
        }
    }
     
    public function Summary (Request $request){
        return view('frontend.borrows.finished.summary.index');
    }
}
