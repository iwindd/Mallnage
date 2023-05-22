<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/* MODEL */
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function get(Request $request){
        $isSearch = isset($request->search) ? true:false;
        $categories;

        if (!$isSearch) {
            $categories = Categories::where([
                ['cooperative', Auth::user()->id]
            ])->paginate(20, ['id', 'category_name', 'created_at']);
        }else{
            $categories = Categories::where([
                ['cooperative', '=', Auth::user()->id],
                ['category_name', 'LIKE', "%$request->search%"],
            ])->paginate(20, ['id', 'category_name', 'created_at']);
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
}
