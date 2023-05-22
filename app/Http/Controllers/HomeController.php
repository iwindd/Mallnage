<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Borrows;
use App\Models\Categories;
use App\Models\Receipt;
use App\Models\Log;
use App\Models\History;
use App\Models\User;
use App\Models\Departments;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin(){


        $users          = User::all()->count();
        $usersUnAllowed = User::where([['allowed', '0']])->count();
        $usersAllowed   = User::where([['allowed', '1']])->count();
        $banned   = User::where([['isAdmin', '-1'], ['allowed', '1']])->count();
        $expire   =  User::whereDate('accountAge', '>', Carbon::now())->count();
        $departments   =  Departments::all()->count();



        return view('backend.home.index', [
            'users' => $users,
            'unallowed' => $usersUnAllowed,
            'allowed' => $usersAllowed,
            'banned' => $banned+$expire,
            'departments' => $departments
        ]);
    }

    public function adminUsers(Request $request){
        $filter = $request->t;
        $result = [];

        if ($filter == 2) {
            $result = User::where([
                ['allowed' , '1'],
                ['isAdmin', '0'],
                ['employees', '=' , '-1']
            ])->whereDate('accountAge', '>', Carbon::now())->get();
        }else if ($filter == 3) {
            $result = User::where([
                ['allowed' , '0'],
                ['isAdmin', '0'],
                ['employees', '=' , '-1']
            ])->get(); 
        }else if($filter == 4){
            $result = User::where([
                ['allowed' , '1'],
                ['isAdmin', '0'],
                ['employees', '=' , '-1']
            ])->whereDate('accountAge', '<', Carbon::now())->get();
        }else if($filter == 5){
            $result = User::where([
                ['isAdmin', '-1'],
                ['employees', '=' , '-1']
            ])->get();
        }else{
            $result = User::all();
        }

        return view('backend.users.index', [
            'result' => $result,
            't' => $filter
        ]);
    }

    public function user(){
        $histories = History::where([
            ['cooperative', Auth::user()->id]
        ])->count();

        $categories = Categories::where([
            ['cooperative', Auth::user()->id]
        ])->count();

        $startDay   = Carbon::now()->startOfDay()->toDateTimeString();
        $endDay     = Carbon::now()->endOfDay()->toDateTimeString();
        $trade = $this->getPriceOfTrade($startDay, $endDay);

        return view('frontend.home.index', [
            'employees' => User::where([ ['employees', auth::user()->id]])->count(),
            'receipt'  => Receipt::where([['cooperative', Auth::user()->id]])->count(),
            'histories'=> $histories,
            'categories'=> $categories,
            'trade' => $trade
        ]);
    }

    public function guest(){

        return redirect()->route('login');
/*         $products = Product::all()->count();
        $users = User::all()->count();
        $users_pro = User::where([['grade', '1']])->count();
        $users_basic = User::where([['grade', '0']])->count();


        return view('guest.index.index', [
            'products' => $products,
            'users' => $users,
            'users_pro' => $users_pro,
            'users_basic' => $users_basic
        ]); */
    }
}
