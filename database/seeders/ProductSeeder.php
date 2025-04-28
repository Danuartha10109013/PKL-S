<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product')->insert([
            ['name' => 'Mechanical Seal Cartridge Double', 'status' => '0',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cartridge Mechanical Seals', 'status' => '0',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mechanical Seal Cartridge Single', 'status' => '0', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cartridge Mechanical Seal', 'status' => '0',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mechanical Seal Basic/Component', 'status' => '0', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mechanical Seal Basic Component', 'status' => '0', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Split Mechanical Seal', 'status' => '0',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'FMG Mechanical Seal for Booster Pump BFPT', 'status' => '0',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'FMG Mechanical Seal for Boiler Feed Pump BFP', 'status' => '0',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'FMG Mechanical Seal for Nemo Pump Andritz', 'status' => '0',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mechanical Seal for Delitur Tank', 'status' => '0',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'FMG Mechanical Seal for CEP Pump', 'status' => '0',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mechanical Seal for Shang Kai Quan Pump', 'status' => '0',  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
