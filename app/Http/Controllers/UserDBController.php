<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;


/* MODAL */
use App\Models\User;

class UserDBController extends Controller
{
    public function __construct(){
        $this->middleware('isAdmin');
    }
    
    public function add(Request $request){
        $request->validate([
            'username' => ['required', 'string', 'regex:/\w*$/', 'max:100', 'unique:users'],
            'name'     => ['required', 'string', 'max:100'],
            'fullname' => ['required', 'string', 'max:100'],
            'group'    => ['required', 'string'],
            'grade'    => ['required', 'string'],
            'AccountAge' => ['required']
        ]);



        $data     = $request->all();
        $password = $this->randstr(4);

        $group    = 0;
        if ($data['group'] == 'admin') $group = 1;
        if ($data['group'] == 'ban')   $group = -1;

        $grade    = 1;
        if ($data['grade'] == 'basic') $grade = 0; 
        if ($data['grade'] == 'pro') $grade = 1; 

        User::create([
            'username' => $data['username'],
            'fullname' => $data['fullname'],
            'name'     => $data['name'],
            'password' => Hash::make($password),
            'isAdmin'  => $group,
            'grade'    => $grade,
            'accountAge'      => $data['AccountAge']

            
        ]);


        return redirect()->route('admin.home')
            ->with('add_username', $data['username'])
            ->with('add_name', $data['name'])
            ->with('add_password', $password)
            ->with('add_group', $this->getGroupLabel($group))
            ->with('add_grade', $this->getGradeLabel($grade))
            ->with('add_accountAge', $this->DateThai($data['AccountAge']));
    }
    
    public function editGroup(Request $request){
        $data     = $request->all();
        $target   = Session::get('management:id');

        $group    = 0;
        if ($data['group'] == 'admin') $group = 1;
        if ($data['group'] == 'ban')   $group = -1;
     
        $update = User::find($target)->update([
            'isAdmin' => $group
        ]);

        if ($update) Session::put('management:group', $group);
        
        return redirect()->back()
            ->with('alert', ('แก้ไขสถานะเป็น'.($this->getGroupLabel($group)).'สำเร็จแล้ว'))
            ->with('alert-type', 'success');
    }

    public function editGrade(Request $request){
        $data     = $request->all();
        $target   = Session::get('management:id');

        $grade    = 0;
        if ($data['group'] == 'basic') $grade = 0;
        if ($data['group'] == 'pro')   $grade = 1;
     
        $update = User::find($target)->update([
            'grade' => $grade
        ]);

        if ($update) Session::put('management:grade', $grade);
        
        return redirect()->back()
            ->with('alert', ('แก้ไขระดับเป็น '.($this->getGradeLabel($grade)).' สำเร็จแล้ว'))
            ->with('alert-type', 'success');
    }

    public function editAccountAge(Request $request){
        $data     = $request->all();
        $target   = Session::get('management:id');

        $date     = $data['SelectAge'];
        $update   = User::find($target)->update([
            'accountAge' => $date
        ]);

        if ($update) Session::put('management:aAge', $date);
        
        return redirect()->back()
            ->with('alert', ('แก้ไขวันหมดอายุเป็นวันที่ '.($this->DateThai($date)).' สำเร็จแล้ว'))
            ->with('alert-type', 'success');
    }

    public function editPassword(Request $request){
        $request->validate([
            'passwordNew' => 'require|regex:/^[a-zA-Z0-9]+$/|confirmed|min:6|max:100'
        ]);

        $target   = Session::get('management:id');
        $data     = $request->all();

        User::whereId($target)->update([
            'password' => Hash::make($data['passwordNew'])
        ]);

        return redirect()->back()
            ->with('alert', 'แก้ไขรหัสผ่านแล้ว')
            ->with('alert-type', 'success');
    }

    public function editFullname (Request $request){
        $request->validate([
            'Fullname' => ['required', 'string', 'max:100']
        ]);

        $target   = Session::get('management:id');
        $update   = User::whereId($target)->update([
            'fullname' => $request->Fullname
        ]);

        if ($update) Session::put('management:fullname', $request->Fullname);


        return redirect()->back()
            ->with('alert', 'แก้ไขชื่อผู้จัดการแล้ว')
            ->with('alert-type', 'success');

    }

    public function editName  (Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:100']
        ]);

        $target   = Session::get('management:id');
        $update   = User::whereId($target)->update([
            'name' => $request->name
        ]);

        if ($update) Session::put('management:callname', $request->name);


        return redirect()->back()
            ->with('alert', 'แก้ไขชื่อร้านแล้ว')
            ->with('alert-type', 'success');

    }

    public function toggleAllowed(Request $request){
        $target = Session::get('management:id');
        $newAllowed = Session::get('management:allowed') == 1 ? 0:1;

        $update = User::whereId($target)->update([
            'allowed' => $newAllowed
        ]);

        if ($update) Session::put('management:allowed', $newAllowed);

        return redirect()->back()
            ->with('alert', 'แก้ไขสถานะสำเร็จแล้ว')
            ->with('alert-type', 'success');
    }

    private function updateData($dataName, $dataValue){
        $data = Session::get('management:data');
        $data[$dataName] = $dataValue;
        Session::put('management:data', $data);
    }

    public function editTel(Request $request){
        $target = Session::get('management:id');
        $request->validate([
            'tel' => 'required|max:10|min:10',
        ]);
        
        $update = User::whereId($target)->update([
            'tel' => $request->tel
        ]);

        if($update) $this->updateData('tel', $request->tel);
        return redirect()->back()
            ->with('alert', 'แก้ไขเบอร์โทรศัพท์สำเร็จ!')
            ->with('alert-type', 'success');

    }

    public function editLineId(Request $request){
        $target = Session::get('management:id');
        $request->validate([
            'lineId' => 'required',
        ]);
        
        $update = User::whereId($target)->update([
            'lineId' => $request->lineId
        ]);

        if ($update) $this->updateData('lineId', $request->lineId);
        return redirect()->back()
            ->with('alert', 'แก้ไข LINE ID สำเร็จ!')
            ->with('alert-type', 'success');
    }

    public function editAddress(Request $request){
        $target = Session::get('management:id');
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
            'postalcode' => $request->postalCode
        ]);

        if ($update) $this->updateData('address', $request->address);
        if ($update) $this->updateData('district', $request->district);
        if ($update) $this->updateData('area', $request->area);
        if ($update) $this->updateData('province', $request->province);
        if ($update) $this->updateData('postalcode', $request->postalcode);

        return redirect()->back()
            ->with('alert', 'แก้ไขที่อยู่สำเร็จ!')
            ->with('alert-type', 'success');
    }

}
