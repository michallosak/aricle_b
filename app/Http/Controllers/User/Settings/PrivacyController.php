<?php

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Settings\PrivacyRequest;
use App\Http\Resources\User\PrivacyResource;
use App\Model\Privacy\Privacy;
use Illuminate\Support\Facades\Auth;

class PrivacyController extends Controller
{
    public function setPrivacy(PrivacyRequest $r){
        $set = Privacy::where('user_id', Auth::id())
            ->update([
                'viewProfil' => $r->viewProfil,
                'viewFriends' => $r->viewFriends,
                'viewDateB' => $r->viewDateB,
                'viewEmail' => $r->viewEmail,
                'viewArticles' => $r->viewArticles,
                'viewPhotos' => $r->viewPhotos
            ]);
        return new PrivacyResource($set);
    }

    public function settingsPrivacy(){
        $privacy = Privacy::where('user_id', Auth::id())
            ->first();
        return new PrivacyResource($privacy);
    }

    public function restartPrivacy(){
        $privacy = Privacy::where('user_id', Auth::id())
            ->update([
                'viewProfil' => 1,
                'viewFriends' => 1,
                'viewDateB' => 1,
                'viewEmail' => 1,
                'viewArticles' => 1,
                'viewPhotos' => 1
            ]);
        return new PrivacyResource($privacy);
    }
}
