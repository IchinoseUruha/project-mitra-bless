<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Pastikan nama tabel ini sesuai di database

    protected $fillable = [
        'kategori_id', 
        'brand_id', 
        'name', 
        'description', 
        'price', 
        'slug', 
        'image'
    ];

    // Relasi ke Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id'); // Ubah ke "category"
    }
}
