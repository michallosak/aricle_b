<?php

namespace App\Http\Controllers\Categories;

use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\EditCategoryRequest;
use App\Http\Resources\Categories\CategoriesResource;
use App\Model\Category\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return CategoriesResource::collection($categories);
    }

    public function store(CreateCategoryRequest $r)
    {
        $category = Category::create([
            'user_id' => Auth::id(),
            'name' => $r->name
        ]);
        return new CategoriesResource($category);
    }

    public function update(EditCategoryRequest $r, Category $category)
    {
        $category->update($r->only([
            'name'
        ]));
        return new CategoriesResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
    }
}
