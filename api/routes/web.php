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

Route::get('/api/products/{page?}', [ProductController::class, 'index']);
Route::get('/api/products/code/{code}', [ProductController::class, 'show']);
Route::get('/api/products/search/{search}/{page?}', [ProductController::class, 'search']);
