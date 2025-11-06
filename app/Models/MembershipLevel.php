<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'min_spending',
        'discount_rate',
        'points_multiplier',
        'benefits',
        'badge_color',
        'order',
    ];

    protected $casts = [
        'min_spending' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'points_multiplier' => 'integer',
        'order' => 'integer',
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Get benefits as array
     */
    public function getBenefitsArrayAttribute()
    {
        return json_decode($this->benefits, true) ?? [];
    }

    /**
     * Get level berdasarkan total spending
     */
    public static function getLevelBySpending($totalSpending)
    {
        return self::where('min_spending', '<=', $totalSpending)
            ->orderBy('min_spending', 'desc')
            ->first();
    }
}
