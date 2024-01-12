<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\FoodDataCentralController;
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
    $controller = ProductController::class;

    Route::get('/', [$controller, 'index']);
    Route::get('/page/{user}/{pageNumber?}', [$controller, 'page']);
    Route::post('/', [$controller, 'store']);
    Route::get('/{product}', [$controller, 'show']);
    Route::put('/{product}', [$controller, 'update']);
    Route::delete('/{product}', [$controller, 'destroy']);
});

Route::prefix('/fdc')->group(function () {
    $controller = FoodDataCentralController::class;

    Route::get('/foods/search/{searchQuery}/{pageNumber?}', [$controller, 'foodSearch']);
    Route::get('/food/{id}', [$controller, 'food']);
});
