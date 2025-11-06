<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class VirtualCard extends Model
{
    protected $fillable = [
        'user_id',
        'card_number',
        'pin',
        'balance',
        'status'
    ];

    protected $hidden = [
        'pin'
    ];

    protected $casts = [
        'balance' => 'decimal:2'
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk validasi PIN
    public function validatePin($pin)
    {
        return Hash::check($pin, $this->pin);
    }

    // Method untuk generate card number
    public static function generateCardNumber()
    {
        do {
            $number = 'SKCARD-' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        } while (self::where('card_number', $number)->exists());
        
        return $number;
    }
}
