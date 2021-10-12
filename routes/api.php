<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Public Routes
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);


//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    //* User
    Route::post('/logout',[AuthController::class, 'logout']);
    Route::put('/user',[UserController::class, 'update']);
    Route::get('/user',[UserController::class, 'user']);

    //* Post
    Route::get('/posts',[PostController::class, 'index']); //! All Post
    Route::post('/posts',[PostController::class, 'store']);//! Create Post
    Route::get('/posts/{id}',[PostController::class, 'show']);//!get Single post
    Route::put('/posts/{id}',[PostController::class, 'update']);//! update post
    Route::delete('/posts/{id}',[PostController::class, 'destroy']);//!delete post


    //* Comment
    Route::get('/posts/{id}/comments',[CommentController::class, 'index']);
    Route::post('/posts/{id}/comments',[CommentController::class, 'store']);
    Route::put('/comments/{id}',[CommentController::class, 'update']);
    Route::delete('/comments/{id}',[CommentController::class, 'destroy']);

    //*Like
    Route::post('/posts/{id}/likes',[LikeController::class, 'likeOrUnlike']);
    
    



});