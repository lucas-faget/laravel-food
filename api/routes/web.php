<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\FoodDataCentralApiController;
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

Route::prefix('/api/products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::put('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);
});

Route::prefix('/fdc')->group(function () {
    $controller = FoodDataCentralApiController::class;

    Route::get('/foods/search/{searchQuery}/{pageNumber?}', [$controller, 'foodSearch']);
    Route::get('/food/{id}', [$controller, 'food']);
});
