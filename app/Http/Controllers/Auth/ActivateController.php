<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ActivateRequest;
use App\Http\Controllers\Controller;
use App\Mail\ActivatedEmail;
use App\Model\Verify\VerifyEmail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ActivateController extends Controller
{
    public function activate(ActivateRequest $r)
    {
        $keyUSER = $r->key;
        $keyDB = VerifyEmail::where('user_id', Auth::id())->value('_key');
        if ($keyUSER != $keyDB) {
            return response()->json([
                'error' => true,
                'msg' => 'Invalid key! Try again.'
            ], 403);
        }
        User::where('id', Auth::id())
            ->update([
                'activated' => 1
            ]);
        $verify = new VerifyEmail();
        $verify->deleteKey();
        Mail::to(Auth::user()->email)->send(new ActivatedEmail());
        return response()->json([
            'error' => false,
            'msg' => 'Activated account!'
        ], 200);
    }
}
