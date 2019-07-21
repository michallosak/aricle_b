<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Model\Privacy\Privacy;
use App\Model\User\PhotosUser;
use App\Model\User\SpecificData;
use App\Model\Verify\VerifyEmail;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $r)
    {
        DB::transaction(function () use ($r) {
            $sex = $r->sex;
            if ($sex != 1) {
                // man
                $avatar = 'http://intercastor.pl/wp-content/uploads/2017/01/default_user_icon.jpg';
            } else {
                // woman
                $avatar = 'http://babyathome.pl/wp-content/uploads/2014/07/avatar-woman.png';
            }
            $user = User::create([
                'email' => $r->email,
                'password' => Hash::make($r->password)
            ]);
            $specific = SpecificData::create([
                'user_id' => $user->id,
                'name' => $r->name,
                'last_name' => $r->last_name,
                'day_birthday' => $r->day_birthday,
                'month_birthday' => $r->month_birthday,
                'year_birthday' => $r->year_birthday,
                'sex' => $sex
            ]);
            PhotosUser::create([
                'user_id' => $user->id,
                'src' => $avatar,
                'type' => 'AVATAR'
            ]);
            Privacy::create([
                'user_id' => $user->id
            ]);
            $name = $specific->name;
            $email = $user->email;
            $verify = new VerifyEmail();
            $verify->setVerifyKey($user->id);
            $verify->sendEmailVerify($user->id, $email, $name);
        });
        return response()->json([
            'error' => false,
            'msg' => 'Register success!'
        ], 200);
    }
}
