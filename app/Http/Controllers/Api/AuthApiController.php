<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

// use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class AuthApiController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['authenticate']]);
    // }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('nip', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'nip' => 'required|string|min:4',
            'password' => 'required|string|min:6|max:50'
        ]);

        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard('api')->user();
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

        $user = Auth::guard('api')->user();
        return response()->json([ 'success' => true,'user' => $user]);
    }
    public function logout(Request $request)
    {
        Auth::guard('api')->logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    public function refreshtoken()
    {

        return response()->json([
            'user' => Auth::guard('api')->user(),
            'authorization' => [
                'token' => Auth::guard('api')->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
