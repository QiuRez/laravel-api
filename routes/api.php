<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/', function() {
    return \App\Models\Post::all();
});

// Если пользователь НЕ авторизован
Route::group(['middleware' => ['guest:sanctum']], function() {
    Route::post('/login', [AuthController::class, 'login']); 
    Route::post('/register', [AuthController::class, 'register']);
    
});

// Если пользователь авторизован
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/post/all', [PostController::class, 'getAll']);
    Route::get('/user/yourself', [UserController::class, 'getYourself']);
    Route::get('/user/id/{user}', [UserController::class, 'getUserId']);
    Route::get('/user/all', [UserController::class, 'getUserAll']);
});
