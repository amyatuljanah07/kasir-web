# 🛒 Perbaikan Error Checkout

## Error yang Terjadi
```
SQLSTATE[01000]: Warning: 1265 Data truncated for column 'payment_method' at row 1
(Connection: mysql, SQL: insert into `orders` (`order_number`, `user_id`, `total`, 
`payment_method`, `status`, `updated_at`, `created_at`) values 
(ORD-20251101-000), 11, 14000, balance, paid, 2025-11-01 01:11:41, 2025-11-01 01:11:41))
```

## Penyebab
- **Controller** mengirim `payment_method = 'balance'`
- **Migration** enum hanya punya: `['virtual_card', 'cash', 'transfer']`
- Nilai `'balance'` tidak ada di enum, jadi SQL error

## Solusi

### 1. Update Migration
File: `database/migrations/2025_10_28_070216_create_orders_table.php`

**SEBELUM:**
```php
$table->enum('payment_method', ['virtual_card', 'cash', 'transfer'])->default('virtual_card');
```

**SESUDAH:**
```php
$table->enum('payment_method', ['virtual_card', 'balance', 'cash', 'transfer'])->default('balance');
```

### 2. Re-run Migration
```bash
php artisan migrate:fresh --seed
php artisan db:seed --class=MembershipLevelSeeder
```

### 3. Setup User Test
```bash
# Buat user Oca dengan balance 54rb
php artisan tinker --execute="
\$user = App\Models\User::create([
    'name' => 'Oca',
    'email' => 'oca@gmail.com',
    'password' => bcrypt('password'),
    'role_id' => 1,
    'is_active' => true,
    'balance' => 54000
]);
"

# Buat virtual card dengan PIN 1234
php artisan tinker --execute="
\$user = App\Models\User::where('name', 'Oca')->first();
App\Models\VirtualCard::create([
    'user_id' => \$user->id,
    'card_number' => 'VC' . str_pad(\$user->id, 8, '0', STR_PAD_LEFT),
    'pin' => bcrypt('1234'),
    'balance' => 0,
    'status' => 'active'
]);
"
```

## Payment Method Options
Sekarang sistem support 4 metode pembayaran:

1. **`balance`** - Bayar pakai saldo user (dari top-up)
   - Digunakan di: Customer Shop Checkout
   - Saldo terpotong otomatis
   - Status order langsung `paid`

2. **`virtual_card`** - Bayar pakai virtual card
   - Untuk transaksi kasir
   - Saldo di virtual card

3. **`cash`** - Bayar tunai di kasir
   - Manual entry oleh kasir
   - Perlu verifikasi

4. **`transfer`** - Transfer bank
   - Upload bukti transfer
   - Perlu verifikasi admin

## Testing

### Login Credentials:
- **Email**: oca@gmail.com
- **Password**: password
- **Virtual Card PIN**: 1234
- **Balance**: Rp 54.000

### Test Flow:
1. Login sebagai Oca
2. Buka `/customer/shop`
3. Tambah produk ke cart (total < Rp 54.000)
4. Klik "Bayar Sekarang"
5. Masukkan PIN: `1234`
6. Checkout berhasil! ✅

## Files Modified
1. ✅ `database/migrations/2025_10_28_070216_create_orders_table.php` - Tambah 'balance' ke enum
2. ✅ Migration baru: `2025_11_01_011239_update_payment_method_enum_in_orders_table.php` - Auto-generated

## Status
✅ **FIXED** - Checkout sekarang berfungsi dengan payment_method = 'balance'

---
*Fixed: November 1, 2025*
