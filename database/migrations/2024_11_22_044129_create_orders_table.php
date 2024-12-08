<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users');
            $table->string('order_number')->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('total', 10, 2);
            
            // Informasi pengiriman
            $table->text('address')->nullable();
            $table->enum('delivery_method', ['diantar', 'diambil']);
            
            // Informasi pembayaran
            $table->enum('payment_method', ['e-wallet', 'bank_transfer', 'cash_on_delivery']);
            
            // Status pesanan
            $table->enum('status', [
                'menunggu_pembayaran',
                'sedang_diproses',
                'sedang_dikirim',
                'dikirim',
                'dibatalkan'
            ])->default('menunggu_pembayaran');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};