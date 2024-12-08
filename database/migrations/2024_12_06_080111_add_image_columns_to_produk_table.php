<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageColumnsToProdukTable extends Migration
{
    public function up()
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('quantity'); // Kolom untuk path gambar utama
            $table->string('gallery_path')->nullable()->after('image_path'); // Optional: Kolom untuk path galeri gambar
        });
    }

    public function down()
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn('image_path');
            $table->dropColumn('gallery_path');
        });
    }
}