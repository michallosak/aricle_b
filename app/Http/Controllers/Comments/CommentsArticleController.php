<?php

namespace App\Http\Controllers\Comments;

use App\Http\Requests\Comments\CreateCommentRequest;
use App\Http\Requests\Comments\EditCommentRequest;
use App\Http\Resources\Comments\CommentsResource;
use App\Model\Comment\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsArticleController extends Controller
{
    public function index($id)
    {
        $comments = Comment::with(['user', 'answers', 'likesU', 'likesD'])
            ->where(['commentable_id' => $id, 'commentable_type' => 'ARTICLE'])
            ->orderBy('id', 'DESC')
            ->paginate(15);
        return CommentsResource::collection($comments);
    }

    public function store(CreateCommentRequest $r)
    {
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'comment' => $r->comment,
            'commentable_id' => $r->commentable_id,
            'commentable_type' => 'ARTICLE'
        ]);
        return new CommentsResource($comment);
    }

    public function update(EditCommentRequest $r, Comment $comment)
    {
        $comment->update($r->only([
            'comment'
        ]));
        return new CommentsResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->answers()->delete();
        $comment->delete();
        return response()->json();
    }
}
