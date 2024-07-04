<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'currency_id' => 'required|exists:currencies,id',
            'order_type' => 'required|in:buy,sell',
            'amount' => 'required|numeric|min:0.00000001',
            'price' => 'required|numeric|min:0.00000001',
        ]);

        $order = new Order();
        $order->user_id = Auth::id();
        $order->currency_id = $request->currency_id;
        $order->order_type = $request->order_type;
        $order->amount = $request->amount;
        $order->price = $request->price;
        $order->status = 'open';
        $order->save();

        // ตรวจสอบคำสั่งซื้อขายที่ตรงกัน
        $this->matchOrder($order);

        return response()->json(['order' => $order], 201);
    }

    protected function matchOrder(Order $order)
    {
        // หา matched order
        $matchedOrder = Order::where('currency_id', $order->currency_id)
            ->where('order_type', $order->order_type === 'buy' ? 'sell' : 'buy')
            ->where('price', $order->price)
            ->where('status', 'open')
            ->first();

        if ($matchedOrder) {
            $transaction = new Transaction();
            $transaction->order_id = $order->id;
            $transaction->from_user_id = $matchedOrder->user_id;
            $transaction->to_user_id = $order->user_id;
            $transaction->currency_id = $order->currency_id;
            $transaction->amount = min($order->amount, $matchedOrder->amount);
            $transaction->transaction_type = 'internal';
            $transaction->save();

            // อัพเดทคำสั่งซื้อขาย
            $order->amount -= $transaction->amount;
            $matchedOrder->amount -= $transaction->amount;

            if ($order->amount == 0) {
                $order->status = 'closed';
            }

            if ($matchedOrder->amount == 0) {
                $matchedOrder->status = 'closed';
            }

            $order->save();
            $matchedOrder->save();
        }
    }
}
