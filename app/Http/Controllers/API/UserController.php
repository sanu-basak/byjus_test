<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;
use App\Rules\EmailValidation;
use Api;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * User Login Api
     */
    public function login(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),[
                'email'      => 'email|required',
                'password'   => 'required'
            ]);
    
            if($validator->fails()){
    
                return response()->json(Api::validationResponse($validator),422);
            }
    
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')]))
            {
                $user = Auth::user();
    
                if($user->status == 0)
                   return response()->json(Api::apiErrorResponse(__('message.accountBlocked')),422);  
    
                $token = \JWTAuth::fromUser($user);
    
                return response()->json(Api::apiSuccessResponse(__('message.userLoggedIn'),new UserResource($user),$token),200);
    
            }else{
                return response()->json(Api::apiErrorResponse(__('message.credentialsNotMatch')),422);
            }

        } catch (\Exception $e) {
            return response()->json(Api::apiErrorResponse(__('message.somethingWentWrong')),500);
        }


    }

    /**
     * User Registeration Api
     */
    public function register(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),[
                'name'          => 'required|min:6|max:20',
                'email'         => ['email','required','unique:users,email',new EmailValidation],
                'password'      => 'required|min:8|max:15',
                'gender'        => 'required|in:1,2,3', // 1:Male, 2:Female, 3:Other
                'date_of_birth' => 'required|date_format:Y-m-d|before:today'
            ]);
    
            if($validator->fails()){
    
                return response()->json(Api::validationResponse($validator),422);
            }
    
            $user = $this->user->create([
                'name'    => $request->name,
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
                'gender_id'     => $request->gender,
                'status'        => 1,
                'date_of_birth' => !empty($request->date_of_birth) ? date('Y-m-d',strtotime($request->date_of_birth)) : null
    
            ]);
    
            $token = \JWTAuth::fromUser($user);
    
            return response()->json(Api::apiSuccessResponse(__('message.userRegistered'),new UserResource($user),$token),200);

        } catch (\Exception $e) {
            return response()->json(Api::apiErrorResponse(__('message.somethingWentWrong')),500);
        }

       

    }

    /**
     * User Profile Api
     */
    public function userProfile(Request $request)
    {
        try {
            $user = Auth::user();
            return response()->json(Api::apiSuccessResponse(__('message.userRecord'),new UserResource($user)),200);
        } catch (\Exception $e) {
            return response()->json(Api::apiErrorResponse(__('message.somethingWentWrong')),500);
        }
       
    }

}
