<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
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
Route::resource('recipes.comments', CommentController::class)->only(['index']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('forgot-password', [UserController::class, 'forgotPassword']);
Route::post('reset-password', [UserController::class, 'resetPassword'])->name('password.reset');
Route::get('categories', [CategoryController::class, 'index']);

// Protected routes
Route::group(['middleware' => 'auth:sanctum'], function()
{
    Route::resource('recipes.comments', CommentController::class)->only(['store', 'update', 'destroy']);
    Route::resource('recipes.ratings', RatingsController::class)->only(['store', 'update', 'destroy']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::resource('users', UserController::class, )->only(['update']);
    Route::resource('recipes', RecipeController::class)->only(['store', 'update', 'destroy']);
});
