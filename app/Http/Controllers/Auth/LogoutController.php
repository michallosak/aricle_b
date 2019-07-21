<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function logout(Request $r)
    {
        $r->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
