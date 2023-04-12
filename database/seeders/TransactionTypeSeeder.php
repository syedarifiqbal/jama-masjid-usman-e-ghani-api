<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionType::truncate();
        collect(['Income', 'Expense'])->each(function ($title) {
            TransactionType::create(['name' => $title]);
        });
    }
}
