<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/* MODEL */
use App\Models\Product;

class StockController extends Controller
{
    public function get(Request $request){
        $isRetail = $request->retail ? 1:0;
        $filter = empty($request->filter) ? null:$request->filter;
        $search = empty($request->search) ? null:$request->search;

        $products = null;
        $fill = [
            'products.serial', 
            'products.name', 
            'products.price', 
            'products.Quantity',
            'products.isRetail',
            'categories.category_name'
        ];

        if ($filter !== null) {
            if ($search !== null) {
                if ($filter == '1') {
                    $products = Product::where([
                        ['products.cooperative', Auth::user()->id],
                        ['products.quantity', '>', 0],
                        ['products.name', "LIKE", "%$search%"],
                        ['products.isRetail', $isRetail]
                    ])->leftJoin('categories', [
                        ['categories.id', 'products.categoryId']
                    ])->paginate(20, $fill);
                }else if ($filter == '2'){
                    $products = Product::where([
                        ['products.cooperative', Auth::user()->id],
                        ['products.quantity', '<=', 0],
                        ['products.name', "LIKE", "%$search%"],
                        ['products.isRetail', $isRetail]
                    ])->leftJoin('categories', [
                        ['categories.id', 'products.categoryId']
                    ])->paginate(20, $fill);
                }else if ($filter == '3'){
                    $products = Product::where([
                        ['products.cooperative', Auth::user()->id],
                        ['products.quantity', '<', 0],
                        ['products.name', "LIKE", "%$search%"],
                        ['products.isRetail', $isRetail]
                    ])->leftJoin('categories', [
                        ['categories.id', 'products.categoryId']
                    ])->paginate(20, $fill);
                }else{
                    $products = Product::where([
                        ['products.cooperative', Auth::user()->id],
                        ['products.name', "LIKE", "%$search%"],
                        ['products.isRetail', $isRetail]
                    ])->leftJoin('categories', [
                        ['categories.id', 'products.categoryId']
                    ])->paginate(20, $fill);
                }
            }else{
                if ($filter == '1') {
                    $products = Product::where([
                        ['products.cooperative', Auth::user()->id],
                        ['products.quantity', '>', 0],
                        ['products.isRetail', $isRetail]
                    ])->leftJoin('categories', [
                        ['categories.id', 'products.categoryId']
                    ])->paginate(20, $fill);
                }else if ($filter == '2'){
                    $products = Product::where([
                        ['products.cooperative', Auth::user()->id],
                        ['products.quantity', '<=', 0],
                        ['products.isRetail', $isRetail]
                    ])->leftJoin('categories', [
                        ['categories.id', 'products.categoryId']
                    ])->paginate(20, $fill);
                }else if ($filter == '3'){
                    $products = Product::where([
                        ['products.cooperative', Auth::user()->id],
                        ['products.quantity', '<', 0],
                        ['products.isRetail', $isRetail]
                    ])->leftJoin('categories', [
                        ['categories.id', 'products.categoryId']
                    ])->paginate(20, $fill);
                }else{
                    $products = Product::where([
                        ['products.cooperative', Auth::user()->id],
                        ['products.isRetail', $isRetail]
                    ])->leftJoin('categories', [
                        ['categories.id', 'products.categoryId']
                    ])->paginate(20, $fill);
                }
            }
        }else{
            $products = Product::where([
                ['products.cooperative', Auth::user()->id],
                ['products.isRetail', $isRetail]
            ])->leftJoin('categories', [
                ['categories.id', 'products.categoryId']
            ])->paginate(20, $fill);
        }




        $Selectize = Product::where([
            ['cooperative', '=', Auth::user()->id],
            ['products.isRetail', $isRetail]
        ])->get(['serial', 'name']);

        return view('frontend.stock.index', [
            'products' => $products,
            'selectize' => $Selectize,
            'isRetail' => $isRetail,
            '_filter' => $filter,
            '_search' => $search
        ]);
    }

    public function search(String $name, Request $request){
        $filter  = empty($request->filter) ? null:$request->filter;
        $products = null;
        $fill = [
            'serial', 
            'name', 
            'price', 
            'Quantity'
        ];

        if ($filter !== null && ($filter == '1' || $filter == '2')) {
            if ($filter == '1') {
                $products = Product::where([
                    ['Quantity', '>', 0],
                    ['name', 'like', "%$name%"],
                    ['cooperative', '=', Auth::user()->id]
                ])->paginate(20, $fill);
            }else{
                $products = Product::where([
                    ['Quantity', '<=', 0],
                    ['name', 'like', "%$name%"],
                    ['cooperative', '=', Auth::user()->id]
                ])->paginate(20, $fill);
            }
        }else{
            $products = Product::where([
                ['name', 'like', "%$name%"],
                ['cooperative', '=', Auth::user()->id]
            ])->paginate(20, $fill);
        }

        return view('frontend.stock.index', ['products' => $products]);
    }

    
}
