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
        Schema::table('produk', function (Blueprint $table) {
            // First check if the column exists, then modify it
            if (Schema::hasColumn('produk', 'quantity')) {
                $table->string('quantity', 1000)->nullable()->change();
            } else {
                $table->string('quantity', 1000)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            // Revert the changes
            if (Schema::hasColumn('produk', 'quantity')) {
                $table->string('quantity')->change();  // Change back to original state
            }
        });
    }
};