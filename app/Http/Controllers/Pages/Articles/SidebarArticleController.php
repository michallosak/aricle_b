<?php

namespace App\Http\Controllers\Pages\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pages\ArticlesResource;
use App\Model\Page\Article;

class SidebarArticleController extends Controller
{
    public function articlesInCategory($id){
        $articles = Article::with([])
            ->where(['category_id' => $id, 'status' => 1])
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        return ArticlesResource::collection($articles);
    }
}
