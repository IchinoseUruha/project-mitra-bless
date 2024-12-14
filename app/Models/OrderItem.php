<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id',
        'produk_id',
        'quantity',
        'price',
        'total',
        'address',
        'delivery_method',
        'payment_method',
        'payment_details',
        'status',
        'bukti_pembayaran'
    ];

    // Relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Konstanta untuk delivery method
    const DELIVERY_METHOD = [
        'DIANTAR' => 'diantar',
        'DIAMBIL' => 'diambil'
    ];

    // Konstanta untuk payment method 
    const PAYMENT_METHOD = [
        'EWALLET' => 'e-wallet',
        'BANK_TRANSFER' => 'bank_transfer',
        'BAYAR_DITEMPAT' => 'bayar_ditempat'
    ];

    // Konstanta untuk status
    const STATUS = [
        'MENUNGGU_PEMBAYARAN' => 'menunggu_pembayaran',
        'SEDANG_DIPROSES' => 'sedang_diproses', 
        'SEDANG_DIKIRIM' => 'sedang_dikirim',
        'SELESAI' => 'selesai',
        'DIBATALKAN' => 'dibatalkan'
    ];

    // Di model OrderItem
public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }
}