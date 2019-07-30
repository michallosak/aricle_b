<?php

namespace App\Http\Controllers\Friends;

use App\Http\Controllers\Controller;
use App\Http\Resources\Friends\FriendsResource;
use App\Model\Friend\Friend;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    // SEND INVITATION
    public function sendInvitation($id)
    {
        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $id
        ]);
        return response()->json([
            'error' => false,
            'msg' => 'Sent invitation'
        ], 200);
    }

    // SENT INVITATIONS
    public function sentInvitations()
    {
        $sentInvitations = Friend::with(['user.avatar', 'user.specific'])
            ->where(['user_id' => Auth::id(), 'status' => 1])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return FriendsResource::collection($sentInvitations);
    }

    // ACCEPT INVITATION
    public function acceptInvitation()
    {
        Friend::where(['friend_id' => Auth::id()])
            ->update(['status' => 2]);
        return true;
    }

    // WAITING INVITATIONS
    public function waitingInvitations()
    {
        $waitingInvitations = Friend::with(['user.avatar', 'user.specific'])
            ->where(['friend_id' => Auth::id(), 'status' => 1])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return FriendsResource::collection($waitingInvitations);
    }

    // FRIENDS
    public function friends()
    {
        $friends = Friend::with(['user', 'friend'])
            ->where(['user_id' => Auth::id(), 'status' => 2])
            ->orWhere(['friend_id' => Auth::id(), 'status' => 2])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return FriendsResource::collection($friends);
    }

    //DELETE FRIEND
    public function destroy(Friend $friend){
        $friend->delete();
    }
}
