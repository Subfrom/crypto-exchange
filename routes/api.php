<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'createOrder']);

    Route::post('/transactions/{transaction}/confirm', [TransactionController::class, 'confirmTransaction']);
    Route::post('/transactions/{transaction}/external', [TransactionController::class, 'recordExternalTransaction']);
});