<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ActivatedAccount
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
        if (Auth::check() && Auth::user()->activated != 1){
            return response()->json([
                'error' => true,
                'msg' => 'Your account is not activated!'
            ], 403);
        }
        return $next($request);
    }
}
