<?php

namespace App\Http\Controllers\User\Settings;

use App\Http\Requests\User\Settings\AvatarRequest;
use App\Http\Requests\User\Settings\BasicDataRequest;
use App\Http\Requests\User\Settings\EmailRequest;
use App\Http\Resources\User\UserResource;
use App\Model\User\SpecificData;
use App\Model\Verify\VerifyEmail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EditDataController extends Controller
{
    public function editEmail(EmailRequest $r){
        if (VerifyEmail::where('user_id', Auth::id()->value('_key')) != $r->key){
            return response()->json([
                'error' => true,
                'msg' => 'Invalid key!'
            ], 403);
        }
        User::where('id', Auth::id())
            ->update([
                'email' => $r->email
            ]);
        $verif = new VerifyEmail();
        $verif->deleteKey();
        return response()->json([
            'error' => false,
            'msg' => 'Updated email'
        ], 200);
    }

    public function editBasicData(BasicDataRequest $r){
        $data = SpecificData::where('user_id', Auth::id())
            ->update([
                'name' => $r->name,
                'last_name' => $r->last_name,
                'day_birthday' => $r->day_birthday,
                'month_birthday' => $r->month_birthday,
                'year_birthday' => $r->year_birthday
            ]);
        return new UserResource($data);
    }

    public function editAvatar(AvatarRequest $r){

    }
}
