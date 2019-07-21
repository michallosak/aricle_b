<?php

namespace App\Model\Verify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyEmail extends Model
{
    protected $fillable = [
        'user_id', '_key'
    ];

    public $demo;

    public function setVerifyKey($userID){
        $key = substr(md5(time() . date('Y-m-d H:i:s')), 15, 15);
        VerifyEmail::create([
            'user_id' => $userID,
            '_key' => $key
        ]);
    }

    /**
     * @param $userID
     * @param $email
     * @param $name
     */
    public function sendEmailVerify($userID, $email, $name){
        $data = [
            'name' => $name,
            'email' => $email,
            'key' => $key = VerifyEmail::where('user_id', $userID)->value('_key')
        ];
        $v = new \App\Mail\VerifyEmail($data);
        $v->data = $data;
        Mail::to($email)->send($v);
    }


    public function deleteKey(){
        VerifyEmail::where('user_id', Auth::id())
            ->delete();
    }
}
