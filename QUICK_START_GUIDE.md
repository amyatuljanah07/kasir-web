# 🚀 Quick Start Guide - Customer Module Update

## Langkah-langkah Setup Cepat

### 1️⃣ Jalankan Migrations

```bash
php artisan migrate
```

**Output yang diharapkan:**
```
Migrating: 2025_11_01_000001_add_customer_fields_to_users_table
Migrated:  2025_11_01_000001_add_customer_fields_to_users_table (XX.XXms)
Migrating: 2025_11_01_000002_create_balance_transactions_table
Migrated:  2025_11_01_000002_create_balance_transactions_table (XX.XXms)
...
```

### 2️⃣ Seed Membership Levels

```bash
php artisan db:seed --class=MembershipLevelSeeder
```

**Output yang diharapkan:**
```
Database seeding completed successfully.
```

### 3️⃣ Create Storage Link

```bash
php artisan storage:link
```

**Output yang diharapkan:**
```
The [public/storage] link has been connected to [storage/app/public].
```

---

## ✅ Testing Checklist

### Test 1: Register & Login
- [ ] Register customer baru
- [ ] Login dengan akun customer
- [ ] Pastikan redirect ke virtual card

### Test 2: Top-up Saldo
- [ ] Buka `/customer/balance`
- [ ] Klik "Top-up Saldo"
- [ ] Pilih nominal Rp 100.000
- [ ] Pilih metode "Bank Transfer"
- [ ] Submit dan approve (demo mode)
- [ ] Cek saldo bertambah di dashboard

### Test 3: Join Member
- [ ] Buka `/customer/membership`
- [ ] Klik "Gabung Jadi Member"
- [ ] Cek dapat badge "Nova Member"
- [ ] Buka `/customer/membership/welcome`
- [ ] Lihat benefit Nova

### Test 4: Belanja & Level Up
- [ ] Buka `/customer/shop`
- [ ] Lihat section "Produk Populer" (jika ada)
- [ ] Tambah produk ke cart
- [ ] Checkout dengan PIN (default: 1234)
- [ ] Cek saldo berkurang
- [ ] Belanja total > Rp 1.000.000
- [ ] Lihat notifikasi level up ke Stellar

### Test 5: Profile & Upload Foto
- [ ] Buka `/customer/profile`
- [ ] Klik icon kamera
- [ ] Upload foto (JPG/PNG, max 2MB)
- [ ] Edit nama, HP, alamat
- [ ] Simpan
- [ ] Cek foto muncul di navbar

### Test 6: Leaderboard
- [ ] Buka `/customer/leaderboard`
- [ ] Lihat ranking customer
- [ ] Cek posisi sendiri
- [ ] Klaim voucher (jika ada)

---

## 🎯 Test Scenarios

### Scenario A: Customer Baru Lengkap

```
1. Register → Login
2. Lihat virtual card (saldo Rp 0)
3. Top-up Rp 500.000
4. Join membership (jadi Nova)
5. Belanja Rp 200.000 (dapat diskon 5% = Rp 10.000)
6. Cek saldo tersisa: Rp 310.000
7. Cek membership spending: Rp 200.000
8. Upload foto profil
9. Edit alamat & HP
10. Lihat leaderboard
```

### Scenario B: Test Level Up

```
1. Login dengan customer yang sudah punya saldo
2. Cek level saat ini di /customer/membership
3. Belanja total Rp 1.500.000 (untuk ke Stellar)
4. Setelah checkout, lihat notifikasi level up
5. Buka /customer/membership → lihat level Stellar
6. Cek diskon jadi 10%
7. Belanja lagi Rp 500.000
8. Cek dapat diskon 10% = Rp 50.000
```

### Scenario C: Test Voucher & Leaderboard

```
1. Login sebagai top customer (belanja banyak)
2. Buka /customer/leaderboard
3. Lihat ranking (harusnya top 10)
4. Scroll ke voucher section
5. Klaim voucher yang tersedia
6. Cek di dropdown user → ada voucher
7. Gunakan voucher saat checkout
```

---

## 🐛 Troubleshooting

### Problem: Migration Failed
```bash
# Reset database (HATI-HATI!)
php artisan migrate:fresh

# Seed ulang
php artisan db:seed --class=MembershipLevelSeeder
```

### Problem: Foto tidak muncul
```bash
# Recreate storage link
rm public/storage
php artisan storage:link

# Set permission (Linux/Mac)
chmod -R 775 storage
```

### Problem: Error 500 saat upload foto
```bash
# Check storage permissions
ls -la storage/

# Set permission
chmod -R 775 storage/app/public
```

### Problem: PIN tidak bisa diubah
```
- Default PIN: 1234
- Pastikan input 4 digit angka
- Cek di database: virtual_cards table
```

---

## 📊 Database Check

### Cek Membership Levels

```sql
SELECT * FROM membership_levels ORDER BY `order`;
```

**Expected:**
```
| id | name    | slug    | min_spending | discount_rate |
|----|---------|---------|--------------|---------------|
| 1  | Nova    | nova    | 0            | 5.00          |
| 2  | Stellar | stellar | 1000000      | 10.00         |
| 3  | Galaxy  | galaxy  | 5000000      | 15.00         |
```

### Cek User Balance

```sql
SELECT id, name, balance, is_member FROM users WHERE role_id = 3;
```

### Cek Membership Progress

```sql
SELECT u.name, ml.name as level, m.total_spending, m.points 
FROM users u
JOIN memberships m ON u.id = m.user_id
JOIN membership_levels ml ON m.membership_level_id = ml.id
WHERE u.role_id = 3;
```

---

## 📱 Mobile Testing

### Test Responsive
- [ ] Buka di mobile browser
- [ ] Test menu hamburger (jika ada)
- [ ] Test virtual card display
- [ ] Test top-up form
- [ ] Test membership cards
- [ ] Test leaderboard table
- [ ] Test profile upload foto

---

## ⚡ Performance Check

### Page Load Time
- Dashboard: < 1s
- Shop: < 2s
- Membership: < 1s
- Leaderboard: < 2s

### Database Queries
- Check dengan Laravel Debugbar
- Optimasi dengan eager loading
- Index untuk: users.balance, memberships.total_spending

---

## 🎉 Success Criteria

Semua fitur di bawah ini harus berfungsi:

✅ Customer bisa top-up saldo
✅ Saldo tampil di dashboard & navbar
✅ Customer bisa join membership
✅ Level naik otomatis saat belanja
✅ Produk populer muncul di shop
✅ Navbar dashboard sudah dihapus
✅ Virtual card ukurannya lebih kecil
✅ Upload foto profil berhasil
✅ Edit profil berhasil
✅ Membership badge muncul di profil
✅ Leaderboard menampilkan ranking
✅ Voucher bisa diklaim
✅ Halaman eksklusif member bisa diakses

---

**Happy Testing! 🚀**
