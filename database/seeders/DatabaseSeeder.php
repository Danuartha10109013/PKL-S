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
        DB::table('users')->insert([
            [
                'id' => 1,
                'username' => 'produksi',
                'name' => 'Bagian Produksi',
                'role' => '1',
                'active' => '1',
                'profile' => 'profile/produksi_IMG-20240902-WA0023.jpg',
                'email' => 'produksi@gmail.com',
                'email_verified_at' => '2024-09-26 12:14:38',
                'password' => Hash::make('12345'), // already hashed
                'remember_token' => 'Pj025p4ycFz2I7WpkT0RZzmd7fWGwSyANWXWHZGf2ftOWSvmzNoFyQ0TgMxS',
                'created_at' => '2024-09-26 12:14:39',
                'updated_at' => '2024-12-19 20:37:50',
            ],
            [
                'id' => 2,
                'username' => 'pengadaan',
                'name' => 'Bagian Pengadaan',
                'role' => '0',
                'active' => '1',
                'profile' => 'profile/admin_7.png',
                'email' => 'admin@gmail.com',
                'email_verified_at' => '2024-09-26 12:14:39',
                'password' => Hash::make('12345'), // already hashed
                'remember_token' => 'XAfMokJ5VG18tpUQX2P4DxWZ5Mifhxmvo6Bhj9Q1nSTPQCxXxkpwjY63dGiT',
                'created_at' => '2024-09-26 12:14:39',
                'updated_at' => '2025-04-24 14:26:52',
            ],
            [
                'id' => 3,
                'username' => 'direktur',
                'name' => 'Direktur',
                'role' => '2',
                'active' => '1',
                'profile' => null,
                'email' => 'direktur@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('12345'), // already hashed
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => '2024-11-26 07:12:11',
            ],
            [
                'id' => 4,
                'username' => 'sales',
                'name' => 'Sales',
                'role' => '3',
                'active' => '1',
                'profile' => null,
                'email' => 'sales@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('12345'), // already hashed
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => '2024-11-26 07:12:11',
            ],
        ]);
    }
}
