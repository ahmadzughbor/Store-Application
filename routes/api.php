<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\billsController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\salesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//////// auth routes /////////
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});


/////products routes ////////
Route::group([
    'middleware' => 'api',
], function () {
    Route::post('product/add',[productsController::class,'add']);
    Route::get('product/allProduct',[productsController::class,'allProduct']);
    Route::post('productsbill/show',[billsController::class,'show']);
    Route::post('sale/pro',[salesController::class,'sale']);
    Route::post('return/pro',[salesController::class,'returns']);
    Route::get('all/sales',[salesController::class,'allSales']);
    Route::get('all/returns',[salesController::class,'allReturns']);
});
