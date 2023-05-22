<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
/* MODEL */
use App\Models\User;

class CooperativeController extends Controller
{
    public function get(){
        $lineToken = Auth()->user()->lineToken;
        $fullname  = Auth()->user()->fullname;
        $fullname_manager = Auth()->user()->fullname;

        $isEmployees = Auth::user()->employees != -1 ? true:false;

        if ($isEmployees) {
            $query = User::where([
                ['id', Auth::user()->employees]
            ])->first('fullname');
            $fullname_manager = $query->fullname;
        }

        return view('frontend.setting.index', [
            'lineToken' => $lineToken,
            'aAge'=> $this->DateThai(Auth::user()->accountAge),
            'Grade' => $this->getGradeLabel(Auth::user()->grade),
            'fullname' => $fullname,
            'fullname_manager' => $fullname_manager,
            'data' => Auth()->user()
        ]);
    }

    public function editLineNotification (Request $request){
        $request->validate([
            'lineToken' => 'required'
        ]);
        $data     = $request->all();
        $target   = auth::user()->id;

        $update = User::find($target)->update([
            'lineToken' =>  $data['lineToken']
        ]);

        return redirect()->back()
            ->with('alert', 'แก้ไขข้อมูลเรียบร้อยแล้ว')
            ->with('alert-type', 'success');
    }

    public function editPassword(Request $request){
        /* VALIDATE */
        $request->validate([
            'passwordOld' => 'required|min:4',
            'passwordNew' => 'required|regex:/^[a-zA-Z0-9]+$/|confirmed|min:6|max:100'
        ]);

        if (!Hash::check($request->passwordOld, auth()->user()->password)){
            return redirect()->back()
            ->with('alert', 'ไม่สามารถแก้ไขรหัสผ่านได้ เนื่องจากรหัสผ่านเก่าไม่ถูกต้อง')
            ->with('alert-type', 'danger');
        }
        
        /* GET DATA */
        $data = $request->all();

        /* UPDATE */
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($data['passwordNew'])
        ]);

        /* REDIRECT */
        return redirect()->back()
            ->with('alert', 'แก้ไขรหัสผ่านแล้ว')
            ->with('alert-type', 'success');
    }

    public function editTel(Request $request){
        $target = auth()->user()->id;
        $request->validate([
            'tel' => 'required|max:10|min:10',
        ]);
        
        $update = User::whereId($target)->update([
            'tel' => $request->tel
        ]);

        return redirect()->back()
            ->with('alert', 'แก้ไขเบอร์โทรศัพท์สำเร็จ!')
            ->with('alert-type', 'success');
    }

    public function editLineId (Request $request){
        $target = auth()->user()->id;
        $request->validate([
            'lineId' => 'required',
        ]);
        
        $update = User::whereId($target)->update([
            'lineId' => $request->lineId
        ]);

        return redirect()->back()
            ->with('alert', 'แก้ไข LINE ID สำเร็จ!')
            ->with('alert-type', 'success');
    }

    public function editAddress(Request $request){
        $target = auth()->user()->id;
        $request->validate([
            'address'       => 'required|max:255',
            'district'      => 'required|max:50',
            'area'          => 'required|max:50',
            'province'      => 'required|max:50',
            'postalcode'    => 'required|max:50'
        ]);
  
        $update = User::whereId($target)->update([
            'address' => $request->address,
            'district' => $request->district,
            'area' => $request->area,
            'province' => $request->province,
            'postalcode' => $request->postalcode
        ]);



        return redirect()->back()
            ->with('alert', 'แก้ไขที่อยู่สำเร็จ!')
            ->with('alert-type', 'success');
    }
}
