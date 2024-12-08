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
        'subtotal'
    ];

    // Relasi dengan order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi dengan produk
    public function produk()
    {
        return $this->belongsTo(Product::class);
    }

    // Method untuk menghitung subtotal
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($orderItem) {
            $orderItem->subtotal = $orderItem->quantity * $orderItem->price;
        });
    }
}