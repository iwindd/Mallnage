<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
/* MODELS */
use App\Models\User;

class EmployeeController extends Controller
{
    public function get(){
        $employees = User::where([
            ['employees', auth::user()->id],
        ])->get();

        return view('frontend.employees.index', [
            'employees' => $employees
        ]);
    }

    public function add(){
        return view('frontend.employees.add.index');
    }

    public function insert(Request $request){

        $requestData = $request->all();
        $requestData['username'] = auth::user()->username.'.'.$requestData['username'];
        $request->replace($requestData);

        $request->validate([
            'fullname' => 'required|max:100',
            'username' => 'required|regex:/^\S*$/u|string|max:100|min:6',
            'password' => 'required|regex:/^[a-zA-Z0-9]+$/|max:100|min:6|confirmed',
            'tel' => 'required|max:10|min:10',
            'line_id'  => 'required|max:100',
            'address' => 'required|max:255',
            'district' => 'required|max:50',
            'area' => 'required|max:50',
            'province' => 'required|max:50',
            'postalcode' => 'required|max:50'
        ]); 

        User::create([
            'employees' => auth::user()->id,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'fullname' => $request->fullname,
            'name'     => auth::user()->name,
            'tel'      => $request->tel,  
            'lineId'   => $request->line_id,
            'address'    => $request->address,
            'district'   => $request->district,
            'area'       => $request->area,
            'province'   => $request->province,
            'postalcode' => $request->postalcode,
            'accountAge' => auth::user()->accountAge,

            'allowed'  => true,
            'isAdmin'  => 0,
            'grade'    => 0        
        ]);

        return redirect()->route('employees')
            ->with('status', 'เพิ่มพนักงานสำเร็จ!')
            ->with('alert-type', 'success');
    }

    public function editPassword(Request $request){

        $request->validate([
            'passwordNew' => 'required|regex:/^[a-zA-Z0-9]+$/|confirmed|min:6|max:100'
        ]);


        $target   = $request->target;
        $data     = $request->all();

        User::where([
            ['id', $target],
            ['employees', auth()->user()->id]
        ])->update([
            'password' => Hash::make($data['passwordNew'])
        ]);

        return redirect()->back()
            ->with('status', 'แก้ไขรหัสผ่านแล้ว')
            ->with('alert-type', 'success');
    }

    public function manage(Request $request){
        $data = User::where([
            ['id', $request->id],
            ['employees', auth::user()->id]
        ])->first();

        if (empty($data)) {
            return redirect()->route('employees');
        }

        return view('frontend.employees.manage.index', [
            'data' => $data
        ]);
    }

    public function edit (Request $request){
        $request->validate([
            'fullname' => 'required|max:100',
            'tel' => 'required|max:10|min:10',
            'line_id'  => 'required|max:100',
            'address' => 'required|max:255',
            'district' => 'required|max:50',
            'area' => 'required|max:50',
            'province' => 'required|max:50',
            'postalcode' => 'required|max:50'
        ]); 

        $update = User::where([
            ['id', $request->target],
            ['employees', auth::user()->id] 
        ])->update([
            'fullname' => $request->fullname,
            'tel'      => $request->tel,  
            'lineId'   => $request->line_id,
            'address'    => $request->address,
            'district'   => $request->district,
            'area'       => $request->area,
            'province'   => $request->province,
            'postalcode' => $request->postalcode
        ]);

        if ($update){
            return redirect()->back()
                ->with('status', 'แก้ไขข้อมูลพนักงานสำเร็จ!')
                ->with('alert-type', 'success');
        }else{
            return redirect()->back()
                ->with('status', 'เพิ่มพนักงานไม่สำเร็จ!')
                ->with('alert-type', 'danger');
        }
    }
}
