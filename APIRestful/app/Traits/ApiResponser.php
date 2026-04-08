<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    }


    protected function showAll(Collection $collection, $code = 200)
    {
        //if ($collection->isEmpty()) {
            // Envolvemos en 'data' para que siempre responda igual
        //    return $this->successResponse(['data' => $collection], $code);
        //}

        //$transformer = $collection->first()->transformer;
       // $collection = $this->transformData($collection, $transformer);

        return $this->successResponse($collection, $code);
    }


    protected function showOne(Model $instance, $code = 200)
    {
        //$transformer = $instance->transformer;

        //$instance = $this->transformData($instance, $transformer);

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
