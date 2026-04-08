<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{

    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $categories = $product->categories()->orderBy('id', 'asc')->get();;
        return $this->showElement($categories);
    }

    public function update(Request $request, $productId, $categoryId)
    {
        $product = Product::findOrFail($productId);
        $category = Category::findOrFail($categoryId);
        $product->categories()->syncWithoutDetaching([$category->id]);//agrega la categoria a la lista de categorias del productos,
        return $this->showElement($product->categories);
    }


    public function destroy($productId, $categoryId)
    {
        $product = Product::findOrFail($productId);

        $category = Category::find($categoryId);

        if(is_null($category))
        {
            return $this->errorResponse("La categoría con id $categoryId no existe ", 404);

        }
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('La categoría  no es una categoría de este producto', 404);
        }

        $product->categories()->detach($category->id);//se elimina asi por que la relacion es manytomany

        return $this->showElement($product->categories()->orderBy('id', 'asc')->get());
    }
}
