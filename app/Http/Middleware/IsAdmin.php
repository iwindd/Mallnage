<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
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
        if (auth()->user()->isAdmin == 1)  return $next($request);
    
        return redirect()->route('home')
            ->with('status', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้!')
            ->with("class", 'danger');
    }
}
