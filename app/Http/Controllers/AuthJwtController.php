<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class AuthJwtController extends Controller
{

    public function register(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'error_message' => $validate->errors(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Génération du token
        $token = Auth::guard('api')->login($user);

        return response()->json([
            'status' => true,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'error_message' => $validate->errors(),
            ], 400);
        }

        $credentials = $request->only('email', 'password');
        $token = Auth::guard('api')->attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
    }

    //if you want use this methods for yourself, add role in your user model and you validate in this methods

    public function refresh(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'authorisation' => [
                'token' => Auth::refresh(true),
                'type' => 'bearer',
            ],
        ]);
    }

    public function blackList(): JsonResponse
    {
        //if you want add to blacklist forever, pass true as parameter
        Auth::invalidate();

        return response()->json([
            'status' => true,
            'message' => 'token added to blacklist successfully'
        ], 200);
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'status' => true,
            'message' => 'logout successfully'
        ], 200);
    }

    public function getTokenByUser(Request $request): JsonResponse
    {
        $validate = Validator::make(['user_id' => $request->user_id], [
            'user_id' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'error_message' => $validate->errors(),
            ], 400);
        }

        if (!Auth::tokenById($request->user_id)) {
            return response()->json([
                'status' => false,
                'error_message' => "There aren't Token with this user id",
            ], 400);
        }

        return response()->json([
            'status' => true,
            'token' => Auth::tokenById($request->user_id)
        ]);
    }

}
