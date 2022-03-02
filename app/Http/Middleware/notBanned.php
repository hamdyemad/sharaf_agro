<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class notBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->banned == 0) {
            return $next($request);
        } else {
            Auth::logout();
            return redirect()->back()->with('error', 'تم حذرك مع الأسف');
        }
    }
}
