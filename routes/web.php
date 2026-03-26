<?php

use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\BaseMarginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MarketPriceController;
use App\Http\Controllers\SuggestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/items', ItemController::class);
    Route::resource('/base-margin', BaseMarginController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/market-price', MarketPriceController::class);
    Route::resource('/arrival-inventory', ArrivalController::class);
    Route::resource('/suggested-gp', SuggestController::class);
});