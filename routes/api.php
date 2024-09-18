<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\OpenFoodFactsController;
use App\Http\Controllers\FoodDataCentralController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/off')->group(function () {
    $controller = OpenFoodFactsController::class;

    Route::get('/food/search/{query}/{page}', [$controller, 'search']);
    Route::get('/food/{id}', [$controller, 'show']);
});

Route::prefix('/fdc')->group(function () {
    $controller = FoodDataCentralController::class;

    Route::get('/food/search/{query}/{page}', [$controller, 'search']);
    Route::get('/food/{id}', [$controller, 'show']);
});

Route::prefix('/products')->group(function () {
    $controller = ProductController::class;

    Route::get('/', [$controller, 'index']);
    Route::get('/{product}', [$controller, 'show']);
    Route::post('/', [$controller, 'store']);
    Route::put('/{product}', [$controller, 'update']);
    Route::delete('/{product}', [$controller, 'destroy']);
});
