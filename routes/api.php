<?php

use App\Http\Controllers\V1\InvestController;
use App\Http\Controllers\V1\InvestorController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Http\Request;
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
    Route::apiResource('user', UserController::class);

    Route::group(['prefix' => 'investor'], function () {
        Route::get('{id}/invests', [InvestorController::class, 'getInvests'])->name('investor.invests');
        Route::post('{id}/reactivate', [InvestorController::class, 'reactivateInvestor'])->name('investor.reactivate');
        Route::post('{id}/movement', [InvestorController::class, 'addMovement'])->name('investor.addMovement');
        Route::put('{investor}/movement/{movement}', [InvestorController::class, 'updateMovement'])->name('investor.updateMovement');
    });
    
    Route::apiResource('investor', InvestorController::class);
    Route::apiResource('invest', InvestController::class);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
