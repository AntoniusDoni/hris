<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['authenticate']]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|string|min:4',
            'password' => 'required|string|min:6|max:50'
        ]);

        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = auth('api')->user();

        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function get_user(Request $request)
    {
        $token=$request->headers->get('token');
        $user = Auth::guard('api')->user();
        $token = auth('api')->check();
        return response()->json([ 'success' => true,'user' => $user,'token'=>$token]);
    }
    public function logout(Request $request)
    {
        Auth::guard('api')->logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    public function refreshtoken(Request $request)
    {


        return response()->json([
            'user' => Auth::guard('api')->authenticate(),
            'authorization' => [
                'token' => Auth::guard('api')->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
