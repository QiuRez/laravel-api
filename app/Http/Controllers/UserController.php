<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
    public function getUserId(User $user) {
        return new UserResource($user);


    }

    public function getUserAll() {
        return new UserCollection(Cache::remember('users', 60*60*24, function() {  // Кэш тут не нужен. Проверка работоспособности
            return User::all();
        }));
    }

}
