<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

/* MODEL */
use App\Models\Categories;
use App\Models\Product;

class CategoriesController extends Controller
{
    public function get(Request $request){
        $isSearch = isset($request->search) ? true : false;

        if (!$isSearch) {
            $categories = Categories::where([
                ['categories.cooperative', Auth::user()->id]
            ])
                ->leftJoin("products", [
                    ["products.categoryId", "=", "categories.id"]
                ])
                ->select(
                    'categories.id',
                    'categories.category_name',
                    'categories.created_at'
                )
                ->selectRaw('GROUP_CONCAT(products.quantity) as product_quantities')
                ->selectRaw('GROUP_CONCAT(products.isRetail) as product_is_retail')
                ->groupBy('categories.id')
                ->paginate(20);

            $categoriesArray = $categories->toArray();

            foreach ($categoriesArray['data'] as &$category) {
                $category['product_quantities'] = explode(',', $category['product_quantities']);
                $category['product_is_retail'] = explode(',', $category['product_is_retail']);

                $category['total_quantity'] = array_sum($category['product_quantities']);
            }

            unset($category); // Unset the reference to the last element

            $categories->setCollection(collect($categoriesArray['data']));
        } else {
            $categories = Categories::where([
                ['categories.cooperative', Auth::user()->id],
                ['category_name', 'LIKE', "%$request->search%"],
            ])
                ->leftJoin("products", [
                    ["products.categoryId", "=", "categories.id"]
                ])
                ->select(
                    'categories.id',
                    'categories.category_name',
                    'categories.created_at'
                )
                ->selectRaw('GROUP_CONCAT(products.quantity) as product_quantities')
                ->selectRaw('GROUP_CONCAT(products.isRetail) as product_is_retail')
                ->groupBy('categories.id')
                ->paginate(20);

            $categoriesArray = $categories->toArray();

            foreach ($categoriesArray['data'] as &$category) {
                $category['product_quantities'] = explode(',', $category['product_quantities']);
                $category['product_is_retail'] = explode(',', $category['product_is_retail']);

                $category['total_quantity'] = array_sum($category['product_quantities']);
            }

            unset($category); // Unset the reference to the last element

            $categories->setCollection(collect($categoriesArray['data']));
        }

        return view('frontend.category.index', [
            'categories' => $categories,
            '_search' => $request->search
        ]);
    }

    public function view(Request $request){
        if (empty($request->id)) return redirect()->route('home');

        $data = Categories::where([
            ['cooperative', Auth::user()->id],
            ['id', $request->id]
        ])->first(['id', 'category_name', 'created_at']);

        if (empty($data)) return redirect()->back()
            ->with('alert', 'ไม่พบประเภทสินค้านี้!')
            ->with('alert-type', 'danger');

        return view('frontend.category.view.index', [
            'data' => $data
        ]);
    }

    public function pdf(Request $request){
        if (empty($request->id)) return redirect()->route('home');

        $products = Product::where([
            ['cooperative', Auth::user()->id],
            ['categoryId', $request->id]
        ])
            ->orderBy('name', 'ASC')
            ->get(['name', 'quantity']);

        
        $pdf = PDF::loadView('frontend.category.pdf.index', [
            'products' => $products,
            'categoryName' => Categories::where([
                ['cooperative', Auth::user()->id],
                ['id', $request->id]
            ])->first(['category_name'])->category_name
        ]);
    
        return  $pdf -> stream('pdf.pdf');
    }
}
