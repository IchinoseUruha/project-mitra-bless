<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Agar bisa digunakan untuk login
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'customer'; // Nama tabel di database

    protected $fillable = [
        'name', 
        'email',
        'mobile', 
        'password',
        // Tambahkan kolom lain sesuai tabel customer Anda
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
