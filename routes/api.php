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
	// Route::get('/', [ProductController::class, 'index']);
	// Route::get('/{product}', [ProductController::class, 'show']);

	// Protected Products
	Route::middleware(['auth:sanctum'])->group(function () {
		Route::get('/search', [ProductController::class, 'findByName']);
		Route::post('/', [ProductController::class, 'store']);
		Route::put('/{product}', [ProductController::class, 'update']);
		Route::delete('/{product}', [ProductController::class, 'destroy']);
		Route::apiResource('/', ProductController::class)->only(['index', 'show']);
	});
});
Route::prefix('/v1/items')->group(function () {
	// Public Items 

	// Protected Items
	Route::middleware(['auth:sanctum'])->group(function () {
		// Route::apiResource('/', ItemController::class)->only(['index', 'show']);
		Route::get('/', [ItemController::class, 'index']);
		Route::get('/{item}', [ItemController::class, 'show']);
		Route::post('/', [ItemController::class, 'store']);
		Route::put('/{item}', [ItemController::class, 'update']);
		Route::delete('/{item}', [ItemController::class, 'destroy']);
	});
});
Route::prefix('/v1/categories')->group(function () {
	// Public Categories 
	// Route::get('/{category}', [CategoryController::class, 'show']);

	// Protected Categories
	Route::middleware(['auth:sanctum'])->group(function () {
		Route::get('/', [CategoryController::class, 'index']);
		Route::post('/', [CategoryController::class, 'store']);
		Route::put('/{category}', [CategoryController::class, 'update']);
		Route::delete('/{category}', [CategoryController::class, 'destroy']);
	});
});
Route::prefix('/v1/tags')->group(function () {
	// Public Products 

	// Protected Products
	Route::middleware(['auth:sanctum'])->group(function () {
		Route::get('/', [TagController::class, 'index']);
		Route::post('/', [TagController::class, 'store']);
		Route::put('/{tag}', [TagController::class, 'update']);
		Route::delete('/{tag}', [TagController::class, 'destroy']);
	});
});
// Users Route
Route::prefix('/v1')->group(function () {
	Route::post('register', [UserController::class, "register"]);
	Route::post('signin', [UserController::class, "login"]);
	Route::middleware('auth:sanctum')->group(function () {
		Route::get('signout', [UserController::class, "logout"]);
		Route::post('change_password', [UserController::class, "changePassword"]);
	});
});