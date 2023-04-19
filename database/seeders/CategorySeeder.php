<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        collect(['General (Masjid)', 'Madarasa', 'Fitra', 'Zakat', 'Sadqa'])->each(function ($title) {
            Category::create(['name' => $title]);
        });
    }
}
