<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;


//esta clase sirve para manejar las  excepciones que ocurran durante la ejecucion del programa
class ApiExceptionHandler
{
    use ApiResponser;

    public function handle(Throwable $e, $request)
    {

            // si ocurre un error va a unaunthenticated
            if ($e instanceof AuthenticationException)
            {
                return $this->unauthenticated($request, $e);
            }

            // 2. Manejo de errores de validación
            if ($e instanceof ValidationException) {
                return $this->convertValidationExceptionToResponse($e, $request);
            }

            //normamente este no se ejecuta por que se laravel 13 lo termina convirtiendo en notFoundException
            if ($e instanceof ModelNotFoundException) {
                return $this->errorResponse('No existe ninguna instancia con el id especificado', 404);
            }

            if ($e instanceof NotFoundHttpException) {
                return $this->errorResponse('No existe el recurso solicitado', 404);
            }
            if ($e instanceof AuthorizationException) {
                return $this->errorResponse('No posee permisos para ejecutar esta acción', 403);
            }
            //cuando se accede a un metodo de forma incorrecta
            if ($e instanceof MethodNotAllowedHttpException) {
                return $this->errorResponse('El método http  especificado en la petición no es válido', 405);
            }
            //manejo general de las excepcion http
            //cualquier cosa que sea una httpexception
            if ($e instanceof HttpException) {
                return $this->errorResponse($e->getMessage(), $e->getStatusCode());
            }


            //este creo que no va a ocurrir nunca por que la eliminacionde la base de datos esta configurada en cascade
            //debe de ser para excepciones de la base ce datos
            if ($e instanceof QueryException) {
                // Obtenemos el código de error específico de la base de datos
                $codigo = $e->errorInfo[1];

                if ($codigo == 1451) {
                    return $this->errorResponse('No se puede eliminar de forma permanente el recurso porque está relacionado con algún otro.', 409);
                }
            }

            //si esta en modo de desarrollo se mostraran los detalles
            if (config('app.debug')) {
                return $this->errorResponse($e->getMessage(), 500);
            }


        return $this->errorResponse('Falla inesperada. Intente luego', 500);

    }


  //este metodo se ejecuta cuando el usuario no esta autenticado
    //esto se supone que se le debe de añadir mas funcionalidad
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('No autenticado.', 401);
    }

    //este creo que es el que le da los formatos a los errores
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }
}
