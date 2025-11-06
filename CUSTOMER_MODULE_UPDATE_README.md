# 🎉 Update Customer Module - Sellin Kasir

Dokumentasi lengkap pembaruan sistem customer untuk Sellin Kasir dengan fitur-fitur baru yang menarik!

## 📋 Daftar Isi
- [Fitur Baru](#-fitur-baru)
- [Migration & Database](#-migration--database)
- [Setup & Instalasi](#-setup--instalasi)
- [Struktur File](#-struktur-file)
- [Cara Penggunaan](#-cara-penggunaan)
- [Testing](#-testing)

---

## 🚀 Fitur Baru

### 1. **Sistem Balance (Top-up Saldo)** 💰
Customer dapat mengisi saldo untuk digunakan berbelanja.

**Fitur:**
- ✅ Top-up saldo dengan berbagai metode pembayaran (Bank Transfer, E-Wallet, Cash)
- ✅ Riwayat transaksi saldo lengkap
- ✅ Tampilan saldo di dashboard dan kartu virtual
- ✅ Saldo otomatis terpotong saat checkout

**Halaman:**
- `/customer/balance` - Lihat saldo & riwayat transaksi
- `/customer/balance/topup` - Form top-up saldo

---

### 2. **Membership Level System** ⭐
Sistem tingkatan member dengan 3 level: **Nova → Stellar → Galaxy**

**Benefit Per Level:**

#### 🌟 **Nova** (Level 1)
- Min. Belanja: Rp 0
- Diskon: **5%**
- Poin Multiplier: **1x**
- Benefit:
  - Diskon 5% setiap pembelian
  - Akses katalog produk eksklusif
  - Notifikasi produk baru
  - Poin reward 1x

#### 💫 **Stellar** (Level 2)
- Min. Belanja: Rp 1.000.000
- Diskon: **10%**
- Poin Multiplier: **2x**
- Benefit:
  - Diskon 10% setiap pembelian
  - Early access produk baru
  - Voucher ulang tahun spesial
  - Poin reward 2x
  - Free shipping (event khusus)

#### 🌌 **Galaxy** (Level 3)
- Min. Belanja: Rp 5.000.000
- Diskon: **15%**
- Poin Multiplier: **3x**
- Benefit:
  - Diskon 15% setiap pembelian
  - VIP produk limited edition
  - Personal shopping assistant
  - Poin reward 3x
  - Free shipping unlimited
  - Event eksklusif member Galaxy
  - Voucher spesial bulanan

**Auto-upgrade:**
Level member otomatis naik berdasarkan total belanja!

**Halaman:**
- `/customer/membership` - Info membership & join
- `/customer/membership/exclusive` - Halaman khusus member

---

### 3. **Leaderboard System** 🏆
Sistem ranking customer berdasarkan total belanja.

**Fitur:**
- Top 50 customer dengan belanja terbanyak
- Tampilan peringkat user sendiri
- Voucher khusus untuk top ranking
- Badge untuk top 3 (🥇🥈🥉)

**Halaman:**
- `/customer/leaderboard` - Lihat & claim voucher

---

### 4. **Popular Products** 🔥
Menampilkan barang populer di halaman belanja.

**Kriteria:**
- Berdasarkan `sales_count` (jumlah terjual)
- Backup: `views_count` (jumlah dilihat)
- Auto-update setiap ada transaksi

---

### 5. **Profile Enhancement** 👤
Upgrade halaman profil dengan fitur lengkap.

**Fitur Baru:**
- ✅ Upload foto profil
- ✅ Edit data lengkap (nama, email, HP, alamat)
- ✅ Tanggal lahir & jenis kelamin
- ✅ Tampilkan badge membership level
- ✅ Ganti password

**Halaman:**
- `/customer/profile` - Edit profil & upload foto

---

### 6. **UI/UX Improvements** 🎨
- ❌ Navbar dashboard untuk customer dihapus
- ✅ Ukuran kartu virtual diperkecil (450px max-width)
- ✅ Responsive design untuk mobile
- ✅ Tampilan saldo di navbar dropdown
- ✅ Menu baru: Saldo, Membership, Leaderboard

---

## 📊 Migration & Database

### Migrations Baru

Jalankan migrations ini secara berurutan:

```bash
php artisan migrate
```

**File migrations:**
1. `2025_11_01_000001_add_customer_fields_to_users_table.php`
   - Menambah: `balance`, `birthdate`, `gender`, `profile_photo`

2. `2025_11_01_000002_create_balance_transactions_table.php`
   - Tabel untuk riwayat transaksi saldo

3. `2025_11_01_000003_create_membership_levels_table.php`
   - Tabel untuk level membership

4. `2025_11_01_000004_update_memberships_table.php`
   - Update tabel memberships dengan level & spending

5. `2025_11_01_000005_add_views_count_to_products_table.php`
   - Menambah `views_count` & `sales_count` ke products

6. `2025_11_01_000006_create_vouchers_table.php`
   - Tabel untuk voucher

7. `2025_11_01_000007_create_voucher_user_table.php`
   - Pivot table voucher dan user

---

## ⚙️ Setup & Instalasi

### 1. Run Migrations

```bash
php artisan migrate
```

### 2. Seed Membership Levels

```bash
php artisan db:seed --class=MembershipLevelSeeder
```

### 3. Create Storage Link (untuk upload foto)

```bash
php artisan storage:link
```

### 4. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 📁 Struktur File

### Controllers Baru

```
app/Http/Controllers/Customer/
├── BalanceController.php       # Manajemen saldo
├── ProfileController.php       # Edit profil & upload foto
├── MembershipController.php    # Membership system
└── LeaderboardController.php   # Leaderboard & voucher
```

### Models Baru

```
app/Models/
├── BalanceTransaction.php      # Model transaksi saldo
├── MembershipLevel.php         # Model level membership
├── Membership.php              # Model membership user (updated)
└── Voucher.php                 # Model voucher
```

### Views Baru

```
resources/views/customer/
├── balance/
│   ├── index.blade.php         # Halaman saldo & riwayat
│   ├── topup.blade.php         # Form top-up
│   └── confirmation.blade.php  # Konfirmasi top-up
├── membership/
│   ├── index.blade.php         # Info membership
│   ├── welcome.blade.php       # Welcome page member baru
│   └── exclusive.blade.php     # Halaman eksklusif member
├── leaderboard/
│   └── index.blade.php         # Leaderboard & voucher
└── profile/
    └── index.blade.php         # Profil (updated)
```

---

## 📖 Cara Penggunaan

### Untuk Customer

#### 1. Top-up Saldo
1. Klik menu **"Saldo"** di navbar
2. Klik tombol **"Top-up Saldo"**
3. Pilih nominal (atau input manual)
4. Pilih metode pembayaran
5. Klik **"Proses Top-up"**
6. Untuk demo: langsung approve

#### 2. Join Membership
1. Klik menu **"Membership"**
2. Klik tombol **"Gabung Jadi Member"**
3. Otomatis jadi member Nova
4. Level naik otomatis saat belanja

#### 3. Belanja & Naik Level
1. Belanja seperti biasa
2. Saldo otomatis terpotong
3. Total spending otomatis tercatat
4. Level naik otomatis jika memenuhi syarat
5. Notifikasi level up muncul setelah checkout

#### 4. Claim Voucher
1. Klik menu **"Leaderboard"**
2. Lihat posisi Anda di ranking
3. Scroll ke bawah untuk voucher
4. Klik **"Klaim Voucher"**

#### 5. Edit Profil & Upload Foto
1. Klik menu **"Profil"** atau dropdown user
2. Klik icon kamera untuk upload foto
3. Edit data di form
4. Klik **"Simpan Perubahan"**

---

## 🧪 Testing

### Test Flow Lengkap

#### 1. Register & Setup
```
1. Register sebagai customer baru
2. Login
3. Cek virtual card (belum ada saldo)
```

#### 2. Top-up Saldo
```
1. Pergi ke /customer/balance/topup
2. Pilih nominal Rp 1.000.000
3. Pilih metode: Bank Transfer
4. Submit & approve
5. Cek saldo bertambah
```

#### 3. Join Member & Belanja
```
1. Pergi ke /customer/membership
2. Klik "Gabung Jadi Member" → jadi Nova
3. Pergi ke /customer/shop
4. Tambah produk ke cart
5. Checkout dengan PIN
6. Cek saldo berkurang
7. Cek membership spending bertambah
```

#### 4. Test Level Up
```
1. Belanja senilai > Rp 1.000.000
2. Setelah checkout, cek notifikasi level up
3. Pergi ke /customer/membership
4. Lihat level berubah ke Stellar
```

#### 5. Test Leaderboard
```
1. Pergi ke /customer/leaderboard
2. Lihat ranking Anda
3. Klaim voucher yang tersedia
4. Cek di dropdown user → ada voucher
```

#### 6. Test Profile
```
1. Pergi ke /customer/profile
2. Upload foto profil
3. Edit data (nama, HP, alamat, dll)
4. Simpan
5. Cek foto muncul di navbar & profil
```

---

## 🎯 Checklist Acceptance Criteria

- [x] Customer bisa isi saldo dan saldo tampil di dashboard ✅
- [x] Halaman belanja menampilkan barang populer ✅
- [x] Navbar dashboard dihapus untuk role customer ✅
- [x] Ukuran kartu virtual diperkecil & tetap responsif ✅
- [x] Profil bisa upload foto & menampilkan data lengkap ✅
- [x] Sistem tingkatan member berjalan sesuai transaksi ✅
- [x] Leaderboard menampilkan data belanja tertinggi ✅
- [x] Badge membership ditampilkan di profil ✅

---

## 🐛 Known Issues & Solutions

### Issue 1: Storage Link Error
**Problem:** Foto tidak muncul setelah upload

**Solution:**
```bash
php artisan storage:link
```

### Issue 2: Migration Error (table already exists)
**Problem:** Error saat migrate, tabel sudah ada

**Solution:**
```bash
php artisan migrate:fresh --seed
# HATI-HATI: Ini akan hapus semua data!
```

### Issue 3: Level tidak auto-update
**Problem:** Level tidak naik meski sudah belanja

**Solution:** Pastikan method `addSpending()` dipanggil di ShopController

---

## 📞 Support

Jika ada masalah atau pertanyaan, silakan hubungi tim developer.

---

## 📝 Changelog

### Version 2.0.0 (November 2025)
- ✅ Added Balance System
- ✅ Added Membership Levels (Nova, Stellar, Galaxy)
- ✅ Added Leaderboard
- ✅ Added Voucher System
- ✅ Added Profile Upload Photo
- ✅ Added Popular Products
- ✅ Updated UI/UX Customer Portal
- ✅ Removed Dashboard from Customer Navbar

---

**Dibuat dengan ❤️ untuk Sellin Kasir**
