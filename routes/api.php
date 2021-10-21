<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
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

// Public routes
Route::resource('recipes', RecipeController::class)->only(['index', 'show']);
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

// Protected routes
Route::group(['middleware' => 'auth:sanctum'], function()
{
    Route::post('logout', [UserController::class, 'logout']);
    Route::resource('recipes', RecipeController::class)->only(['store', 'update', 'destroy']);
});
