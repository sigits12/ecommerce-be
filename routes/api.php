<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

Route::group([
    'middleware' => 'api',
], function ($router) {

    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    });

    Route::group([
            'prefix' => 'products',
        ],
        function () {
            Route::get('', [ProductController::class, 'index'])->name('products.index');
            Route::post('', [ProductController::class, 'create'])->middleware('permission:create products')->name('products.create');
        }
    );
});
