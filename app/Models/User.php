<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_member',
        'is_active',
        'phone',
        'address',
        'balance',
        'birthdate',
        'gender',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_member' => 'boolean',
            'is_active' => 'boolean',
            'balance' => 'decimal:2',
            'birthdate' => 'date',
        ];
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
    
    public function sales(){
        return $this->hasMany(Sale::class);
    }

    // Virtual Card relationship
    public function virtualCard()
    {
        return $this->hasOne(VirtualCard::class);
    }

    // Orders relationship (as customer)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Verified orders relationship (as cashier)
    public function verifiedOrders()
    {
        return $this->hasMany(Order::class, 'verified_by');
    }

    // Balance transactions relationship
    public function balanceTransactions()
    {
        return $this->hasMany(BalanceTransaction::class);
    }

    // Membership relationship
    public function membership()
    {
        return $this->hasOne(Membership::class);
    }

    // Vouchers relationship
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'voucher_user')
            ->withPivot('order_id', 'used_at')
            ->withTimestamps();
    }

    /**
     * Add balance to user
     */
    public function addBalance($amount, $paymentMethod = null, $referenceNumber = null, $description = null)
    {
        $balanceBefore = $this->balance;
        $this->balance += $amount;
        $this->save();

        return BalanceTransaction::create([
            'user_id' => $this->id,
            'type' => 'credit',
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->balance,
            'payment_method' => $paymentMethod,
            'reference_number' => $referenceNumber,
            'description' => $description ?? 'Top-up saldo',
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Deduct balance from user
     */
    public function deductBalance($amount, $description = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Saldo tidak mencukupi');
        }

        $balanceBefore = $this->balance;
        $this->balance -= $amount;
        $this->save();

        return BalanceTransaction::create([
            'user_id' => $this->id,
            'type' => 'debit',
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->balance,
            'description' => $description ?? 'Pembayaran',
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Get membership level
     */
    public function getMembershipLevel()
    {
        return $this->membership?->level;
    }

    /**
     * Get total spending
     */
    public function getTotalSpending()
    {
        return $this->membership?->total_spending ?? 0;
    }

    /**
     * Get profile photo URL
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        
        return null;
    }


}
