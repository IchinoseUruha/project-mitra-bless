<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id'
    ];

    // Relasi ke order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function offlineItems()
    {
        return $this->hasMany(OfflineOrderItem::class);
    }

    // Relasi ke user untuk controller lain
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    // Relasi ke customer (alias dari user)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}