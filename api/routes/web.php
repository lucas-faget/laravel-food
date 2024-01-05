<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OpenFoodFactsApiController;
use App\Http\Controllers\SpoonacularApiController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::put('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);
});

Route::prefix('/spoonacular')->group(function () {
    $controller = SpoonacularApiController::class;

    Route::get('/ingredients/search/{searchQuery}/{pageNumber?}', [$controller, 'ingredientSearch']);
    Route::get('/ingredients/{id}', [$controller, 'ingredient']);
    Route::get('/products/search/{searchQuery}/{pageNumber?}', [$controller, 'productSearch']);
    Route::get('/products/{id}', [$controller, 'product']);
});
