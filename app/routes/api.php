<?php

use App\Http\Controllers\Redemption\CouponController;
use App\Http\Controllers\Redemption\LuckyDrawController;
use App\Http\Controllers\Redemption\RedemptionController;
use App\Http\Controllers\UserAuthenticateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRegisterController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/lucky-drawing', [LuckyDrawController::class, 'drawing']);
    Route::post('/coupon/{coupon_uuid}/redeem', [RedemptionController::class, 'redeem']);
    Route::patch('/user/timezone', [UserController::class, 'updateTz']);
    Route::get('/coupon', [CouponController::class, 'list']);
});

Route::post('/auth', [UserAuthenticateController::class, 'login']);
Route::post('/register', [UserRegisterController::class, 'register']);
