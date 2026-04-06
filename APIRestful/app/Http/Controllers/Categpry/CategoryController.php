<?php

namespace App\Http\Controllers\Categpry;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{

    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
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
        $datosValidados = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $category = Category::create($datosValidados);

        return $this->showOne($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return  $this->showOne($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        //se obtienen intneta insertar el nombre y la descipcion
        $category->fill($request->only([
            'name',
            'description',
        ]));

        //se verifica si el objeto sigue igual sin cambios
        //si no hubg cambios para aqui
        if ($category->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }

        // 4. Persistimos los cambios en la base de datos
        $category->save();

        // 5. Retornamos la respuesta estandarizada
        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return $this->showOne($category);
    }
}
