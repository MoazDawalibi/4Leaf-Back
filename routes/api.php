<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ShippingFeeController;
use App\Http\Controllers\StaticInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Route::middleware(['abilities:admin'],'auth:sanctum')->group(function(){

Route::apiResource('user', AuthController::class);

Route::middleware('auth:sanctum')->group(function(){

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class,'index']);
        Route::get('/{id}', [CategoryController::class,'show']);
        Route::post('/', [CategoryController::class,'store']);
        Route::put('/{id}', [CategoryController::class,'update']);
        Route::delete('/{id}', [CategoryController::class,'destroy']);
    });

    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class,'index']);
        Route::get('/{id}', [CustomerController::class,'show']);
        Route::post('/', [CustomerController::class,'store']);
        Route::put('/{id}', [CustomerController::class,'update']);
        Route::delete('/{id}', [CustomerController::class,'destroy']);
    });

    Route::prefix('shipment')->group(function () {
        Route::get('/', [ShipmentController::class,'index']);
        Route::get('/{id}', [ShipmentController::class,'show']);
        Route::post('/', [ShipmentController::class,'store']);
        Route::put('/{id}', [ShipmentController::class,'update']);
        Route::delete('/{id}', [ShipmentController::class,'destroy']);
    });

    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class,'index']);
        Route::get('/{id}', [OrderController::class,'show']);
        Route::post('/', [OrderController::class,'store']);
        Route::put('/{id}', [OrderController::class,'update']);
        Route::delete('/{id}', [OrderController::class,'destroy']);
    });

    Route::prefix('shipping_fee')->group(function () {
        Route::get('/', [ShippingFeeController::class,'index']);
        Route::get('/{id}', [ShippingFeeController::class,'show']);
        Route::post('/', [ShippingFeeController::class,'store']);
        Route::put('/{id}', [ShippingFeeController::class,'update']);
        Route::delete('/{id}', [ShippingFeeController::class,'destroy']);
    });

    Route::prefix('static_info')->group(function () {
        Route::get('/', [StaticInfoController::class,'index']);
        Route::get('/{id}', [StaticInfoController::class,'show']);
        Route::post('/', [StaticInfoController::class,'store']);
        Route::put('/{id}', [StaticInfoController::class,'update']);
        Route::delete('/{id}', [StaticInfoController::class,'destroy']);
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class,'index']);
        Route::get('/{id}', [ProductController::class,'show']);
        Route::post('/', [ProductController::class,'store']);
        Route::put('/{id}', [ProductController::class,'update']);
        Route::delete('/{id}', [ProductController::class,'destroy']);
    });
    
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('users/{id}', [AuthController::class, 'update']);
    Route::get('users', [AuthController::class, 'index']);

});
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
// });
