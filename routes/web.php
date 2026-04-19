<?php

use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\BaseMarginController;
use App\Http\Controllers\CalculatorControler;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MarketPriceController;
use App\Http\Controllers\TgpMarginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/items', ItemController::class);
    Route::resource('/base-margin', BaseMarginController::class);
    Route::resource('/target-gp-margin', TgpMarginController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/market-price', MarketPriceController::class);
    Route::resource('/arrival-inventory', ArrivalController::class);
    Route::get('/calculator/calculate', [CalculatorControler::class, 'calculate'])->name('calculator.calculate');
    Route::resource('/calculator', CalculatorControler::class);
});