<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/* MODAL */
use App\Models\User;

class UserController extends Controller
{
    public function add(){
        return view('backend.users.adduser.index');
    }

    public function signup()
    {
        return view('auth.register');
    }

    public function signupAdd(Request $request){
        $request->validate([
            'username' => 'required|string|regex:/^[a-zA-Z0-9]+$/|max:100|min:6|unique:users',
            'password' => 'required|regex:/^[a-zA-Z0-9]+$/|max:100|min:6|confirmed',
            'fullname' => 'required|max:100',
            'cooperativeName' => 'required|max:100',
            'tel_phone' => 'required|max:10|min:10',
            'lineId'  => 'required|max:100|unique:users',
            'address' => 'required|max:255',
            'district' => 'required|max:50',
            'area' => 'required|max:50',
            'Province' => 'required|max:50',
            'PostalCode' => 'required|max:50'
        ]);



        $grade    = 0;
        if ($request->package == 'basic') $grade = 0; 
        if ($request->package == 'pro')   $grade = 1; 

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'fullname' => $request->fullname,
            'name'     => $request->cooperativeName,
            'tel'      => $request->tel_phone,  
            'lineId'   => $request->lineId,
            'address' => $request->address,
            'district' => $request->district,
            'area' => $request->area,
            'province' => $request->Province,
            'postalcode' => $request->PostalCode,
            'accountAge' => $request->dateSelected,

            'isAdmin'  => 0,
            'grade'    => $grade            
        ]);

        return redirect()->route('login')
            ->with('status', 'การลงทะเบียนสำเร็จ! กรุณารอการติดต่อกลับไปด้วยครับ!')
            ->with('class', 'success');
    }


}
