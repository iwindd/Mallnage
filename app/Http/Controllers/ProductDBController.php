<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
/* MODEL */
use App\Models\Product;
use App\Models\Categories;
use App\Models\Borrows;
use App\Models\History;
use App\Models\Log;

class ProductDBController extends Controller
{

    /* USER */
    public function store(Request $request){
        $isRetail = $request->retail ? 1:0;

        $request -> validate([
            'product_serial' => 'required|integer'
        ],[
            'product_serial.required' => "รหัสสินค้าไม่ถูกต้อง !"
        ]);

        $product = Product::where([
            ['serial', '=', $request->product_serial],
            ['cooperative', '=', Auth::user()->id],
            ['isRetail', $isRetail]
        ])->take(1)->get('cooperative');

        if(count($product) <= 0) {
            Product::create([

                /* GET */
                'cooperative' => Auth::user()->id,  /* COOPERATIVE ID */
                'serial'      => $request->product_serial, /* PRODUCT SERIAL */

                /* DEFAULT */
                'name'        => 'สินค้าไม่มีชื่อ',
                'price'       => 0,
                'quantity'    => 0,
                'added'       => 0,
                'sold'        => 0,
                'image'       => '',
                'isRetail'    => $isRetail,
                'categoryId'  => 0

            ]);

            /* NEW ITEM */
            $this->sendLine("มีการเพิ่มสินค้าใหม่!");

            /* CREATE LOG แก้บัคตอน export pdf */
            Log::create([
                'cooperative' =>  Auth::user()->id,
                'serial' => $request->product_serial,
                'amount' => 0,
                'isRetail' => $isRetail,
                'type' => 3
            ]);
        }

        return redirect()->route("productEdit", ['serial'=>$request->product_serial, 'retail' => $request->retail]);
    }

    public function quick_store(Request $request){
        function AlreadyHaveThisSerial($serial){
            return Product::where([
                ['cooperative', Auth::user()->id],
                ['serial', $serial]
            ])->count() <= 0 ? false:true;
        }

        $serial = rand(1, 99999999999);
        while (AlreadyHaveThisSerial($serial) == true) {
            $serial = rand(1, 99999999999);
        }

        return redirect()->route('product', ['retail' => $request->retail])
                ->with('randSerial', $serial);
    }

    public function edit(Request $request, String $serial){
        $isRetail = $request->retail ? 1:0;

        $request -> validate([
            'product_name'   => 'required|max:50|min:1',
            'product_price'  => 'required|max:1000000|min:0|numeric',
            'product_cost'  => 'required|max:1000000|min:0|numeric',
            'product_amount' => 'required|max:1000000|numeric',
            'product_category' => 'required'
        ],[
            'product_name.required' => 'กรุณาป้อนชื่อให้ถูกต้อง',

            'product_price.required' => 'กรุณาป้อนราคาให้ถูกต้อง',
            'product_price.required' => 'กรุณาป้อนราคาให้ถูกต้อง',
            
            'product_cost.required' => 'กรุณาป้อนราคาให้ถูกต้อง',
            'product_cost.max'      => 'กรุณาป้อนราคาให้ถูกต้อง',

            'product_amount.required' => 'กรุณาป้อนจำนวนสินค้าให้ถูกต้อง',
            'product_amount.max'      => 'กรุณาป้อนจำนวนสินค้าให้ถูกต้อง'

        ]);

        $product_image_full_path = '';

        if ($request->product_image_old !== null) {
            $product_image_full_path = $request->product_image_old;
        }


        /* VALIDATE OWNER */
        $redirectRoute      = empty($_COOKIE["redirect_route"]) ? "home":$_COOKIE["redirect_route"];
        $owner = count(Product::where([
            ['serial', '=', $serial],
            ['cooperative', '=', Auth::user()->id],
            ['isRetail', $isRetail ]
        ])->get('cooperative')) <= 0 ? false:true;

        if (!$owner) return redirect()->route($redirectRoute, ['retail' => $request->retail]);

        /* LOG ADD && REMOVE */
        $productData = Product::where([
            ['serial', '=', $serial],
            ['cooperative', '=', Auth::user()->id],
            ['isRetail', $isRetail ]
        ])->first(['Quantity', 'added']);

        $defaultQuanlity = $productData->Quantity;
        $newQuanlity = $request->product_amount;

        setType($newQuanlity, 'integer');
        
        /* 1 = add */
        /* 2 = remove */
        /* 3 = sell */

        if ($defaultQuanlity > $newQuanlity && !($defaultQuanlity == $newQuanlity)) {
            Log::create([
                'cooperative' =>  Auth::user()->id,
                'serial' => $serial,
                'amount' => ($defaultQuanlity-$newQuanlity < 0 ? $defaultQuanlity:($defaultQuanlity-$newQuanlity)),
                'type' => 2,
                'isRetail' => $isRetail
            ]);
        }else if($defaultQuanlity < $newQuanlity && !($defaultQuanlity == $newQuanlity)){
            Log::create([
                'cooperative' =>  Auth::user()->id,
                'serial' => $serial,
                'amount' => (($newQuanlity-$defaultQuanlity) < 0 ? $defaultQuanlity:($newQuanlity-$defaultQuanlity)),
                'type' => 1,
                'isRetail' => $isRetail
            ]);    

            Product::where([
                ['serial', $serial],
                ['cooperative', Auth::user()->id],
                ['isRetail', $isRetail ]
            ])->update([
                'added' => $productData->added+(($newQuanlity-$defaultQuanlity) < 0 ? $defaultQuanlity:($newQuanlity-$defaultQuanlity))
            ]);
        }

        /* ----------- */

        if ($request->product_image){

            /* GET NAME */
            $product_image = $request->product_image;
            $product_image_ext      = strtolower($product_image->getClientOriginalExtension());
            $product_image_name     = hexdec(uniqid()).($request->product_serial).'.'.$product_image_ext;

            /* UPLOAD */

            $product_image_path      = 'image/products/';
            $product_image_full_path = $product_image_path.$product_image_name;

            if ($request->product_image_old !== null) {
                unlink($request->product_image_old); 
            }

            $product_image->move($product_image_path, $product_image_name);
        }


        $changeCategoryTo = $request->product_category;

        $categoryChecked = Categories::where([
            ['cooperative', Auth::user()->id],
            ['id', $request->product_category]
        ])->count();

        if ($categoryChecked <= 0) {
            $changeCategoryTo = 0;
        }

        Product::where([
            ['serial', '=', $serial],
            ['cooperative', '=', Auth::user()->id],
            ['isRetail', $isRetail ]
        ])->update([
            'categoryId' => $changeCategoryTo,
            'name' => $request->product_name,
            'price' => $request->product_price,
            'cost' => $request->product_cost,
            'Quantity' => $request->product_amount,
            'image' => $product_image_full_path
        ]);


        $redirectStatusText = $redirectRoute == "home" ? 'แก้ไขสินค้า"'.($request->product_name).'" แล้ว !':'เพิ่มสินค้า "'.($request->product_name).'" สำเร็จ !';
        $redirectAdded      = $redirectRoute == "home" ? false:true;
        return redirect()->route('product', ['retail' => $request->retail])
            ->with("added",false)
            ->with('status', $redirectStatusText); 
    }

    public function delete(Request $request, String $serial){
        $isRetail = $request->retail ? 1:0;
        /* DELETE IMAGE */
        /*         $image = Product::where([
                    ['serial', '=', $serial],
                    ['cooperative', '=', Auth::user()->id]
                ])->first('image')->product_image;
                if ($image) {
                    unlink($image);
                } */

        $data = Product::where([
            ['serial', $serial],
            ['cooperative', Auth::user()->id],
            ['isRetail', $isRetail]
        ])->first('id');

        /* DELETE DATA */

        $delete        = Product::where([
            ['serial',  $serial],
            ['cooperative', Auth::user()->id],
            ['isRetail', $isRetail]
        ])->delete();

        $deleteLog     = Log::where([
            ['serial',  $serial],
            ['cooperative', Auth::user()->id],
            ['isRetail', $isRetail]
        ])->delete();

        if($isRetail == 0){
            $deleteBorrows = Borrows::where([
                ['cooperative', Auth::user()->id],
                ['product', $data->id]
            ])->delete();
        }

        $histories = History::where([
            ['cooperative', Auth::user()->id],
            ['product', 'like', "%$serial%"],
            ['isRetail', $isRetail]
        ])->get(['id', 'product']);

        if (count($histories) > 0) {
            foreach ($histories as $history) {
                $list = json_decode($history->product);
                $newlist = [];
                foreach($list as $n_serial => $quantity) {
                    if ($n_serial != $serial) {
                        $newlist[$n_serial] = $quantity;
                    }
                }

               $updateHistory = History::find($history->id)->update([
                'product' => json_encode($newlist)
               ]);
            }
        }


        $redirectRoute = empty($_COOKIE["redirect_route"]) ? "products":$_COOKIE["redirect_route"];

        return redirect()->route('product', ['retail' => $isRetail])->with('status', 'ลบสินค้า สำเร็จ !'); 
    }

    /* ADMIN */
    public function _edit(Request $request){
        $request -> validate([
            'name'   => 'required|max:50',
            'price'  => 'required|max:1000000|numeric',
            'Quantity' => 'required|max:1000000|numeric',
            'cost' => 'required|max:1000000|numeric'
        ],[
            'name.required' => 'กรุณาป้อนชื่อให้ถูกต้อง',

            'price.required' => 'กรุณาป้อนราคาให้ถูกต้อง',
            'price.max'      => 'กรุณาป้อนราคาให้ถูกต้อง',

            'Quantity.required' => 'กรุณาป้อนจำนวนสินค้าให้ถูกต้อง',
            'Quantity.max'      => 'กรุณาป้อนจำนวนสินค้าให้ถูกต้อง'
        ]);

        if (Auth::user()->isAdmin != 1) return redirect()->back(); /* CHECK ADMIN */


        $product_image_full_path = '';

        if ($request->product_image_old !== null) {
            $product_image_full_path = $request->product_image_old;
        }

        if ($request->product_image){
            $product_image = $request->product_image;
            $product_image_ext      = strtolower($product_image->getClientOriginalExtension());
            $product_image_name     = hexdec(uniqid()).($request->_productSerial).'.'.$product_image_ext;

            $product_image_path      = 'image/products/';
            $product_image_full_path = $product_image_path.$product_image_name;

            if ($request->product_image_old !== null) {
                unlink($request->product_image_old); 
            }

            $product_image->move($product_image_path, $product_image_name);
        }


        Product::where([
            ['serial', '=', $request->_productSerial],
            ['cooperative', '=', Session::get('management:id')]
        ])->update([
            'name' => $request->name,
            'price' => $request->price,
            'cost' => $request->cost,
            'Quantity' => $request->Quantity,
            'image' => $product_image_full_path
        ]);
        return redirect()->back()
            ->with('alert', 'แก้ไขสินค้าเรียบร้อยแล้ว!')
            ->with('alert-type', 'success'); 
    }

    public function _delete(Request $request){
        if (Auth::user()->isAdmin != 1) return redirect()->back(); /* CHECK ADMIN */

        /* DELETE IMAGE */
        $image = Product::where([
            ['serial', '=', $request->_productSerial],
            ['cooperative', '=', Session::get('management:id')]
        ])->first('image')->product_image;
        if ($image) {
            unlink($image);
        }
   
        /* DELETE DATA */
        $delete        = Product::where([
            ['serial', '=', $request->_productSerial],
            ['cooperative', '=', Session::get('management:id')]
        ])->delete();

        $deleteLog     = Log::where([
            ['serial', '=', $request->_productSerial],
            ['cooperative', '=', Session::get('management:id')],
        ])->delete();

        return redirect()->route('admin.managements.product')
            ->with('alert', 'แก้ไขสินค้าเรียบร้อยแล้ว!')
            ->with('alert-type', 'success'); 
    }

    public function _store(Request $request){
        $id = Session::get('management:id');

        $request->validate([
            'product_serial'    => 'required|unique:products,serial,null,cooperative,cooperative,'.$id,
            'product_name'      => 'required|max:50',
            'product_price'     => 'required|max:1000000|numeric',
            'product_Quantity'  => 'required|max:1000000|numeric',
            'product_cost'  => 'required|max:1000000|numeric'
        ]);

        if (Auth::user()->isAdmin != 1) return redirect()->back(); /* CHECK ADMIN */
        
        $product_image_full_path = '';

        if ($request->product_image){
            $product_image = $request->product_image;
            $product_image_ext      = strtolower($product_image->getClientOriginalExtension());
            $product_image_name     = hexdec(uniqid()).($request->_productSerial).'.'.$product_image_ext;

            $product_image_path      = 'image/products/';
            $product_image_full_path = $product_image_path.$product_image_name;
            $product_image->move($product_image_path, $product_image_name);
        }

        Product::create([
            /* GET */
            'cooperative' => $id,  /* COOPERATIVE ID */
            'serial'      => $request->product_serial, /* PRODUCT SERIAL */

            /* DEFAULT */
            'name'        => $request->product_name,
            'price'       => $request->product_price,
            'quantity'    => $request->product_Quantity,
            'cost'        => $request->product_cost,
            'added'       => 0,
            'sold'        => 0,
            'image'       => $product_image_full_path,

        ]);

        /* CREATE LOG แก้บัคตอน export pdf */
        Log::create([
            'cooperative' =>  $id,
            'serial'      => $request->product_serial,
            'amount'      => 0,
            'type'        => 3
        ]);

        return redirect()->back()
                ->with('alert', 'เพิ่มสินค้าสำเร็จแล้ว!')
                ->with('alert-type', 'success');
    }
}
