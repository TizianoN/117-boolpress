<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;

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

// posts resource
Route::get('posts/advanced-filters', [PostController::class, 'advancedFilters']);
Route::apiResource('posts', PostController::class)->only(['index', 'show']);
Route::get('posts-by-category/{category_id}', [PostController::class, 'postsByCategory']);


// categories resource
Route::apiResource('categories', CategoryController::class)->only(['index']);

// tags resource
Route::apiResource('tags', TagController::class)->only(['index']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});
