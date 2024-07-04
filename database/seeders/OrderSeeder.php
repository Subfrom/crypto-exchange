<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'user_id' => 1,
            'currency_id' => 1,
            'order_type' => 'buy',
            'amount' => 1,
            'price' => 30000,
            'status' => 'open',
        ]);

        Order::create([
            'user_id' => 2,
            'currency_id' => 2,
            'order_type' => 'sell',
            'amount' => 2,
            'price' => 2000,
            'status' => 'open',
        ]);

        Order::create([
            'user_id' => 3,
            'currency_id' => 3,
            'order_type' => 'buy',
            'amount' => 10,
            'price' => 1,
            'status' => 'open',
        ]);
    }
}
