<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    //para mostrar todos los User
    public function index()
    {
        $usuarios = User::all();
        return $this->showAll($usuarios);
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
        //validacion de campos del usuario
        $datosValidados = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users', // Agregué unique por seguridad
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            // se obtienen los datos ya validados
            $campos = $datosValidados;

            //se encripta la psssword
            $campos['password'] = bcrypt($campos['password']);

            $campos['verified'] = User::USUARIO_NO_VERIFICADO;
            $campos['verification_token'] = User::generarVerificationToken();
            $campos['admin'] = User::USUARIO_REGULAR;

            $usuario = User::create($campos);

            return $this->showOne($usuario , 201);

        } catch (\Exception $e)
        {
            return $this->errorResponse($e->getMessage(), 200);
        }
    }

    public function show(string $id)
    {

            $usuario = User::findOrFail($id);
            return $this->showOne($usuario);
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
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);


        //por el momento es mejor no enviar el campo admin
        $datosValidados = $request->validate([
            'name'     => 'string|max:255',
            'email'    => 'email',
            'password' => 'min:6|confirmed',
            'admin'    => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
        ]);


        try
        {
            if (isset($datosValidados['name'])) {
                $user->name = $datosValidados['name'];
            }

            // asigna el email en caso que sea diferente
            if (isset($datosValidados['email']) && $user->email != $datosValidados['email']) {
                $user->verified = User::USUARIO_NO_VERIFICADO;
                $user->verification_token = User::generarVerificationToken();
                $user->email = $datosValidados['email'];
            }


            //se asigna la nueva passwword
            if (isset($datosValidados['password'])) {
                $user->password = bcrypt($datosValidados['password']);
            }


            if (isset($datosValidados['admin'])) {
                if (!$user->esVerificado())
                {
                    return $this->errorResponse('Únicamente los usuarios verificados pueden cambiar su valor de administrador', 409);
                }

                $user->admin = $datosValidados['admin'];
            }

            //valida si el usuario ha tenido un cambio
            //es decir si no cambio ningun campo se detiene aqui
            if (!$user->isDirty()) {
                return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422   );
            }

            //se actualiza el usuario
            $user->save();

            return $this->showOne($user);

        }
        catch (\Exception $e)
        {
            return $this->errorResponse("error $e" , 200);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try
        {
            $user = User::findOrFail($id);
            $user->delete();
            return $this->showOne($user);
        }
        catch (\Exception $e)
        {
            return $this->errorResponse("error",200);
        }

    }

}
