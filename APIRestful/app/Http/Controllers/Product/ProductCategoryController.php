<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $productId, $categoryId)
    {
        $product = Product::findOrFail($productId);
        $category = Category::findOrFail($categoryId);

        $product->categories()->syncWithoutDetaching([$category->id]);//agrega la categoria a la lista de categorias del productos,
        //en caso de que ya exista la categoria no hace nada

        return $this->showElement($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     */
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
