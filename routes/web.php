<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

use App\Http\Controllers\Guest\DashboardController as GuestDashboardController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// # Rotte pubbliche
Route::get('/', [GuestDashboardController::class, 'index'])
  ->name('home');

// # Rotte protette
Route::middleware('auth')
  ->prefix('/admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
      ->name('dashboard');

    Route::resource('posts', PostController::class);
    Route::delete('/posts/{post}/delete-img', [PostController::class, 'destroyImg'])->name('posts.destroy-img');
    Route::patch('/posts/{post}/update-publish', [PostController::class, 'updatePublish'])->name('posts.update-publish');

    Route::resource('categories', CategoryController::class);
  });

require __DIR__ . '/auth.php';
