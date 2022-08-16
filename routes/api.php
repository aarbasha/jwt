<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JWTAuthMiddleware;

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//composer require tymon/jwt-auth:dev-develop

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
//--------------------------------------------------------------------------------


Route::middleware([JWTAuthMiddleware::class])->group(function () {
    //All posts
    Route::get('posts', [PostController::class, 'getAllPost']);
    //Single post
    Route::get('post/{id}', [PostController::class, 'getSinglePost']);
    //Create Post
    Route::post('add-post', [PostController::class, 'store']);
    //update post
    Route::post('post/{id}', [PostController::class, 'update']);
    //delete post
    Route::post('post/{id}', [PostController::class, 'destroy']);
});

//--------------------------------------------------------------------------------
Route::get('users', [UserController::class, 'getAllUser']);
