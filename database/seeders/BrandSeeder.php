<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brand')->insert([
            [
                'id' => 1, // Ensure this matches the ID referenced in ProdukSeeder
                'name' => 'Brand 1',
                'slug' => 'brand-1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
