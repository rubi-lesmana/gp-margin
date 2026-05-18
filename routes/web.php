<?php

use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\BaseMarginController;
use App\Http\Controllers\CalculatorControler;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CostPriceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoiPercentageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MarketPriceController;
use App\Http\Controllers\MarketPriceDetailController;
use App\Http\Controllers\ParetoController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\SalesProposalController;
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
    Route::resource('/customers', CustomerController::class);
    Route::resource('/base-margin', BaseMarginController::class);
    Route::resource('/target-gp-margin', TgpMarginController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/market-price', MarketPriceController::class);
    Route::resource('/market-price-detail', MarketPriceDetailController::class);
    Route::resource('/arrival-inventory', ArrivalController::class);
    Route::resource('/cost-price', CostPriceController::class);
    Route::get('/calculator/calculate', [CalculatorControler::class, 'calculate'])->name('calculator.calculate');
    Route::resource('/doi-percentage', DoiPercentageController::class);
    Route::resource('/calculator', CalculatorControler::class);
    Route::resource('/term-of-payment', TermOfPaymentController::class);
    Route::prefix('selling-price')->name('selling-price.')->group(function () {
        Route::get('/',
        [SellingPriceController::class, 'index'])->name('index');
        // Draft show — tanpa sellingPriceId
        Route::get('/{itemId}/{costPriceId}',
            [SellingPriceController::class, 'show'])->name('show');
        // Approved show — dengan sellingPriceId
        Route::get('/{itemId}/{costPriceId}/{sellingPriceId}',
            [SellingPriceController::class, 'show'])->name('show.approved');
        Route::post('/{itemId}/{costPriceId}/approve',
            [SellingPriceController::class, 'approve'])->name('approve');
    });
    // Price List
    Route::resource('/price-list', PriceListController::class);
    // routes/web.php

    Route::prefix('proposal')->name('proposal.')->group(function () {
        Route::get('/',
            [SalesProposalController::class, 'index'])->name('index');
        Route::get('/create',                   
            [SalesProposalController::class, 'create'])->name('create');
        Route::post('/', 
            [SalesProposalController::class, 'store'])->name('store');
        Route::get('/{proposalId}', 
            [SalesProposalController::class, 'show'])
            ->name('show')
            ->where('proposalId', '[A-Za-z0-9\-\.]+');
        Route::post('/{proposalId}/approve', 
            [SalesProposalController::class, 'approve'])
            ->name('approve')
            ->where('proposalId', '[A-Za-z0-9\-\.]+');
        Route::post('/{proposalId}/reject',     
            [SalesProposalController::class, 'reject'])
            ->name('reject')
            ->where('proposalId', '[A-Za-z0-9\-\.]+');

        // AJAX endpoint
        Route::get('/ssp-info/{itemId}',        [SalesProposalController::class, 'getSspInfo'])->name('ssp-info');
    });
});