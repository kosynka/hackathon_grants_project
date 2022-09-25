<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\GlazingController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ExecutorController;
use App\Http\Controllers\Admin\LockController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProfileTypeController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CitiesController;
use App\Http\Controllers\Admin\UrgenciesController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\RateController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'login']);
    Route::post('signin', [AuthController::class, 'signin']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('edit', [AuthController::class, 'edit']);
    Route::post('update', [AuthController::class, 'update']);
    Route::post('store', [AuthController::class, 'store']);

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/', [OfferController::class, 'index']);
        Route::get('/old_offer', [OfferController::class, 'oldIndex']);
        
        Route::group(['prefix' => 'user'], function () {
            Route::get('', [UserController::class, 'index']);
            Route::get('/delete/{id}', [UserController::class, 'delete']);
            Route::get('/{id}', [UserController::class, 'details'])->name('user.details');
            Route::post('/{id}/update', [UserController::class, 'update']);
        });

        Route::group(['prefix' => 'rate'], function () {
            Route::post('store/{id}', [RateController::class, 'store'])->name('store-rate');
        });

        Route::post('/update/{id}', [OfferController::class, 'updateOrder']);
        Route::get('/download', [OfferController::class, 'download'])->name('download');
        Route::get('/accept/offer/{id}', [OfferController::class, 'acceptOffer']);
        Route::get('/decline/offer/{id}', [OfferController::class, 'declineOffer']);
        Route::get('/accept/report/{id}', [OfferController::class, 'acceptReport']);
        Route::get('/decline/report/{id}', [OfferController::class, 'declineReport']);
        Route::get('/delete/{id}', [OfferController::class, 'delete']);
        Route::get('/{id}', [OfferController::class, 'details'])->name('details');
    });
});