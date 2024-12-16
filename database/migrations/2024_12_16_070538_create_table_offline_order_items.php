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
        Schema::create('offline_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('order_number');
            $table->integer('produk_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->decimal('harga_diskon', 10, 2)->nullable();
            $table->enum('payment_method', ['cash', 'bank_transfer', 'e_wallet']);
            $table->string('payment_details')->nullable();
            $table->string('status')->default('selesai');  // Langsung status selesai
            $table->timestamps();
            
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_offline_order_items');
    }
};
