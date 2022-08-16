<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


//All posts
Route::get('posts', [PostController::class, 'getAllPost']);
//Single post
Route::get('post/{id}', [PostController::class, 'getSinglePost']);
//Create Post
Route::post('add-post', [PostController::class, 'store']);
//Edit post === Single post
// Route::get('post/{id}', [PostController::class, 'edit']);
//update post
Route::post('post/{id}', [PostController::class, 'update']);
//delete post
Route::post('post/{id}', [PostController::class, 'destroy']);

//--------------------------------------------------------------------------------
Route::get('users', [UserController::class, 'getAllUser']);
