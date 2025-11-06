<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'total',
        'discount_amount',
        'payment_method',
        'status',
        'verified_by',
        'verified_at'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'verified_at' => 'datetime'
    ];

    // Relationship dengan User (Customer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan User (Cashier/Pegawai yang verifikasi)
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Relationship dengan OrderItems
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Method untuk generate order number
    public static function generateOrderNumber()
    {
        $date = date('Ymd');
        $latest = self::whereDate('created_at', today())->latest()->first();
        $sequence = $latest ? intval(substr($latest->order_number, -4)) + 1 : 1;
        
        return 'ORD-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
