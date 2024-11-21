<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brand';
    protected $fillable = ['name', 'slug'];

    public function produk()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}
