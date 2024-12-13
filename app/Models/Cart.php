<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart'; 
    protected $fillable = ['customer_id', 'produk_id', 'quantity'];

    // Relasi ke model Product
    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id'); 
    }

}
