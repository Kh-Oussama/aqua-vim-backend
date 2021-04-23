<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReferencesController;
use App\Http\Controllers\SliderController;
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

Route::post("/login",[AuthController::class,'login']);
Route::post("register",[AuthController::class,'register']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::get("profile",[AuthController::class,'profile']);
    Route::post("logout",[AuthController::class,'logout']);
    Route::post("refresh",[AuthController::class,'refresh']);
});

Route::resource('/sliders',SliderController::class);
Route::resource('/references',ReferencesController::class);
Route::resource('/categories',ReferencesController::class);
