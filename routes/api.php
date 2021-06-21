<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("register",[App\Http\Controllers\Apis\AuthController::class,"register"]);
Route::post("login",[App\Http\Controllers\Apis\AuthController::class,"login"]);
Route::post("forget_password",[App\Http\Controllers\Apis\AuthController::class,"forgetPassword"]);

Route::group(["middleware" => ["auth:sanctum"]],function(){
    Route::post("logout",[App\Http\Controllers\Apis\AuthController::class,"logout"]);
    Route::post("change/password",[App\Http\Controllers\Apis\UserController::class,"changePassword"]);
    Route::get("get/profile",[App\Http\Controllers\Apis\UserController::class,"getProfile"]);
    Route::post("update/profile",[App\Http\Controllers\Apis\UserController::class,"updateProfile"]);
    Route::apiResource("addresses",\App\Http\Controllers\Apis\AddressController::class);

});
