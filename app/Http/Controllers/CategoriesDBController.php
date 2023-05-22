<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\Categories;
use App\Models\Product;

class CategoriesDBController extends Controller
{
    public function store (Request $request){
        $request->validate([
            'category_name'   => 'required|max:50',
        ]);

        $alreadyHaveQuantity = Categories::where([
            ['cooperative', Auth::user()->id]
        ])->count();

        if ($alreadyHaveQuantity >= 200 ) {
            return redirect()->back()
                ->with('status', 'ไม่สามารถเพิ่มประเภทสินค้าเกิน 200 ประเภทได้!')
                ->with('alert-type', 'danger'); 
        }

        $create = Categories::create([
            'cooperative'   => Auth::user()->id,
            'category_name' => $request->category_name
        ]);

        return redirect()->back()
            ->with('status', "เพิ่มประเภทสินค้า $request->category_name เรียบร้อยแล้ว!")
            ->with('alert-type', 'success'); 
    }


    public function update(Request $request){
        $request->validate([
            'category_name' => 'required|max:50',
            'id' => 'required'
        ]);

        $update = Categories::where([
            ['cooperative', Auth::user()->id],
            ['id', $request->id]
        ])->update([
            'category_name' => $request->category_name
        ]);

        if ($update) {
            return redirect()->route('categories')
                ->with('status', "แก้ประเภทสินค้าจาก $request->oldName เป็น $request->category_name เรียบร้อยแล้ว!")
                ->with('alert-type', 'success'); 
        }else{
            return redirect()->route('categories')
                ->with('status', "ไม่สามารถแก้ไขประเภทสินค้าได้ กรุณาลองใหม่อีกครั้งในภายหลัง!")
                ->with('alert-type', 'danger'); 
        }
    }

    public function delete(Request $request){

        $delete = Categories::where([
            ['cooperative', Auth::user()->id],
            ['id', $request->id]
        ])->delete();
        
        Product::where([
            ['cooperative', Auth::user()->id],
            ['categoryId', $request->id]
        ])->update([
            'categoryId' => 0
        ]);
        

        if ($delete) {
            return redirect()->route('categories')
                ->with('status', "ลบประเภทสินค้า $request->name เรียบร้อยแล้ว!")
                ->with('alert-type', 'success'); 
        }else{
            return redirect()->route('categories')
                ->with('status', "ไม่สามารถลบประเภทสินค้าได้ กรุณาลองใหม่อีกครั้งในภายหลัง!")
                ->with('alert-type', 'danger'); 
        }
    }
}
