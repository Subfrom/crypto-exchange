<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function confirmTransaction(Transaction $transaction)
    {
        $transaction->status = 'confirmed';
        $transaction->save();

        // อัพเดทยอดคงเหลือในกระเป๋าเงินของผู้ใช้
        $fromWallet = Wallet::where('user_id', $transaction->from_user_id)
            ->where('currency_id', $transaction->currency_id)
            ->first();

        $toWallet = Wallet::where('user_id', $transaction->to_user_id)
            ->where('currency_id', $transaction->currency_id)
            ->first();

        $fromWallet->balance -= $transaction->amount;
        $toWallet->balance += $transaction->amount;

        $fromWallet->save();
        $toWallet->save();

        return response()->json(['transaction' => $transaction], 200);
    }

    public function recordExternalTransaction(Request $request, Transaction $transaction)
    {
        $request->validate([
            'external_address' => 'required|string',
            'network' => 'required|string',
        ]);

        $externalTransaction = $transaction->externalTransaction()->create([
            'external_address' => $request->external_address,
            'network' => $request->network,
        ]);

        return response()->json(['external_transaction' => $externalTransaction], 201);
    }
}
