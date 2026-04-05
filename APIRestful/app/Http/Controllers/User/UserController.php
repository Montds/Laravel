<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //para mostrar todos los User
    public function index()
    {
        $usuarios = User::all();
        return  response()->json(["data"=> $usuarios] , 200);
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
    //para mostrar un user
    public function show(string $id)
    {
        $usuario = User::find($id);
        if(is_null($usuario))
        {
            return response()->json(["message"=>"usuario no encontrado"],404);
        }
        return  response()->json(["data"=> $usuario] , 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
