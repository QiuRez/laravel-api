<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
    *  Получение пользователем своих данных
    * 
    * @return \Illuminate\Contracts\Auth\Authenticatable
    */
    public function getYourself() {
        return Auth::user();
    }

    

    /**
    *  Получение пользователем по ID
    * 
    * @param int $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function getUserId($id) {
        if ($user = User::find($id)) {
            return $user;
        }

        return response()->json([
            'status' => False,
            'message' => 'Пользователь не найден'
        ], 401);

    }

    public function getUserAll() {
        return new UserResource(User::all());
    }

}
