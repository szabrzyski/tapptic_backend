<?php

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

// Like the user
Route::post('/user/{userToLike}/like', [UserController::class, 'likeUser'])->name('likeUser');

// Dislike the user
Route::post('/user/{userToDislike}/dislike', [UserController::class, 'dislikeUser'])->name('dislikeUser');
