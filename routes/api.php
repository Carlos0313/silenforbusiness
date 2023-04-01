<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/
Route::post('/login', [UserController::class,'login']);
Route::get('/users', [UserController::class,'getUsers']);
Route::post('/register', [UserController::class,'createUser']);
Route::delete('/user/delete/{user_id}', [UserController::class,'deleteUser']);


Route::group(['middleware' => 'auth:api'], function () {
    
    // Productos
    Route::post('/product/getAll', [ProductController::class,'getProducts']);
    Route::post('/product/create', [ProductController::class,'createProduct']);
    Route::post('/product/update/{product_id}', [ProductController::class,'updateProduct']);
    Route::delete('/product/delete/{product_id}', [ProductController::class,'deleteProduct']);

});