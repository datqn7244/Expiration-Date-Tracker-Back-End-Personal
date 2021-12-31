<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Users Route
Route::prefix('api/v1/')->group(function () {
	Route::post('register', [UserController::class, "register"]);
	Route::post('signin', [UserController::class, "login"]);
	Route::middleware('auth:sanctum')->group(function () {
		Route::get('signout', [UserController::class, "logout"]);
		Route::post('change_password', [UserController::class, "changePassword"]);
	});
});