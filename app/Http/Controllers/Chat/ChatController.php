<?php

namespace App\Http\Controllers\Chat;

use App\Http\Requests\Chat\CreateMessageRequest;
use App\Http\Resources\User\UserResource;
use App\Model\Chat\Message;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getUsers(){
        $users = User::with(['specific', 'avatar'])
            ->paginate(20);
        return UserResource::collection($users);
    }

    public function getMessagesFor($id){
        $messages = Message::where('from', $id)
            ->orWhere('to', $id)
            ->get();
        return response()->json($messages);
    }

    public function send(CreateMessageRequest $r){
        $message = Message::create([
            'from' => Auth::id(),
            'to' => $r->contact_id,
            'message' => $r->message
        ]);
        return response()->json($message);
    }
}
