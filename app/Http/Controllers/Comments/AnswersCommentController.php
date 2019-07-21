<?php

namespace App\Http\Controllers\Comments;

use App\Http\Requests\Comments\Answers\CreateReplyRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\Answers\EditReplyRequest;
use App\Http\Resources\Comments\CommentsResource;
use App\Model\Comment\Reply;
use Illuminate\Support\Facades\Auth;

class AnswersCommentController extends Controller
{
    public function store(CreateReplyRequest $r)
    {
        $reply = Reply::create([
            'user_id' => Auth::id(),
            'comment_id' => $r->comment_id,
            'reply' => $r->reply
        ]);
        return new CommentsResource($reply);
    }

    public function update(EditReplyRequest $r, Reply $reply)
    {
        $reply->update($r->only([
            'reply'
        ]));
        return new CommentsResource($reply);
    }

    public function destroy(Reply $reply)
    {
        $reply->delete();
        return response()->json([
            'error' => false,
            'msg' => 'Reply comment deleted!'
        ], 200);
    }
}
