<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CityController;
use App\Http\Controllers\Api\v1\DictionaryController;
use App\Http\Controllers\Api\v1\ExecutorController;
use App\Http\Controllers\Api\v1\OfferController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\ReviewController;
use App\Http\Controllers\Api\v1\SupportController;
use App\Http\Controllers\Api\v1\ReportController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/email/verify', [UserController::class, 'verifyEmail']);
    Route::post('/email/resend', [UserController::class, 'resendVerify']);
    Route::post('/forgot-password', [AuthController::class, 'sendForgot']);
    Route::post('/reset-password', [AuthController::class, 'reset']);

    Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
        Route::post('/update', [UserController::class, 'update']);
        Route::post('/offers', [UserController::class, 'offersList']);
        Route::get('/{id}', [UserController::class, 'info']);
    });

    Route::group(['prefix' => 'offer'], function () {
        Route::get('', [OfferController::class, 'index']);
        Route::post('', [OfferController::class, 'create'])->middleware('auth:api');
        Route::post('/{id}', [OfferController::class, 'info']);
    });
});
