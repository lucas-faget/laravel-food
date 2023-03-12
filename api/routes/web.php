<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

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
    Route::get('/{page?}', [ProductController::class, 'index']);
    Route::get('/code/{code}', [ProductController::class, 'show']);
    Route::get('/search/{search}/{page?}', [ProductController::class, 'search']);
});
