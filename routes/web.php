<?php

use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\BaseMarginController;
use App\Http\Controllers\CalculatorControler;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoiPercentageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MarketPriceController;
use App\Http\Controllers\MarketPriceDetailController;
use App\Http\Controllers\ParetoController;
use App\Http\Controllers\SellingPriceController;
use App\Http\Controllers\TermOfPaymentController;
use App\Http\Controllers\TgpMarginController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/items', ItemController::class);
    Route::resource('/units', UnitController::class);
    Route::resource('/pareto', ParetoController::class);
    Route::resource('/base-margin', BaseMarginController::class);
    Route::resource('/target-gp-margin', TgpMarginController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/market-price', MarketPriceController::class);
    Route::resource('/market-price-detail', MarketPriceDetailController::class);
    Route::resource('/arrival-inventory', ArrivalController::class);
    Route::get('/calculator/calculate', [CalculatorControler::class, 'calculate'])->name('calculator.calculate');
    Route::resource('/doi-percentage', DoiPercentageController::class);
    Route::resource('/calculator', CalculatorControler::class);
    Route::resource('/term-of-payment', TermOfPaymentController::class);
    Route::resource('/selling-price', SellingPriceController::class);
});