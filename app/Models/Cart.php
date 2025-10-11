<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'subtotal'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Calculate subtotal automatically
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($cart) {
            $cart->subtotal = $cart->price * $cart->quantity;
        });
    }
}
