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
            'type_of_transaction' => 'SIMPLE',
        ]);
        Transaction::create([
            'type_of_transaction' => 'G2G',
        ]);
    }
}
