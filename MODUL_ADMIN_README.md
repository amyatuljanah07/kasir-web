# MODUL ADMIN - APLIKASI KASIR SELLIN

## 📋 Fitur yang Sudah Dibuat

### 1. Dashboard Penjualan (`/admin/dashboard`)
**Controller:** `App\Http\Controllers\Admin\DashboardController`
**View:** `resources/views/admin/dashboard/index.blade.php`

**Fitur:**
- ✅ Total penjualan harian, mingguan, dan bulanan
- ✅ Keuntungan bersih (total penjualan - modal)
- ✅ Grafik penjualan 7 hari terakhir (Chart.js)
- ✅ Statistik produk, stok menipis, dan user
- ✅ Top 5 produk terlaris bulan ini
- ✅ 10 transaksi terbaru

**Metrik yang Ditampilkan:**
- Penjualan hari ini + jumlah transaksi
- Penjualan minggu ini
- Penjualan bulan ini
- Keuntungan hari ini, minggu ini, bulan ini
- Total produk & produk stok menipis
- Total user aktif

---

### 2. Laporan Detail Transaksi (`/admin/reports`)
**Controller:** `App\Http\Controllers\Admin\ReportController`
**View:** `resources/views/admin/reports/index.blade.php`

**Fitur:** ✅ **LENGKAP - UPDATED 23 Oktober 2025**
- ✅ Tabel semua transaksi dengan: kode transaksi, tanggal, kasir, customer, total, metode pembayaran
- ✅ **FILTER RENTANG TANGGAL** - Filter transaksi berdasarkan tanggal mulai & tanggal akhir
- ✅ **FILTER CUSTOMER SPESIFIK** - Cari transaksi berdasarkan nama customer
- ✅ **FILTER KASIR** - Filter berdasarkan user/kasir yang melakukan transaksi
- ✅ **FILTER PRODUK SPESIFIK** - Filter transaksi yang mengandung produk tertentu
- ✅ **FILTER METODE PEMBAYARAN** - Filter berdasarkan cash, debit, credit, atau QRIS
- ✅ **EXPORT PDF** - Cetak/download laporan dalam format PDF (landscape A4)
- ✅ **INFO FILTER AKTIF** - Alert yang menampilkan filter yang sedang aktif
- ✅ Total transaksi, total penjualan, dan total keuntungan (terupdate sesuai filter)
- ✅ Badge warna untuk metode pembayaran (Cash, Debit, Credit, QRIS)
- ✅ Link ke struk PDF per transaksi

**PDF Export Fitur:**
- Format landscape A4
- Header dengan logo & info pencetakan
- Summary box dengan filter yang aktif
- Tabel transaksi dengan styling profesional
- Detail produk per transaksi (halaman terpisah)
- Grand total & footer otomatis
- Filename: `laporan-penjualan-YYYY-MM-DD-HHMMSS.pdf`

---

### 3. Manajemen Barang (`/admin/products`)
**Controller:** `App\Http\Controllers\Admin\ProductController`
**Views:** 
- `resources/views/admin/products/index.blade.php`
- `resources/views/admin/products/create.blade.php`
- `resources/views/admin/products/edit.blade.php`

**Fitur CRUD:**
- ✅ Create: Tambah produk baru (nama, deskripsi, gambar)
- ✅ Read: Tampilkan semua produk dengan varian
- ✅ Update: Edit produk
- ✅ Delete: Hapus produk beserta variannya

**Field Produk:**
- `name` - Nama produk
- `description` - Deskripsi produk
- `image` - Gambar produk

**Field Varian Produk:**
- `variant_name` - Nama varian (ukuran, warna, dll)
- `barcode` - Barcode unik
- `stock` - Jumlah stok
- `price` - Harga jual
- `cost_price` - Harga modal
- `discount` - Diskon (dalam Rupiah)
- `expiry_date` - Tanggal kadaluarsa

**Filter:**
- ✅ Tersedia (stok > 0 & tidak kadaluarsa)
- ✅ Habis stok (stok = 0)
- ✅ Kadaluarsa (expiry_date < hari ini)

**Status Otomatis:**
- ✅ Badge "Kadaluarsa" jika ada varian yang kadaluarsa
- ✅ Badge "Habis Stok" jika semua varian stok = 0
- ✅ Varian kadaluarsa tidak bisa dijual (validasi di POS)
- ✅ Warna badge stok: Hijau (>10), Kuning (1-10), Merah (0)

---

### 4. Manajemen User (`/admin/users`)
**Controller:** `App\Http\Controllers\Admin\UserManagementController`
**Views:**
- `resources/views/admin/users/index.blade.php` - Daftar user
- `resources/views/admin/users/create.blade.php` - Form tambah
- `resources/views/admin/users/edit.blade.php` - Form edit
- `resources/views/admin/users/show.blade.php` - Detail & riwayat transaksi

**Fitur:**
- ✅ Daftar user dengan kolom: nama, email, role, status member, status aktif, tanggal bergabung
- ✅ Filter berdasarkan role (admin, pegawai, customer, member)
- ✅ Filter berdasarkan status (aktif/nonaktif)
- ✅ Pencarian nama atau email
- ✅ Toggle status aktif/nonaktif user (PATCH request)
- ✅ CRUD lengkap user
- ✅ Detail user menampilkan:
  - Informasi user (nama, email, role, member, status)
  - Total transaksi & total pembelian
  - Riwayat transaksi lengkap dengan detail item

**Detail Riwayat Transaksi:**
- Kode transaksi & tanggal
- Daftar produk yang dibeli (nama, varian, qty, harga, diskon, subtotal)
- Total pembayaran, uang dibayar, kembalian

---

### 5. Laporan & Analitik
**Terintegrasi di Dashboard & Laporan**

**Fitur:**
- ✅ Total transaksi per periode (hari, minggu, bulan)
- ✅ Total keuntungan per periode
- ✅ Grafik penjualan 7 hari terakhir (Line Chart)
- ✅ Top 5 produk terlaris bulan ini
- ✅ Metrik stok produk menipis

**Perhitungan Keuntungan:**
```php
Keuntungan = (Harga Jual - Harga Modal) × Quantity
```

---

## 🗂️ Struktur Database

### Tabel: `products`
```sql
- id (Primary Key)
- name (VARCHAR)
- description (TEXT, nullable)
- image (VARCHAR, nullable)
- created_at, updated_at
```

### Tabel: `product_variants`
```sql
- id (Primary Key)
- product_id (Foreign Key → products)
- variant_name (VARCHAR)
- barcode (VARCHAR, unique)
- stock (INTEGER, default 0)
- price (DECIMAL 10,2)
- discount (DECIMAL 10,2, default 0)
- cost_price (DECIMAL 10,2)
- expiry_date (DATE, nullable)
- created_at, updated_at
```

### Tabel: `users`
```sql
- id (Primary Key)
- name (VARCHAR)
- email (VARCHAR, unique)
- password (VARCHAR, hashed)
- role_id (Foreign Key → roles)
- is_member (BOOLEAN, default false)
- is_active (BOOLEAN, default true) ✅ BARU
- created_at, updated_at
```

### Tabel: `sales`
```sql
- id (Primary Key)
- user_id (Foreign Key → users) - Kasir
- customer_name (VARCHAR, nullable)
- total (DECIMAL 10,2)
- discount (DECIMAL 10,2, default 0)
- payment_method (VARCHAR: cash, debit, credit)
- paid_amount (DECIMAL 10,2)
- change (DECIMAL 10,2)
- barcode (VARCHAR, unique)
- created_at, updated_at
```

### Tabel: `sale_items`
```sql
- id (Primary Key)
- sale_id (Foreign Key → sales)
- product_variant_id (Foreign Key → product_variants)
- quantity (INTEGER)
- price (DECIMAL 10,2)
- discount (DECIMAL 10,2, default 0)
- subtotal (DECIMAL 10,2)
- created_at, updated_at
```

### Tabel: `roles`
```sql
- id (Primary Key)
- name (VARCHAR: admin, pegawai, customer)
- created_at, updated_at
```

---

## 🛣️ Routes (Prefix: `/admin`, Middleware: `auth`, `role:admin`)

```php
// Dashboard
GET  /admin/dashboard

// Manajemen Produk
GET    /admin/products
GET    /admin/products/create
POST   /admin/products
GET    /admin/products/{product}
GET    /admin/products/{product}/edit
PUT    /admin/products/{product}
DELETE /admin/products/{product}

// Laporan
GET  /admin/reports                    // Laporan dengan filter
GET  /admin/reports/export             // Export PDF ✅ BARU

// Manajemen User
GET    /admin/users
GET    /admin/users/create
POST   /admin/users
GET    /admin/users/{user}
GET    /admin/users/{user}/edit
PUT    /admin/users/{user}
DELETE /admin/users/{user}
PATCH  /admin/users/{user}/toggle-status

// Detail User Orders
GET  /admin/users/{user}/orders
```

---

## 🎨 UI/UX

**Framework CSS:** Bootstrap 5.3.3
**Icons:** Bootstrap Icons 1.11.3
**Charts:** Chart.js 4.4.0

**Fitur UI:**
- ✅ Card metrik dengan icon & warna badge
- ✅ Responsive table dengan hover effect
- ✅ Filter & search form
- ✅ Alert notification (success/error)
- ✅ Dropdown menu navigasi admin
- ✅ Badge status dinamis (role, member, aktif, stok)
- ✅ Grafik line chart interaktif
- ✅ Layout admin terpisah (`layouts/admin.blade.php`)

---

## 📊 Grafik Penjualan (Chart.js)

**Lokasi:** Dashboard (`/admin/dashboard`)

**Tipe:** Line Chart
**Data:** Penjualan harian 7 hari terakhir
**Format:** 
- X-axis: Tanggal (format: dd MMM)
- Y-axis: Total penjualan (Rupiah)

**Konfigurasi:**
- Responsive & smooth curve
- Tooltip dengan format Rupiah
- Fill area bawah grafik

---

## 🔒 Middleware & Keamanan

**Middleware:**
- `auth` - User harus login
- `role:admin` - Hanya user dengan role "admin"

**Middleware Custom:** `App\Http\Middleware\RoleMiddleware`
```php
// Cek apakah user login
if (!auth()->check()) return redirect('/login');

// Cek role user
if (auth()->user()->role->name !== $role) abort(403);
```

**Validasi:**
- User tidak bisa menghapus akun sendiri
- Password confirmation saat create/update
- Unique email validation
- Required fields validation

---

## 📝 Cara Menggunakan

### 1. Login sebagai Admin
```
Email: admin@kasir.com
Password: admin123
```

### 2. Akses Dashboard
Navigate ke: `http://127.0.0.1:8000/admin/dashboard`

### 3. Manajemen Produk
- Tambah produk → Klik "Tambah Produk"
- Edit produk → Klik tombol "Edit"
- Filter produk → Pilih filter: Tersedia, Habis Stok, atau Kadaluarsa
- Status kadaluarsa akan otomatis muncul

### 4. Manajemen User
- Lihat semua user → `/admin/users`
- Filter by role/status
- Toggle aktif/nonaktif → Klik badge status
- Lihat riwayat transaksi user → Klik tombol "Detail"

### 5. Laporan
- Lihat semua transaksi → `/admin/reports`
- Klik "Detail" untuk melihat pembelian user spesifik

---

## ✅ Checklist Fitur

- [x] Dashboard dengan metrik penjualan
- [x] Keuntungan bersih (harga jual - modal)
- [x] Grafik penjualan Chart.js
- [x] Laporan transaksi lengkap
- [x] **Filter laporan berdasarkan rentang tanggal** ✅ BARU
- [x] **Filter laporan berdasarkan customer spesifik** ✅ BARU
- [x] **Filter laporan berdasarkan kasir** ✅ BARU
- [x] **Filter laporan berdasarkan produk** ✅ BARU
- [x] **Filter laporan berdasarkan metode pembayaran** ✅ BARU
- [x] **Export laporan ke PDF** ✅ BARU
- [x] Detail pembelian per user
- [x] CRUD Produk
- [x] Filter produk (tersedia, habis stok, kadaluarsa)
- [x] Status kadaluarsa otomatis
- [x] CRUD User
- [x] Filter user (role & status)
- [x] Toggle aktif/nonaktif user
- [x] Riwayat transaksi user
- [x] Relasi Eloquent lengkap
- [x] Middleware role admin
- [x] UI Bootstrap responsive

---

## 🚀 Next Steps (Opsional)

1. ~~Export laporan ke Excel/PDF~~ ✅ DONE (PDF)
2. Export laporan ke Excel (format XLS/XLSX)
3. Notifikasi stok menipis
4. Notifikasi produk akan kadaluarsa (7 hari lagi)
5. Grafik keuntungan per kategori
6. ~~Filter tanggal custom di laporan~~ ✅ DONE
7. Backup database otomatis
8. Activity log admin
9. Print preview sebelum export PDF
10. Email laporan berkala ke admin

---

**Dibuat pada:** 22 Oktober 2025  
**Update Terakhir:** 23 Oktober 2025 - Fitur Laporan Lengkap + Export PDF  
**Framework:** Laravel 12.34.0  
**PHP:** 8.2.28
