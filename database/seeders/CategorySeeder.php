<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Cookies']);
        Category::create(['name' => 'Brownies']);
        Category::create(['name' => 'Drink']);
        Category::create(['name' => 'Food']);
    }
}
