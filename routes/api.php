<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ItemController;
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
	Route::get('/{product}', [ProductController::class, 'show']);

	// Protected Products
	Route::middleware(['auth:sanctum'])->group(function () {
		Route::post('/', [ProductController::class, 'store']);
		Route::put('/{product}', [ProductController::class, 'update']);
		Route::delete('/{product}', [ProductController::class, 'destroy']);
	});
});
Route::prefix('/v1/products')->group(function () {
	// Public Products 
	Route::get('/', [ProductController::class, 'index']);
	Route::get('/search', [ProductController::class, 'findByName']);
	Route::get('/{product}', [ProductController::class, 'show']);

	// Protected Products
	Route::middleware(['auth:sanctum'])->group(function () {
		Route::post('/', [ProductController::class, 'store']);
		Route::put('/{product}', [ProductController::class, 'update']);
		Route::delete('/{product}', [ProductController::class, 'destroy']);
	});
});
Route::prefix('/v1/categories')->group(function () {
	// Public Categories 
	Route::get('/', [CategoryController::class, 'index']);
	// Route::get('/{category}', [CategoryController::class, 'show']);

	// Protected Categories
	Route::middleware(['auth:sanctum'])->group(function () {
		Route::post('/', [CategoryController::class, 'store']);
		Route::put('/{category}', [CategoryController::class, 'update']);
		Route::delete('/{category}', [CategoryController::class, 'destroy']);
	});
});
Route::prefix('/v1/tags')->group(function () {
	// Public Products 
	Route::get('/', [TagController::class, 'index']);

	// Protected Products
	Route::middleware(['auth:sanctum'])->group(function () {
		Route::post('/', [TagController::class, 'store']);
		Route::put('/{id}', [TagController::class, 'update']);
		Route::delete('/{id}', [TagController::class, 'destroy']);
	});
});

// Users Route
Route::post('/v1/register', [UserController::class, "register"]);
Route::post('/v1/signin', [UserController::class, "login"]);
Route::middleware('auth:sanctum')->group(function(){
	Route::get('/v1/signout', [UserController::class, "logout"]);
	Route::post('/v1/change_password', [UserController::class, "changePassword"]);

})
// Route::resource('/v1/products', ProductController::class);
// middleware('auth:sanctum')->

// Route::group(['prefix' => '/v2/products', 'middleware' => ['auth:sanctum']], function () {
// 	Route::get('/', [ProductController::class, 'index']);
// });
