<?php

namespace App\Model\Verify;

use App\Mail\ActivatedEmail;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyEmail extends Model
{
    protected $fillable = [
        'user_id', '_key'
    ];

    public function ifCorrectKey($key){
        if ($key != $this->getKeyUser()){
            return response()->json([
                'msg' => 'Incorrect code!'
            ], 403);
        }
        $this->deleteKey();
        return true;
    }

    public function setKey($userID, $name, $email){
        $key = $this->createKey();
        VerifyEmail::create([
            'user_id' => $userID,
            '_key' => $key
        ]);
        $data = [
            'name' => $name,
            'email' => $email,
            'key' => $key
        ];
        $this->sendVerifyEmail($data);
    }

    private function createKey(){
        $key = substr(md5(time() . date('Y-m-d H:i:s')), 15, 15);
        return $key;
    }

    private function sendVerifyEmail($data){
        $v = new \App\Mail\VerifyEmail($data);
        $v->data = $data;
        Mail::to($data['email'])->send($v);
    }

    private function getKeyUser(){
        $key = VerifyEmail::where('user_id', Auth::id())->value('_key');
        return $key;
    }

    private function deleteKey(){
        VerifyEmail::where('user_id', Auth::id())
            ->delete();
    }

    public function activateAccount($key){
        $this->ifCorrectKey($key);
        User::where('id', Auth::id())
            ->update([
                'activated' => 1
            ]);
        $this->sendEmailActivated();
        return true;
    }

    private function sendEmailActivated(){
        Mail::to(Auth::user()->email)->send(new ActivatedEmail());
    }
}
