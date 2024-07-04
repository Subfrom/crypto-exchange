<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wallet::create([
            'user_id' => 1,
            'currency_id' => 1,
            'balance' => 10,
        ]);

        Wallet::create([
            'user_id' => 1,
            'currency_id' => 2,
            'balance' => 50,
        ]);

        Wallet::create([
            'user_id' => 2,
            'currency_id' => 1,
            'balance' => 5,
        ]);

        Wallet::create([
            'user_id' => 3,
            'currency_id' => 3,
            'balance' => 100,
        ]);
    }
}
