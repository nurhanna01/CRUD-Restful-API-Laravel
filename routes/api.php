<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/users', [UserController::class, 'users']);
Route::get('/user/profile', [UserController::class, 'profile'])->middleware('auth:api');
Route::post('/post ',[PostController::class,'store'])->middleware('auth:api');
Route::put('/post/{post}',[PostController::class,'update'])->middleware('auth:api');
Route::delete('/post/{post}',[PostController::class,'delete'])->middleware('auth:api');
