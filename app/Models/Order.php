<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_number',
        'address',
        'delivery_method',
        'payment_method',
        'payment_details', // Tambahkan ini
        'subtotal',
        'tax',
        'total',
        'status'
    ];

    // Relasi ke order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke customer/user
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Method untuk mendapatkan status yang tersedia
    public static function getStatuses()
    {
        return [
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'sedang_diproses' => 'Sedang Diproses',
            'sedang_dikirim' => 'Sedang Dikirim',
            'dikirim' => 'Dikirim',
            'dibatalkan' => 'Dibatalkan'
        ];
    }
}
?>