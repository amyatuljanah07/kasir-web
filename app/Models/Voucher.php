<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'usage_per_user',
        'valid_from',
        'valid_until',
        'is_active',
        'is_member_only',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_per_user' => 'integer',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'is_member_only' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'voucher_user')
            ->withPivot('order_id', 'used_at')
            ->withTimestamps();
    }

    /**
     * Check if voucher is valid
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now()->startOfDay();
        
        if ($this->valid_from > $now || $this->valid_until < $now) {
            return false;
        }

        if ($this->usage_limit && $this->users()->count() >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount($totalAmount)
    {
        if ($totalAmount < $this->min_purchase) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = $totalAmount * ($this->value / 100);
            
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
            
            return $discount;
        }

        return min($this->value, $totalAmount);
    }
}
