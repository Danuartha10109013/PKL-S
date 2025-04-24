<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
            [
                'id' => 1,
                'username' => 'produksi',
                'name' => 'produksi',
                'role' => '1',
                'active' => '1',
                'profile' => 'profile/produksi_IMG-20240902-WA0023.jpg',
                'email' => 'produksi@exaple.com',
                'email_verified_at' => '2024-09-26 19:14:38',
                'password' => Hash::make('12345'),
                'remember_token' => 'Pj025p4ycFz2I7WpkT0RZzmd7fWGwSyANWXWHZGf2ftOWSvmzNoFyQ0TgMxS',
                'created_at' => '2024-09-26 19:14:39',
                'updated_at' => '2024-12-20 03:37:50',
            ],
            [
                'id' => 2,
                'username' => 'admin',
                'name' => 'adminnnn',
                'role' => '0',
                'active' => '1',
                'profile' => 'profile/admin_7.png',
                'email' => 'admin@cc.cc',
                'email_verified_at' => '2024-09-26 19:14:39',
                'password' => Hash::make('12345'),
                'remember_token' => '6Eg9okx5qKAWVANJ7nj7LLmLVq6TLz4t71k9Qc5wNjeY0PetiIAerfbX0fHT',
                'created_at' => '2024-09-26 19:14:39',
                'updated_at' => '2025-04-24 21:26:52',
            ],
            [
                'id' => 3,
                'username' => 'direktur',
                'name' => 'direktur',
                'role' => '2',
                'active' => '1',
                'profile' => null,
                'email' => 'direktur@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('12345'),
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => '2024-11-26 14:12:11',
            ],
        ]);
    }
}
