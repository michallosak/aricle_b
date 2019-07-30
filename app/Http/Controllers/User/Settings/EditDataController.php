<?php

namespace App\Http\Controllers\User\Settings;

use App\Http\Requests\User\Settings\AdditionalDataRequest;
use App\Http\Requests\User\Settings\AvatarRequest;
use App\Http\Requests\User\Settings\BasicDataRequest;
use App\Http\Requests\User\Settings\EmailRequest;
use App\Http\Requests\User\Settings\UsernameRequest;
use App\Model\User\AdditionalInformation;
use App\Model\User\SpecificData;
use App\Model\Verify\VerifyEmail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EditDataController extends Controller
{
    public function editEmail(EmailRequest $r)
    {
        $v = new VerifyEmail();
        $v->ifCorrectKey($r->key);
        User::where('id', Auth::id())
            ->update([
                'email' => $r->email
            ]);
        return response()->json([
            'error' => false,
            'msg' => 'Updated email'
        ], 200);
    }

    public function editBasicData(BasicDataRequest $r)
    {
        SpecificData::where('user_id', Auth::id())
            ->update([
                'name' => $r->name,
                'last_name' => $r->last_name,
                'day_birthday' => $r->day_birthday,
                'month_birthday' => $r->month_birthday,
                'year_birthday' => $r->year_birthday
            ]);
        return response()->json(['msg' => 'EDIT'], 200);
    }

    public function editAvatar(AvatarRequest $r)
    {

    }

    public function editUsername(UsernameRequest $r)
    {
        SpecificData::where('user_id', Auth::id())
            ->update([
                'username' => $r->username
            ]);
        return response()->json(['error' => false, 'msg' => 'Updated username'], 200);
    }

    public function editAdditionalData(AdditionalDataRequest $r)
    {
        AdditionalInformation::where('user_id', Auth::id())
            ->update([
                'interests' => $r->interests,
                'description' => $r->description,
                'add_information' => $r->add_information,
                'city' => $r->city
            ]);
        return response()->json(['error' => false, 'msg' => 'Updated additional data'], 200);
    }
}
