<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('offline_order_items', function (Blueprint $table) {
            $table->string('nama_produk')->after('produk_id');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('nama_produk')->after('produk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offline_order_items', function (Blueprint $table) {
            $table->dropColumn('nama_produk');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('nama_produk');
        });
    }
};
