<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Tambahkan field yang sesuai dengan tabel categories
    ];

    // Relasi dengan Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
