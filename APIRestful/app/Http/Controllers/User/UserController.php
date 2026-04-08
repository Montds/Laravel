<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;

use Illuminate\Http\Request;
class UserController extends ApiController
{

    //para mostrar todos los User
    public function index()
    {
        $usuarios = User::all();
        return $this->showAll($usuarios);
    }


    public function store(Request $request, $id)
    {

        $seller = Seller::findOrFail($id);

        $datosValidados = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ]);

        $datosValidados['status'] = Product::PRODUCTO_NO_DISPONIBLE;
        $datosValidados['image'] = 'img1.jpg';
        $datosValidados['seller_id'] = $seller->id;

        $product = Product::create($datosValidados);

        return $this->showElement($product, 201);
    }

    public function show(string $id)
    {
            $usuario = User::findOrFail($id);
            return $this->showElement($usuario);
    }


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

            return $this->showElement($user);




    }


    public function destroy(string $id)
    {
        try
        {
            $user = User::findOrFail($id);
            $user->delete();
            return $this->showElement($user);
        }
        catch (\Exception $e)
        {
            return $this->errorResponse("error",200);
        }

    }

}
