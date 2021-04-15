<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;

use InvalidArgumentException;

trait ExceptionTrait {

    public function apiException($request , $e)
    {
        if($e instanceof AuthenticationException ){
           
            return response()->json([
                'success'       => false,
                'error'         => true,
                'response_code' => '401',
                'message'       => 'Unauthorized',
            ], 401);

        }

        if ($e instanceof \League\OAuth2\Server\Exception\OAuthServerException && $e->getCode() == 9) {
            
            return response()->json([
                'success'       => false,
                'error'         => true,
                'response_code' => '500',
                'message'       => 'Internal Server Error',
            ], 500);

        }

        if ($e instanceof ModelNotFoundException) {

            return response()->json([
                'success'       => false,
                'error'         => true,
                'response_code' => '404',
                'message'       => 'Model Not Found Exception',
            ], 404);

        }

        if ($e instanceof NotFoundHttpException) {

            return response()->json([
                'success'       => false,
                'error'         => true,
                'response_code' => '404',
                'message'       => 'Not Found Http Exception',
            ], 404);
        }

        if ($e instanceof InvalidArgumentException) {

            return response()->json([
                'success'       => false,
                'error'         => true,
                'response_code' => '500',
                'message'       => 'Invalid Argument Exception',
            ], 500);
        }

        if ($e instanceof MethodNotAllowedHttpException) {

            return response()->json([
                'success'       => false,
                'error'         => true,
                'response_code' => '500',
                'message'       => 'Method Not Allowed Http Exception',
            ], 500);
        }

        // if ($e instanceof QueryException) {

        //     return response()->json([
        //         'success'       => false,
        //         'error'         => true,
        //         'response_code' => '500',
        //         'message'       => 'Query Exception',
        //     ], 500);
        // }

        return parent::render($request, $e);

    }

}