<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;

/* MODEL */

use App\Models\User;
use App\Models\Product;
use App\Models\History;

class UserManagementController extends Controller
{
    public function __construct(){
        $this->middleware('isAdmin');
    }



    public function management(Request $request){
        $data = $request->all();


        /* CHECK DATA NEW OR OLD */
        $currentManagementId = Session::get('management:id');
        $newSession          = isset($data['id']) ? true:false;

        if ($newSession && $data['id'] == auth::user()->id) return redirect()->route('admin.profile');
        if ($newSession && $currentManagementId != $data['id'] ) {
            /* GET DATA */
            $newSessionData      = User::find($data['id'], 
                ['id', 'username', 'name', 'isAdmin', 'grade', 'accountAge', 'created_at', 'fullname', 'tel', 'district', 'area', 'province', 'postalcode', 'address', 'lineId', 'allowed']
            );

            /* CHECK DATA */
            if ($newSessionData == null) return redirect()->route('admin.home');

            /* SAVE DATA */
            Session::put('management:name', $newSessionData->username);
            Session::put('management:id'  , $newSessionData->id);
            Session::put('management:group', $newSessionData->isAdmin);
            Session::put('management:grade', $newSessionData->grade);
            Session::put('management:aAge', $newSessionData->accountAge);
            Session::put('management:created_at', $newSessionData->created_at);
            Session::put('management:fullname', $newSessionData->fullname);
            Session::put('management:callname', $newSessionData->name);
            Session::put('management:allowed', $newSessionData->allowed);
            Session::put('management:data', $newSessionData);

            $currentManagementId          = $newSessionData->id;
        }
        


        return view('backend.management.profile.index',[
            'isAdmin'       => Session::get('management:group'),
            'grade'         => Session::get('management:grade'),
            'accountAge'    => Session::get('management:aAge'), 
            'groupLabel'    => $this->getGroupLabel(Session::get('management:group')),
            'gradeLabel'    => $this->getGradeLabel(Session::get('management:grade')),
            'accountAgeText'=> $this->DateThai(Session::get('management:aAge')),
            'created_at'    => $this->DateThai(Session::get('management:created_at'))
        ]);
    }
}
