<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('products',[ProductController::class,'index'])->name('index');
Route::post('product/store',[ProductController::class,'store'])->name('store');
Route::get('product/show/{id}',[ProductController::class,'show'])->name('show');
Route::post('product/update/{id}',[ProductController::class,'update'])->name('update');
Route::get('product/delete/{id}',[ProductController::class,'delete'])->name('delete');