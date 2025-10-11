<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'category_id',
        'gambar'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    // Relationship to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship to Cart
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Accessor untuk URL gambar
    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }
}
