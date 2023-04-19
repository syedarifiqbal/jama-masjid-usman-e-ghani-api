<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTypeController;
use Illuminate\Http\Request;
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


Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/profile', [AuthController::class, 'profile']);
    Route::put('/fcm-token-update', [AuthController::class, 'updateFcmToken']);
    Route::post('/forget-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

Route::group(['middleware' => 'auth:api'], function($router) {
    // Routes for transactions
    Route::put('transactions/{transaction}/approve', [TransactionController::class, 'approve']);
    Route::apiResource('transactions', TransactionController::class);
    
    // Routes for categories
    Route::apiResource('categories', CategoryController::class);

    // Routes for categories
    Route::apiResource('announcements', AnnouncementController::class);
    
    // Routes for transaction types
    Route::apiResource('transaction-types', TransactionTypeController::class);
    
    // Routes for settings
    // Route::apiResource('settings', SettingController::class);
});