<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductsSubcategoryController;
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
Route::resource('/categories',ProductCategoryController::class);
Route::resource('/subcategories',ProductsSubcategoryController::class);
Route::resource('/products',ProductsController::class);
Route::resource('/clients',ClientsController::class);
Route::resource('/messages',MessageController::class);
Route::resource('/events',EventController::class);
Route::resource('/marks',MarkController::class);
