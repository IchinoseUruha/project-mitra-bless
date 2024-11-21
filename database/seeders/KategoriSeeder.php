<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori')->insert([
            [
                'id' => 1, // Ensure this matches the ID referenced in ProdukSeeder
                'name' => 'Kategori 1',
                'slug' => 'kategori-1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
