<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* MODEL */
use App\Models\Departments;

class DepartmentController extends Controller
{
    //
    public function get(){
        return view('backend.departments.index',[
            'items' => Departments::all()
        ]);
    }

    public function add(Request $request){
        $request->validate([
            'departmentName' => 'required|max:70'
        ]);

        Departments::create([
            'label' => $request->departmentName
        ]);

        return redirect()->back()
            ->with('alert', 'เพิ่มแผนกเรียบร้อยแล้ว!')
            ->with('alert-type', 'success');
    }
    

    public function delete(Request $request){
        $request->validate([
            'target' => 'required'
        ]);
        Departments::find($request->target)->delete();
        return redirect()->back()
            ->with('alert', 'ลบแผนกเรียบร้อยแล้ว!')
            ->with('alert-type', 'success');

    }

    public function edit(Request $request){
        $request->validate([
            'target' => 'required',
            'departmentName' => 'required|max:70'
        ]);

        Departments::find($request->target)->update(
            [
                'label' => $request->departmentName
            ]
        );
        return redirect()->back()
            ->with('alert', 'แก้ไขแผนกเรียบร้อยแล้ว!')
            ->with('alert-type', 'success');
    }
}
