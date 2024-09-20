<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\OpenFoodFactsController;
use App\Http\Controllers\FoodDataCentralController;
use App\Http\Controllers\IntakeController;
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

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::prefix('/products')->group(function () {
        $controller = ProductController::class;
        Route::get('/', [$controller, 'index']);
        Route::get('/{product}', [$controller, 'show']);
        Route::post('/', [$controller, 'store']);
        Route::put('/{product}', [$controller, 'update']);
        Route::delete('/{product}', [$controller, 'destroy']);
    });

    Route::prefix('/intakes')->group(function () {
        $controller = IntakeController::class;
        Route::get('/', [$controller, 'index']);
        Route::get('/{intake}', [$controller, 'show']);
        Route::post('/', [$controller, 'store']);
        Route::put('/{intake}', [$controller, 'update']);
        Route::delete('/{intake}', [$controller, 'destroy']);
    });
});
