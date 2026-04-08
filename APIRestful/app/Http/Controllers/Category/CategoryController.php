<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function index()
    {
        $categories = Category::all();
        return $this->showElement($categories);
    }


    public function store(Request $request)
    {
        $datosValidados = $request->validate(
            [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            ]);

        $category = Category::create($datosValidados);

        return $this->showElement($category, 201);
    }


    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return  $this->showElement($category);
    }


    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        //se obtienen intneta insertar el nombre y la descipcion
        $category->fill($request->only([
            'name',
            'description',
        ]));

        if ($category->isClean())
        {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }

        $category->save();

        return $this->showElement($category);
    }


    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return $this->showElement($category);
    }
}
