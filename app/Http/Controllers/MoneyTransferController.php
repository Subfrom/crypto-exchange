<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoneyTransferController extends Controller
{
    public function transferInternal(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric|min:0.00000001',
        ]);

        $fromUserId = Auth::id();
        $toUserId = $request->to_user_id;
        $currencyId = $request->currency_id;
        $amount = $request->amount;

        // ตรวจสอบยอดคงเหลือ
        $fromWallet = Wallet::where('user_id', $fromUserId)
            ->where('currency_id', $currencyId)
            ->first();

        if ($fromWallet->balance < $amount) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        $transaction = new Transaction();
        $transaction->from_user_id = $fromUserId;
        $transaction->to_user_id = $toUserId;
        $transaction->currency_id = $currencyId;
        $transaction->amount = $amount;
        $transaction->transaction_type = 'internal';
        $transaction->save();

        // อัพเดทยอดคงเหลือ
        $fromWallet->balance -= $amount;
        $fromWallet->save();

        $toWallet = Wallet::where('user_id', $toUserId)
            ->where('currency_id', $currencyId)
            ->first();

        if (!$toWallet) {
            $toWallet = new Wallet();
            $toWallet->user_id = $toUserId;
            $toWallet->currency_id = $currencyId;
            $toWallet->balance = 0;
        }

        $toWallet->balance += $amount;
        $toWallet->save();

        return response()->json(['transaction' => $transaction], 201);
    }

    public function transferExternal(Request $request)
    {
        $request->validate([
            'external_address' => 'required|string',
            'network' => 'required|string',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric|min:0.00000001',
        ]);

        $fromUserId = Auth::id();
        $currencyId = $request->currency_id;
        $amount = $request->amount;

        // ตรวจสอบยอดคงเหลือ
        $fromWallet = Wallet::where('user_id', $fromUserId)
            ->where('currency_id', $currencyId)
            ->first();

        if ($fromWallet->balance < $amount) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        $transaction = new Transaction();
        $transaction->from_user_id = $fromUserId;
        $transaction->currency_id = $currencyId;
        $transaction->amount = $amount;
        $transaction->transaction_type = 'external';
        $transaction->save();

        $externalTransaction = $transaction->externalTransaction()->create([
            'external_address' => $request->external_address,
            'network' => $request->network,
        ]);

        // อัพเดทยอดคงเหลือ
        $fromWallet->balance -= $amount;
        $fromWallet->save();

        return response()->json(['transaction' => $transaction, 'external_transaction' => $externalTransaction], 201);
    }
}
