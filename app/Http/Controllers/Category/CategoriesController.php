<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoriesController extends ApiController
{
    public function index()
    {
        $categories = Category::all();

        return $this->showAll($categories);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $newCategory = Category::query()->create($request->all());
        
        return $this->showOne($newCategory, 201);
    }

    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->fill($request->only([
            'name', 'description'
        ]));

        if (!$category->isDirty()) {
            return $this->errorResponse('You need to specify any different value to update.', 422);
        }

        $category->update();
        
        return $this->showOne($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        
        return $this->showOne($category);
    }
}
