<?php

namespace App\Http\Controllers\Pages\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\Articles\CreateArticleRequest;
use App\Http\Requests\Pages\Articles\EditArticleRequest;
use App\Http\Resources\Pages\ArticlesResource;
use App\Mail\AddArticleEmail;
use App\Model\Page\Article;
use App\Model\Tag\Tag;
use App\Model\User\SpecificData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::with(['categories'])
            ->where(['status' => 1])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return ArticlesResource::collection($articles);
    }

    public function store(CreateArticleRequest $r)
    {
        DB::transaction(function () use ($r) {
            $article = Article::create([
                'user_id' => Auth::id(),
                'category_id' => $r->category_id,
                'title' => $r->title,
                'article' => $r->article,
                'comment' => $r->comment,
                'tags' => ['tag_1', 'tag_2', 'tag_3']
            ]);

            // send email
            if ($r->sendEmail === 1) {
                $data = [
                    'title' => $article->title,
                    'name' => SpecificData::where('user_id', Auth::id())->value('name')
                ];
                $sendEmail = new AddArticleEmail($data);
                Mail::to(Auth::id())->send($sendEmail);
            }
            /*
             * end send email
             *
             * tag
             */
            $dataTag = [
                'tagtable_id' => $article->id,
                'tagtable_type' => 'ARTICLE'
            ];
            $tags = [
                'tags' => $r->tags
            ];

            $tag = new Tag();
            $tag->setTags($tags, $dataTag);

            // end tag
        });
        return response()->json([
            'error' => false,
            'msg' => 'Article added!'
        ], 200);
    }

    public function view($id)
    {
        $article = Article::with(['user.avatar', 'tags', 'follows', 'likesU', 'likesD', 'categories'])
            ->where(['id' => $id, 'status' => 1])
            ->first();
        return new ArticlesResource($article);
    }

    public function update(EditArticleRequest $r, Article $article)
    {
        $article->update($r->only([
            'title', 'category_id', 'article', 'comment'
        ]));
        return new ArticlesResource($article);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        $article->comments()->delete();
        $article->tags()->delete();
        $article->follows()->delete();
        return response()->json([
            'error' => false,
            'msg' => 'Article deleted!'
        ], 200);
    }

    public function articlesInCategory($id){
        $articles = Article::with(['categories'])
        ->where(['category_id' => $id, 'status' => 1])
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return ArticlesResource::collection($articles);
    }
}
