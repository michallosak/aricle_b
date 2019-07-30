<?php

namespace App\Http\Controllers\Files\Photos;

use App\Http\Requests\Files\Photos\User\AddPhotoRequest;
use App\Http\Resources\Files\Photos\UserPhotosResource;
use App\Model\User\PhotosUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserPhotosController extends Controller
{
    public function index()
    {
        $photos = PhotosUser::where(['user_id' => Auth::id(), 'type' => 'PHOTO'])
            ->orderBy('id', 'DESC')
            ->get();
        return UserPhotosResource::collection($photos);
    }

    public function store(AddPhotoRequest $r)
    {
        if (count($r->images)) {
            foreach ($r->images as $image) {
                //$image->store('images');
                PhotosUser::create([
                    'user_id' => Auth::id(),
                    'href' => $image,
                    'type' => 'PHOTO'
                ]);
            }
        }

        return response()->json([
            'message' => 'Done',
        ], 200);
    }

    public function destroy(PhotosUser $photo)
    {
        $photo->delete();
        return true;
    }
}
