<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     *  Регистрация пользователя.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {

        if (count($request->all()) == 0) {
            return response()->json([
                'status' => false,
                'message'=> 'Empty data',
            ], 401);
        }

        $validateUser = Validator::make($request->all(), [
            'name' => 'required',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required'
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message'=> 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
        

    }

    /**
    * Авторизация пользователя.
    * 
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request) {
        if (!Auth::attempt($request->only('email','password'))) {
            return response()->json([
                'message'=> "Unauthorized"
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()
        ->json([
            'message' => 'Hi '. $user->name,
            'access_token' => $token,
        ]);
    }

    
    /**
    * Выход пользователя.
    * Удаление отправленного token'а пользователя из базы данных
    * 
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => True,
            'Message' => 'DeAuth'
        ]);
    }
}
