# 💰 Perbaikan Balance Display di Halaman Belanja

## Masalah
- **Virtual Card** menampilkan Rp 100.000 ✅
- **Halaman Belanja** menampilkan Rp 0 ❌

## Penyebab
View halaman belanja (`shop/index.blade.php`) menampilkan `$virtualCard->balance` (dari table `virtual_cards`) padahal welcome bonus disimpan di `$balance` (dari table `users`).

### Data di Database:
```
users.balance = 100000          ← Welcome Bonus 
virtual_cards.balance = 0       ← Tidak dipakai lagi
```

## Solusi

### File: `resources/views/customer/shop/index.blade.php`

**1. Update Balance Display di Header** (Line 541-543)
```blade
<!-- SEBELUM -->
<div class="balance-label">💳 Saldo Virtual Card</div>
<div class="balance-amount">Rp {{ number_format($virtualCard->balance, 0, ',', '.') }}</div>

<!-- SESUDAH -->
<div class="balance-label">💰 Saldo Anda</div>
<div class="balance-amount">Rp {{ number_format($balance, 0, ',', '.') }}</div>
```

**2. Update JavaScript Variable** (Line 740)
```javascript
// SEBELUM
const virtualCardBalance = {{ $virtualCard->balance }};

// SESUDAH
const userBalance = {{ $balance }};
```

**3. Update Balance Check** (Line 813-814)
```javascript
// SEBELUM
if (total > virtualCardBalance) {
    showAlert(`Saldo tidak mencukupi! Saldo Anda: Rp ${formatNumber(virtualCardBalance)}`, 'error');
    
// SESUDAH
if (total > userBalance) {
    showAlert(`Saldo tidak mencukupi! Saldo Anda: Rp ${formatNumber(userBalance)}`, 'error');
```

## Arsitektur Balance System

### Single Source of Truth: `users.balance`
Semua transaksi customer menggunakan balance dari table `users`:

1. **Welcome Bonus** → `users.balance` (+100k)
2. **Top Up** → `users.balance` (+nominal)
3. **Checkout Shop** → `users.balance` (-total)
4. **Transfer** → `users.balance` (+ atau -)

### Table `virtual_cards`
- Hanya menyimpan: `card_number`, `pin`, `status`
- Field `balance` tidak digunakan lagi (deprecated)
- Bisa di-drop di migration future

## Konsistensi di Semua View

### ✅ Sudah Benar:
- `customer/virtual-card/index.blade.php` → `auth()->user()->balance`
- `customer/balance/*` → `auth()->user()->balance`
- `customer/profile/index.blade.php` → `auth()->user()->balance`

### ✅ Baru Diperbaiki:
- `customer/shop/index.blade.php` → `$balance` (passed from controller)

## Testing

### Verifikasi Balance:
```bash
php artisan tinker --execute="
\$user = App\Models\User::where('name', 'Nana')->first();
echo 'User Balance: Rp ' . number_format(\$user->balance, 0, ',', '.') . PHP_EOL;
\$card = \$user->virtualCard;
echo 'Card Balance: Rp ' . number_format(\$card->balance, 0, ',', '.') . PHP_EOL;
"

# Output yang benar:
# User Balance: Rp 100.000  ← Ini yang ditampilkan
# Card Balance: Rp 0         ← Deprecated, tidak dipakai
```

### Test di Browser:
1. Login sebagai user dengan welcome bonus
2. Buka `/customer/virtual-card` → Harus tampil Rp 100.000 ✅
3. Buka `/customer/shop` → Harus tampil Rp 100.000 ✅ (FIXED!)
4. Coba checkout produk → Balance harus terpotong dari `users.balance`

## Status
✅ **FIXED** - Halaman belanja sekarang menampilkan balance yang benar (Rp 100.000)

---
*Fixed: November 1, 2025*
