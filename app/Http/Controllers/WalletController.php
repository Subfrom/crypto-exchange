<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function getBalance($currencyId)
    {
        
        $userId = Auth::id();

        $wallet = Wallet::where('user_id', $userId)
            ->where('currency_id', $currencyId)
            ->first();

        return response()->json(['balance' => $wallet->balance]);
    }

    public function getBalances(Request $request)
    {
        $userId = Auth::id();

        $wallets = Wallet::where('user_id', $userId)
            ->get();

        return response()->json(['wallets' => $wallets]);
    }
}
