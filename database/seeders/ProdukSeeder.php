<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produk')->insert([
            [
                'kategori_id' => 1, // Replace with an actual ID from your kategori table
                'brand_id' => 1,    // Replace with an actual ID from your brand table
                'name' => 'Sample Product',
                'slug' => 'sample-product',
                'description' => 'This is a sample product description.',
                'price' => 99.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
