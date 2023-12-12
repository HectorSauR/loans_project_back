<?php

use App\Http\Controllers\V1\DebtorController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\InvestController;
use App\Http\Controllers\V1\InvestorController;
use App\Http\Controllers\V1\LoanController;
use App\Http\Controllers\V1\PaymentController;
use App\Http\Controllers\V1\UserController;
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

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\V1'], function () {
    Route::post("login", [AuthController::class, "login"]);
    Route::post("signIn", [AuthController::class, "signIn"]);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post("logout", [AuthController::class, "logout"]);
        Route::apiResource('user', UserController::class);

        Route::group(['prefix' => 'investor'], function () {
            Route::get('{id}/invests', [InvestorController::class, 'getInvests'])->name('investor.invests');
            Route::post('{id}/reactivate', [InvestorController::class, 'reactivateInvestor'])->name('investor.reactivate');
            Route::post('{id}/movement', [InvestorController::class, 'addMovement'])->name('investor.addMovement');
            Route::put('{investor}/movement/{movement}', [InvestorController::class, 'updateMovement'])->name('investor.updateMovement');
        });

        Route::apiResource('investor', InvestorController::class);
        Route::apiResource('invest', InvestController::class);

        Route::apiResource('debtor', DebtorController::class);
        Route::get('debtor/{id}/loans', [DebtorController::class, 'getLoans'])->name('debtor.getLoans');
        Route::post('debtor/{id}/addLoan', [DebtorController::class, 'addLoan'])->name('debtor.addLoan');
        Route::apiResource('loan', LoanController::class);

        Route::apiResource('payment', PaymentController::class);
    });
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
