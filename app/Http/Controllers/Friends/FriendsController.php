<?php

namespace App\Http\Controllers\Friends;

use App\Http\Controllers\Controller;
use App\Http\Requests\Friends\CreateFriendRequest;
use App\Http\Requests\Friends\EditFriendRequest;
use App\Http\Resources\Friends\FriendsResource;
use App\Model\Friend\Friend;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    // SEND INVITATION
    public function sendInvitation(CreateFriendRequest $r)
    {
        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $r->friend_id
        ]);
        return response()->json([
            'error' => false,
            'msg' => 'Sent invitation'
        ], 200);
    }

    // SENT INVITATIONS
    public function sentInvitations()
    {
        $sentInvitations = Friend::with(['user'])
            ->where(['user_id' => Auth::id(), 'status' => 1])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return FriendsResource::collection($sentInvitations);
    }

    // ACCEPT INVITATION
    public function acceptInvitation(EditFriendRequest $r, Friend $friend)
    {
        $friend->update($r->only([
            'status' => 2 // accept invitation
        ]));
        return new FriendsResource($friend);
    }

    // WAITING INVITATIONS
    public function waitingInvitations()
    {
        $waitingInvitations = Friend::with(['friend'])
            ->where(['friend_id' => Auth::id(), 'status' => 1])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return FriendsResource::collection($waitingInvitations);
    }

    // FRIENDS
    public function friends()
    {
        $friends = Friend::with(['user', 'friend'])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return FriendsResource::collection($friends);
    }
}
