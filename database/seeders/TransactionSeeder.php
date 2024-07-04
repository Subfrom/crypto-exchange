<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::create([
            'order_id' => 1,
            'from_user_id' => 1,
            'to_user_id' => 2,
            'currency_id' => 1,
            'amount' => 0.5,
            'transaction_type' => 'internal',
        ]);

        Transaction::create([
            'order_id' => 2,
            'from_user_id' => 2,
            'to_user_id' => 3,
            'currency_id' => 2,
            'amount' => 1,
            'transaction_type' => 'internal',
        ]);

        Transaction::create([
            'order_id' => 3,
            'from_user_id' => 3,
            'to_user_id' => 1,
            'currency_id' => 3,
            'amount' => 10,
            'transaction_type' => 'internal',
        ]);
    }
}
