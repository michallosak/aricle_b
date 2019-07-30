<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ActivateRequest;
use App\Http\Controllers\Controller;
use App\Model\Verify\VerifyEmail;


class ActivateController extends Controller
{
    public function activate(ActivateRequest $r)
    {
        $data = [
            'key' => $r->key
        ];
        $activate = new VerifyEmail();
        $activate->activateAccount($r->key);
    }
}
