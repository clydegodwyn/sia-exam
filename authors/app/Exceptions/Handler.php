<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\ClientException;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    use ApiResponser;
    
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) 
        {
            $model = strtolower(class_basename($exception->getModel()));
            if ($model === 'authors') {
                return $this->errorResponse("Does not exist any instance of authors with the given id", Response::HTTP_NOT_FOUND);
            }

            return $this->errorResponse("Does not exist any instance of {$model} with the given id", Response::HTTP_NOT_FOUND);
        }

    

        // validation exception
        if ($exception instanceof ValidationException) 
        {
            $errors = $exception->validator->errors()->getMessages();

            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // access to forbidden
        if ($exception instanceof AuthorizationException) 
        {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }

        // unauthorized access
        if ($exception instanceof AuthenticationException) 
        {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
        }
        if ($exception instanceof ClientException) {
            $message = $exception->getResponse()->getBody();
            $code = $exception->getCode();

            return $this->errorMessage($message,200);
        }

        // if your are running in development environment
        if (env('APP_DEBUG', false))  
        {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected error. Try later', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}