<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::factory()->count(10)->create();

//        DB::table('users')->insert([
//     'name' => 'Admin',
//     'email' => 'admin@example.com',
//     'role' => 'admin', // pastikan ada
//     'password' => bcrypt('password'),
// ]);
    }
}
