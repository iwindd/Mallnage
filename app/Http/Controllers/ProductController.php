<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Storage;
/* MODEL */
use App\Models\Product;
use App\Models\Categories;
use App\Models\Barcode;
use App\Models\Log;
use App\Models\History;

/* ETC */
use Picqer\Barcode\BarcodeGeneratorJPG as generator;


class ProductController extends Controller
{
    public function get(Request $request){
        $products = Product::where([ 
             ['products.cooperative', Auth::user()->id] 
        ])->leftJoin('categories', [ 
             ['categories.id', 'products.categoryId'] 
         ])->get(['products.serial', 'products.name', 'products.price', 'products.quantity', 'products.cost', 'categories.category_name']) ;

        return view('frontend.product.index', [
            'products' => $products
        ]);
    }

    public function search($name){
        return view('frontend.product.index', [
            'products' => Product::where('name', 'like', '%'.$name.'%')->where('cooperative', '=', Auth::user()->id)->paginate(8,[
                'serial', 'name', 'price', 'Quantity', 'image'
            ])
        ]);
    }

    public function barcode(Request $request){
        if (empty($request->id)) return redirect()->back();
        $validate = Product::where([
            ['cooperative', Auth::user()->id],
            ['serial', $request->id]
        ])->first(['id', 'barcodeGen']);

        if (empty($validate)) return redirect()->back();

        $barserial = null;
        


        if (empty($validate->barcodeGen)){
            /* GEN */
            function checkEan($digits){
                if($digits <= 0) return 0;
                while(strlen($digits) < 13){
                    $digits = '0'.$digits;
                }
                $digits=preg_split("//",$digits,-1,PREG_SPLIT_NO_EMPTY);
                $a=$b=0;
                for($i=0;$i<6;$i++){
                    $a+=(int)array_shift($digits);
                    $b+=(int)array_shift($digits);
                }
                $total=($a*1)+($b*3);
                $nextten=ceil($total/10)*10;
                return $nextten-$total==array_shift($digits);
            }

            if (checkEan($request->id) !== true){
                $barserial = $this->genEan($request->id);

                $update    = Product::where([
                    ['cooperative', Auth::user()->id],
                    ['serial', $request->id]
                ])->update([
                    'barcodeGen' => $barserial
                ]);
            }else{
                $barserial = $request->id;
            }

        }else{
            $barserial = $validate->barcodeGen;
        }


        if ($barserial !== null){
            $generator = new generator();
            $barcode   = $generator->getBarcode($barserial, $generator::TYPE_EAN_13);
            $name      = Auth::user()->id.$request->id.hexdec(uniqid()).($barserial);
            $path      = 'image/barcode/'.$name.'.jpg';
            
            file_put_contents($path, $barcode);
            return response()->download(public_path($path))->deleteFileAfterSend(true); 
        }else{
            return redirect()->route('home');
        }

    }

    public function add(){
        return view('frontend.product.add.index');
    }

    public function summary(Request $request){
        $request->validate([
            'date' => ['required']
        ]);

        $startOfDay = Carbon::parse($request->date)->startOfDay()->toDateTimeString();
        $endOfDay   = Carbon::parse($request->date)->endOfDay()->toDateTimeString();
        $dateThai   = $this->DateThai($request->date);

/*         $data = Log::where([
            ['logs.cooperative', Auth::user()->id],
            ['logs.type', 3],
            ['logs.amount', '>', 0]
        ])->whereBetween('logs.created_at', [$startOfDay, $endOfDay])
          ->leftJoin('products', [
            ['logs.serial', 'products.serial'],
            ['logs.cooperative', 'products.cooperative']
        ])->leftJoin('categories', [
            ['products.categoryId', 'categories.id']
        ])->get([
            'logs.serial',
            'logs.amount',
            'products.id',
            'products.categoryId',
            'products.name',
            'products.price',
            'categories.category_name'
        ]); */

        $data = History::where([
            ['cooperative', Auth::user()->id],
        ])->whereBetween('created_at', [$startOfDay, $endOfDay])
        ->get();

        if (count($data) > 0){
            return view('frontend.summary.index',[
                'data' => $data,
                'date' => $dateThai
            ]);

        }else{
            return redirect()->route('home')
                ->with('status', "ไม่พบการซื้อขายภายในวันที่ $dateThai")
                ->with('class', "danger");
        }
    }

    public function edit (Request $request, $serial){
        $isRetail = $request->retail ? 1:0;

        if ($this->isOwnedProduct($serial) == false) {
            return redirect()->route('home');
        }

        $data = Product::where([
            ['serial', '=', $serial],
            ['cooperative', '=', Auth::user()->id],
            ['isRetail', $isRetail]
        ])->first([
            'serial', 'name', 'price', 'image', 'Quantity', 'cost', 'categoryId'
        ]);

        $categories = Categories::where([
            ['cooperative', Auth::user()->id]
        ])->get(['id', 'category_name']);

        return view('frontend.product.edit.index', [
            'data' => $data,
            'categories' => $categories,
            'isRetail' => $isRetail
        ]);
    }

    public function _get(){
        return view('backend.management.product.index', [
            'products' => Product::where('cooperative', Session::get('management:id'))->get([
                'serial', 'name', 'price', 'Quantity', 'sold', 'cost'
            ])
        ]);
    }

    public function _view(String $serial){
        if (!isset($serial)) return redirect()->back();

        $data = Product::where([
            ['serial', $serial],
            ['cooperative', Session::get('management:id')]
        ])->first([
            'serial', 'Quantity', 'price', 'name', 'image', 'cost'
        ]);

        return view('backend.management.product.view.index', [
            'product' => $data
        ]);
    }
}
