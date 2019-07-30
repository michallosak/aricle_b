<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Model\Verify\VerifyEmail;
use App\User;
use Illuminate\Support\Facades\Auth;

class VerifyController extends Controller
{
    public function verify()
    {
        $user = new User();
        $verify = new VerifyEmail();
        $verify->setKey(Auth::id(), $user->getFullName(), Auth::user()->email);
    }
}
