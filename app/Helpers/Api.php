<?php 

namespace App\Helpers;

class Api 
{ 
    public static function apiSuccessResponse($message,$data=[],$token = NULL)
    {
        if(!empty($token)){
            $success = [
                'success'       => true,
                'error'         => false,
                'response_code' => 200,
                'message'       => $message,
                'token'         => $token,
                'data'          => $data
            ]; 
        }else{
            $success = [
                'success'       => true,
                'error'         => false,
                'response_code' => 200,
                'message'       => $message,
                'data'          => $data
            ]; 
        }

        return $success;
    }

    public static function validationResponse($validator)
    {
        foreach($validator->errors()->toArray() as $v => $a){

            $validationError = [
                'success'       => false,
                'error'         => true,
                'response_code' => 422,
                'message'       => $a[0],
            ];
    
            return $validationError;
            
        }

    }

    public static function apiErrorResponse($message,$errorCode=422)
    {
        $error = [
            'success'       => false,
            'error'         => true,
            'response_code' => $errorCode,
            'message'       => $message,
        ];

        return $error;
    }

}