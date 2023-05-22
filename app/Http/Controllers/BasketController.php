<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

/* MODEL */
use App\Models\Product;
use App\Models\Log;
use App\Models\History;
use App\Models\Borrows;

class BasketController extends Controller{

    public function add(Request $request){
        $isRetail = $request->retail ? 1:0;
        $useBasket =  $isRetail ? "basket2":"basket";

        $cooperativeId = Auth::user()->employees != -1 ? Auth::user()->employees:Auth::user()->id;

        $data = Product::where([
            ['serial', $request->product_serial],
            ['cooperative', $cooperativeId],
            ['isRetail', $isRetail]
        ])->first();

        if (empty($data)) return redirect()->back()->with('status', 'ไม่พบสินค้าชิ้นนี้')->with('class', 'danger'); 

        $editState = empty($request->product_edit) ? false:true;
        $quantity  = isset($request->product_quantity) ? $request->product_quantity:1;

        settype($quantity, 'integer');

        $alertBorrow = false;
        $basket = $this->getBasket($useBasket);
        $alreadyInBasket = isset($basket[$data->serial]) ? true:false;
        if ($alreadyInBasket) {
            /* ADD QUANTITY */
            
            if ($editState) {
                $basket[$data->serial]['quantity'] = $quantity;
            }else{
                $basket[$data->serial]['quantity'] += $quantity;
            }

            if ($basket[$data->serial]['borrow'] == false){  
                if ($data->quantity < $basket[$data->serial]['quantity']) {
                    $basket[$data->serial]['borrow'] = true;
                }
            }else{
                if ($data->quantity >= $basket[$data->serial]['quantity']) {
                    $basket[$data->serial]['borrow'] = false;
                }
            }
          
            if ($basket[$data->serial]['borrow'] == true){
                $alertBorrow = true;
            }
        }else{
            $isBorrow = false;
   
            if ($data->quantity < $quantity) {
                $isBorrow = true;
                $alertBorrow = true;
            }
            $basket[$data->serial] = $data;
            $basket[$data->serial]['quantity'] = 1;
            $basket[$data->serial]['borrow'] = $isBorrow;
        }

        session::put($useBasket, $basket);
        $borrowText = '<br><hr><b>สินค้า "'.$data->name.'" ในสต๊อกมีไม่เพียงพอ หากต้องการที่จะทำรายการต่อ จำนวนในสต๊อกจะถูกติดลบ ! <br> (จำนวนที่มีอยู่ : '.($data->quantity).') </b>';
        if (!$alertBorrow) $borrowText = '';
        if ($editState) return redirect()->back()->with('status', 'แก้ไขสินค้าเรียบร้อยแล้ว!'.$borrowText)->with('class', 'success'); 
        return redirect()->back()->with('status', 'เพิ่มสินค้าไปที่ตะกร้าสินค้าเรียบร้อยแล้ว!'.$borrowText)->with('class', 'success'); 
    }

    public function remove(Request $request){
        $serial = $request->serial;
        $amount = $request->amount;
        $basket = $this->getBasket();


        if(isset($basket[$serial])) {
            if (($basket[$serial]['quantity']-$amount) <= 0){
                unset($basket[$serial]);
            }else{
                $basket[$serial]['quantity'] -= $amount;
            }

            session::put('basket', $basket);
        }

        return redirect()->back()->with('status', 'ลบสินค้าจากรายการสินค้าแล้ว')->with('class', 'success'); 
    }

    public function destroy(Request $request, Bool $alert = true){
        $isRetail = $request->retail ? 1:0;
        $basket = $this->getBasket($isRetail ? "basket2":"basket");

        if (isset($basket)) {
            session::put($isRetail ? "basket2":"basket", []);
        }

        if ($alert)  return redirect()->back()->with('status', 'ยกเลิกรายการแล้ว!')->with('class', 'success'); 
        if (!$alert)  return redirect()->back();
    }

    public function destroy2(String $basketName = "basket", Bool $alert = true){
        $basket = $this->getBasket($basketName);

        if (isset($basket)) {
            session::put($basketName, []);
        }

        if ($alert)  return redirect()->back()->with('status', 'ยกเลิกรายการแล้ว!')->with('class', 'success'); 
        if (!$alert)  return redirect()->back();
    }

    public function end(Request $request/* String $note, Int $price, String $withQrcode */){        
        $note = $request->noted;
        $isRetail = $request->retail ? 1:0;
        $useBasket = $isRetail ? "basket2":"basket";
        if (empty($note)) $note = '-';
        $price = $request->price;
        $withQrcode = $request->payment == '0' ? 0:1;

        $basket = $this->getBasket($useBasket);
        $items  = [];

        $message = "ซื้อขาย รายการใหม่!\n";
        $message = $message."------------------------\n";
        $cooperativeId = Auth::user()->employees != -1 ? Auth::user()->employees:Auth::user()->id;

        if (count($basket) >= 1){
            foreach($basket as $item){

                $serial = $item['serial'];
                $quantity = $item['quantity'];

                $productData = Product::where([
                    ['serial', $serial],
                    ['cooperative', $cooperativeId],
                    ['isRetail', $isRetail]
                ])->first([
                    'Quantity', 'sold', 'name'
                ]);
    
                if (isset($productData) ){
                    $currentQuantity = $productData->Quantity;
                    $usedQuantity    = $quantity;
                    $newQuantity     = $currentQuantity-$usedQuantity;
                    $items[$serial]  = $quantity;
    
                    Product::where([
                        ['serial', $serial],
                        ['cooperative', $cooperativeId],
                        ['isRetail', $isRetail]
                    ])->update([
                        'Quantity' => $newQuantity,
                        'sold'     => ($productData->sold)+$usedQuantity
                    ]);
    
                    Log::create([
                        'cooperative' =>$cooperativeId,
                        'serial' => $serial,
                        'amount' => $usedQuantity,
                        'qrcode' => $withQrcode,
                        'type' => 3,
                        'borrow' => $newQuantity < 0 ? abs($newQuantity):0,
                        'created_by' => Auth::user()->id,
                        'isRetail' => $isRetail
                    ]);  

                    if ($newQuantity <= 10) {
                        $message2 = "สินค้า $productData->name ใกล้ที่จะหมดแล้ว!";
                        $this->sendLine($message2);
                    }
    
                    $message = $message."- $productData->name จำนวน $quantity ชิ้น\n";
    
    
                    $this->destroy2($useBasket, false);
                
                }
            }

            $borrowsItems = [];

            foreach($basket as $item){
                if ($item['borrow']) {
                    array_push($borrowsItems, $item['serial']);
                }
            }

            $hisTemp = $this->randstr(20);
    
            History::create([
                'cooperative' => $cooperativeId,
                'note'        => $note,
                'product'     => json_encode($items),
                'product_borrows' => json_encode($borrowsItems),
                'qrcode'      => $withQrcode,
                'price'       => $price,
                'temp'        => $hisTemp,

                'firstname' => $request->firstname,
                'lastname' => $request->lastname,

                'address' => $request->address,
                'district' => $request->district,
                'area' => $request->area,
                'province' => $request->province,
                'postalcode' => $request->postalcode,

                'department' => $request->department,

                'created_by' => Auth::user()->id,
                'isRetail' => $isRetail
            ]);    

            $_price = number_format($price, 0);
            $_date = $this->DateThai(date("Y-m-d-H-i"), true).'   '.date('H:i');

            $message = $message."------------------------\n";
            $message = $message."ราคาทั้งหมด : $_price บาท\n";
            $message = $message."หมายเหตุ : $note\n";
            $message = $message."วิธีการชำระเงิน : ".($withQrcode == 1 ? "โอนเงิน":"เงินสด")."\n";
            $message = $message."วันที่ : $_date";
            $this->sendLine($message);

            $hisId = null;

            while ($hisId == null) {
                $query = History::where([
                    ['cooperative', $cooperativeId],
                    ['note', $note],
                    ['product', json_encode($items)],
                    ['qrcode', $withQrcode],
                    ['price', $price],
                    ['temp', $hisTemp],
                    ['isRetail', $isRetail]
                ])->first('id');

                if ($query->id){
                    $hisId = $query->id;
                }
            }

            History::find($hisId)->update([
                'temp' => null
            ]);

            return redirect()->back()
                ->with('status', 'จบรายการแล้ว <a href="'.route('historyReceipt', $hisId).'">รับใบเสร็จ</a>')
                ->with('class', 'warning')
                ->with('items', $items)
                ->with('price', $price);
        }else{
            return redirect()->back()->with('status', 'ไม่มีสินค้าในรายการ ไม่สามารถจบรายการได้')->with('class', 'danger');
        }


    }

    public function borrow(String $note){
/*         $items = [];
        $basket = empty($_COOKIE['basket']) ? null:$_COOKIE['basket'];

        
        if (isset($basket)) {
            foreach ($basket as $serial => $quantity) {
                settype($quantity, 'integer');
                $items[$serial] = $quantity;
            }

            $encode = json_encode($items);
            $borrows = Borrows::create([
                'cooperative' => Auth::user()->id,
                'note' => $note,
                'products' => $encode
            ]);
            setcookie('basket', null, -1, '/');

            return redirect()->back()
                ->with('status', 'เบิกสินค้าในรายการแล้ว')
                ->with('class', 'warning');
        }else{
            return redirect()->back()->with('status', 'ไม่มีสินค้าในรายการ ไม่สามารถจบรายการได้')->with('class', 'danger');
        } */
    }
}
