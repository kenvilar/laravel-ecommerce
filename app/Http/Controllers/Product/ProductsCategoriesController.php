<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class ProductsCategoriesController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);

        $this->middleware('api:auth')->except(['index']);
    }

    public function index(Product $product)
    {
        $categories = $product->categories;

        return $this->showAll($categories);
    }

    public function update(Request $request, Product $product, Category $category)
    {
        /**
         * To interact with many-to-many relationsships, we can use these methods -
         * attach(), sync(), and syncWithoutDetaching
         * In attach() - The model that is attached will be added even if it is duplicated
         * In sync() - The model that is attached will be added but other current ids will be deleted
         * In syncWithoutDetaching() - Sync the intermediate tables with a list of IDs without detaching
         */
        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories);
    }

    public function destroy(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('The specefied category is not a category of this product.', 404);
        }

        $product->categories()->detach($category->id);

        return $this->showAll($product->categories);
    }
}
