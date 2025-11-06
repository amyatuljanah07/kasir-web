<?php

namespace App\Observers;

use App\Models\User;
use App\Models\VirtualCard;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Otomatis buat virtual card untuk customer (role_id = 3)
        if ($user->role_id == 3) {
            // Create virtual card
            VirtualCard::create([
                'user_id' => $user->id,
                'card_number' => VirtualCard::generateCardNumber(),
                'pin' => Hash::make('1234'), // Default PIN
                'balance' => 0, // Balance sekarang di user table
                'status' => 'active'
            ]);
            
            // Give welcome bonus Rp 100.000
            $user->balance = 100000;
            $user->saveQuietly(); // Save tanpa trigger observer lagi
            
            // Create balance transaction record
            \App\Models\BalanceTransaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => 100000,
                'balance_before' => 0,
                'balance_after' => 100000,
                'payment_method' => 'welcome_bonus',
                'description' => 'Welcome Bonus untuk Member Baru 🎉',
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
