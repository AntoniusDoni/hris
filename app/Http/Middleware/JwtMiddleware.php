<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try {
            // if (
                JWTAuth::parseToken()->authenticate();
                // ) {
                // return response()->json(['user_not_found'], 404);
            // }
        } catch (Exception $e) {
            if ($e instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'message' => "Token is Invalid",
                ], 401);
            } else if ($e instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException) {
                // return response()->json(['message' => 'Token is Expired'],401);
                try
                {
                  $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                //   dd($refreshed);
                //   $user = JWTAuth::setToken($refreshed)->toUser();
                  $request->headers->set('Authorization','Bearer '.$refreshed);
                }catch (JWTException $e){
                    return response()->json([
                        'code'   => 103,
                        'message' => 'Token cannot be refreshed, please Login again'
                    ],401);
                }
            } else {
                return response()->json(['message' => 'Authorization Token not found'],401);
            }
        }
        return $next($request);
    }
}
