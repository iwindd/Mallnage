<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


/* MODEL */
use App\Models\User;

class ProfileAdminController extends Controller
{
    public function index(){
        $data = User::find(Auth::user()->id, [
            'username', 'isAdmin'
        ]);
        
        return view('backend.profile.index', [
            'self' => $data,
            'groupLabel'  => $this->getGroupLabel($data->isAdmin)
        ]);
    }

    public function editGroup(Request $request){
        $data     = $request->all();
        $target   = auth::user()->id;

        $group    = 0;
        if ($data['group'] == 'admin') $group = 1;
        if ($data['group'] == 'ban')   $group = -1;

        $update = User::find($target)->update([
            'isAdmin' =>  $group
        ]);

        return redirect()->back()
            ->with('alert', ('แก้ไขสถานะเป็น'.$this->getGroupLabel($group)))
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


}
