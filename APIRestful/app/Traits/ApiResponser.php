<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
//lista de metodos a reutilizar
trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showElement($data, $code = 200)
    {
        if ($data instanceof Collection)
        {
            return $this->showAll($data, $code);
        }
        else
        {
            return $this->showOne($data, $code);
        }

       // return $this->successResponse(['data' => $data], $code);
    }


    protected function showAll(Collection $collection, $code = 200)
    {
        //en este metodo puedo aplicar transformaciones sobre la collecion

        if ($collection->isEmpty())
        {
            return $this->successResponse(['data' => $collection], $code);
        }

        //en esta parte se le pueden agregar transformaciones a los datos como ordenarlos


        //

        $transformer = $collection->first()->transformer;

        $collection = $this->transformData($collection, $transformer);

        //asignando la collecion en cache sirve para que sea mas rapido aunque quizas lo quite

        //$collection = $this->cacheResponse($collection);


        return $this->successResponse($collection, $code);
    }

    /**
     * Transforma y retorna un solo modelo (Método del maestro)
     */
    protected function showOne(Model $instance, $code = 200)
    {
        // Extrae el transformador directamente de la instancia
        $transformer = $instance->transformer;

        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $code);
    }

    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();

        return Cache::remember($url, 30, function() use ($data) {
            return $data;
        });
    }

}
