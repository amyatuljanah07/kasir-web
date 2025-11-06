<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_level_id',
        'start_date',
        'end_date',
        'discount_rate',
        'total_spending',
        'points',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'discount_rate' => 'decimal:2',
        'total_spending' => 'decimal:2',
        'points' => 'integer',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(MembershipLevel::class, 'membership_level_id');
    }

    /**
     * Update level berdasarkan total spending
     */
    public function updateLevel()
    {
        $newLevel = MembershipLevel::getLevelBySpending($this->total_spending);
        
        if ($newLevel && $this->membership_level_id !== $newLevel->id) {
            $this->membership_level_id = $newLevel->id;
            $this->discount_rate = $newLevel->discount_rate;
            $this->save();
            
            return $newLevel;
        }
        
        return null;
    }

    /**
     * Add spending and update level
     */
    public function addSpending($amount, $pointsMultiplier = 1)
    {
        $this->total_spending += $amount;
        $this->points += (int)($amount / 1000) * $pointsMultiplier; // 1000 rupiah = 1 point
        $this->save();
        
        return $this->updateLevel();
    }
}
