<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {

    Route::get('accounts/{account}/transactions', [\App\Http\Controllers\Bank\TransactionController::class, 'index']);

    Route::middleware('client')->group(function () {
        Route::get('accounts/{account}', [\App\Http\Controllers\Bank\AccountController::class, 'show'])->name('account.details');

        Route::post('accounts/{account}/transactions', [\App\Http\Controllers\Bank\TransactionController::class, 'store'])->name('bank.transfer');
    });
});
