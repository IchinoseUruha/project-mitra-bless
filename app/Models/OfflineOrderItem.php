<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineOrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'order_number',
        'produk_id',
        'nama_produk',
        'quantity',
        'price',
        'total',
        'harga_diskon',
        'payment_method',
        'payment_details',
        'status'
    ];

    // Konstanta untuk payment method 
    const PAYMENT_METHOD = [
        'CASH' => 'cash',
        'BANK_TRANSFER' => 'bank_transfer',
        'E_WALLET' => 'e_wallet'
    ];

    // Relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
