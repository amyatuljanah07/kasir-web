# 🎁 Welcome Bonus System

## Fitur Baru: Welcome Bonus Rp 100.000

### Overview
Setiap customer baru yang register akan otomatis mendapatkan **Welcome Bonus sebesar Rp 100.000** di saldo mereka.

---

## How It Works

### 1. User Registration Flow
```
Register → Login → Redirect ke Kartu Virtual → 🎉 Saldo Rp 100.000!
```

### 2. Auto Process (UserObserver)
Saat user baru dibuat dengan `role_id = 3` (customer):

1. ✅ Create Virtual Card dengan PIN default `1234`
2. ✅ Set `user.balance = 100000`
3. ✅ Create Balance Transaction record:
   - Type: `credit`
   - Amount: `100000`
   - Description: `Welcome Bonus untuk Member Baru 🎉`
   - Status: `completed`

### 3. Balance System
- **Primary Balance**: `users.balance` (ini yang digunakan untuk transaksi)
- **Virtual Card Balance**: `virtual_cards.balance` (deprecated, set ke 0)

---

## Implementation

### File yang Diubah

#### `app/Observers/UserObserver.php`
```php
public function created(User $user): void
{
    if ($user->role_id == 3) {
        // Create virtual card
        VirtualCard::create([
            'user_id' => $user->id,
            'card_number' => VirtualCard::generateCardNumber(),
            'pin' => Hash::make('1234'),
            'balance' => 0, // Balance sekarang di user table
            'status' => 'active'
        ]);
        
        // Give welcome bonus Rp 100.000
        $user->balance = 100000;
        $user->saveQuietly();
        
        // Create transaction record
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
```

---

## Testing

### Test Manual Register
1. Buka halaman register
2. Isi form registrasi
3. Submit
4. Login dengan akun baru
5. Redirect ke `/customer/virtual-card`
6. **Expected**: Saldo tampil Rp 100.000 ✅

### Test Programmatically
```bash
php artisan tinker

>>> $user = \App\Models\User::create([
...     'name' => 'New Customer',
...     'email' => 'newcustomer@test.com',
...     'password' => bcrypt('password'),
...     'role_id' => 3,
...     'is_active' => true
... ]);

>>> $user->balance
=> 100000

>>> $user->balanceTransactions->first()->description
=> "Welcome Bonus untuk Member Baru 🎉"
```

---

## Update Existing Users

### Update Saldo Oca ke 54.000
```sql
UPDATE users SET balance = 54000 WHERE name = 'Oca';
```

atau via Tinker:
```bash
php artisan tinker --execute="
DB::table('users')->where('name', 'Oca')->update(['balance' => 54000]);
echo 'Saldo Oca updated';
"
```

---

## Riwayat Transaksi

Customer bisa lihat welcome bonus di halaman `/customer/balance`:

```
📊 Riwayat Transaksi
┌─────────────────────────────────────────────────┐
│ Welcome Bonus untuk Member Baru 🎉              │
│ 01 Nov 2025, 10:00 · WELCOME_BONUS              │
│ + Rp 100.000                        ✅ Completed │
└─────────────────────────────────────────────────┘
```

---

## Notes

- ✅ Welcome bonus hanya diberikan sekali saat registrasi
- ✅ Balance tercatat di `balance_transactions` untuk audit trail
- ✅ Customer bisa top-up lagi jika saldo habis
- ✅ Balance terintegrasi dengan checkout & membership

---

## Migration Note

**Untuk existing users yang belum punya balance:**
```bash
# Set default balance 0 untuk user lama
php artisan tinker --execute="
\App\Models\User::where('role_id', 3)
    ->whereNull('balance')
    ->update(['balance' => 0]);
"
```

**Untuk kasih welcome bonus ke existing customer:**
```bash
php artisan tinker --execute="
\$customers = \App\Models\User::where('role_id', 3)
    ->where('balance', 0)
    ->get();
    
foreach(\$customers as \$user) {
    \$user->addBalance(100000, 'welcome_bonus', null, 'Welcome Bonus untuk Member Baru 🎉');
    echo 'Bonus added for: ' . \$user->name . PHP_EOL;
}
"
```

---

**Implemented on: November 1, 2025**
