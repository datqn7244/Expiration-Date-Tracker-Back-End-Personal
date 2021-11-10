<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

// Products route
Route::prefix('/v1/products')->group(function () {
	// Public Products 
	Route::get('/', [ProductController::class, 'index']);
	Route::get('/search', [ProductController::class, 'findByName']);
	Route::get('/{id}', [ProductController::class, 'show']);

	// Protected Products
	Route::middleware(['auth:sanctum'])->group(function () {
		Route::post('/', [ProductController::class, 'store']);
		Route::put('/{id}', [ProductController::class, 'update']);
		Route::delete('/{id}', [ProductController::class, 'destroy']);
	});
});

// Users Route
Route::post('/v1/register', [UserController::class, "register"]);
Route::post('/v1/signin', [UserController::class, "login"]);

Route::middleware('auth:sanctum')->get('/v1/signout', [UserController::class, "logout"]);
// Route::resource('/v1/products', ProductController::class);
// middleware('auth:sanctum')->

// Route::group(['prefix' => '/v2/products', 'middleware' => ['auth:sanctum']], function () {
// 	Route::get('/', [ProductController::class, 'index']);
// });
