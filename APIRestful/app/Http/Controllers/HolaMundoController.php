<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HolaMundoController extends Controller
{
    /**
     * Este es tu primer Endpoint.
     * En Spring Boot sería un @GetMapping.
     */

    public function saludar()
    {
        // Creamos un array asociativo (como un Map en Java)
        $data =
            [
                'mensaje' => '¡Hola pepe desde laravel!'
            ];

        // response()->json() convierte el array a JSON automáticamente
        return response()->json($data);
    }
}

