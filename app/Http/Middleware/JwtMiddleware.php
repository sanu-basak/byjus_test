<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'success'       => false,
                    'error'         => true,
                    'response_code' => '401',
                    'message'       => 'Invalid Token',
                ], 401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([
                    'success'       => false,
                    'error'         => true,
                    'response_code' => '401',
                    'message'       => 'Token Expired',
                ], 401);
            }else{
                return response()->json([
                    'success'       => false,
                    'error'         => true,
                    'response_code' => '401',
                    'message'       => 'Authorization Token not found',
                ], 422);
            }
        }
        return $next($request);
    }
}
