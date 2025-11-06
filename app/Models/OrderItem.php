<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_variant_id',
        'quantity',
        'price',
        'subtotal'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    // Relationship dengan Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship dengan ProductVariant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // Accessor untuk product info
    public function getProductAttribute()
    {
        return $this->variant->product;
    }
}
