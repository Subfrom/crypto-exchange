<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MoneyTransferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/wallets', [WalletController::class, 'getBalances']);
    Route::get('/wallet/{currency}', [WalletController::class, 'getBalance']);

    Route::post('/orders', [OrderController::class, 'createOrder']);

    Route::post('/transfers/internal', [MoneyTransferController::class, 'transferInternal']);
    
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Route::post('/transactions/{transaction}/confirm', [TransactionController::class, 'confirmTransaction']);
    // Route::post('/transactions/{transaction}/external', [TransactionController::class, 'recordExternalTransaction']);
    // Route::post('/transfers/external', [MoneyTransferController::class, 'transferExternal']);
});