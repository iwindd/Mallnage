<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
 
        if (auth()->attempt([
            'username' => $data['username'],
            'password' => $data['password'],
            'allowed'  => 1
        ])){
            /* CLEAT BASKET */
            app('App\Http\Controllers\BasketController')->destroy2("basket", false);
            app('App\Http\Controllers\BasketController')->destroy2("basket2", false);
            Session::put('cooperative:title', auth()->user()->name);

            /* CHECK EMPLOYEES */
            if (auth()->user()->employees != -1) {
                $query = User::where([
                    ['id', auth()->user()->employees]
                ])->first();


                if (empty($query)) {
                    $query = User::where('id', auth()->user()->id)->update([
                        'isAdmin' => -1
                    ]);
                    return redirect()->route('banned');
                }else{
                    $data = auth()->user();
                    if ($data->grade != $query->grade || $data->name != $query->name){
                        $update = User::where('id', $data->id)->update([
                            'grade' => $query->grade,
                            'name' => $query->name
                        ]);

                        Session::put('cooperative:title', $query->name);

                    }
                }
            }


            /* CHECK ADMIN STATE */
            if (auth()->user()->isAdmin == 1){
                return redirect()->route('admin.home');
            }else{
                return redirect()->route('home');
            }
        }else{
            /* USERNAME OR PASSWORD ARE WRONG THEN REDIRECT TO LOGIN */
            return redirect()->route('login')->with('error', 'ไม่พบผู้ใช้นี้!');
        }
    }
}
