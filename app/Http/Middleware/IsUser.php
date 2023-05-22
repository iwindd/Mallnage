<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        if (auth()->user() == null)        return redirect()->route('login');
        if (auth()->user()->isAdmin == -1) return redirect()->route('banned');
        if (auth()->user()->isAdmin == 1)  return redirect()->route('admin.home');

        $employeeSegment = [
            'cashier' => true,
            'basket'  => true,
            'history' => true,
            'profile' => true
        ];
        
        $isEmployees = auth()->user()->employees != -1 ? true:false;

        if ($isEmployees && empty($employeeSegment[request()->segment(1)]) ) return redirect()->route('cashier');

        if (auth()->user()->isAdmin == 0)  return $next($request);
        
        return redirect()->route('home');
    }
}
