# Modul Pegawai (Kasir) - Aplikasi Kasir Laravel

## 📋 Deskripsi

Modul Pegawai (Kasir) adalah sistem Point of Sale (POS) lengkap untuk pegawai toko yang memungkinkan transaksi penjualan dengan scan barcode, manajemen keranjang, dan pencetakan struk otomatis.

## 🎯 Fitur Utama

### 1. Katalog Barang
- **Grid Display**: Tampilan card produk dengan gambar, nama, varian, harga, stok
- **Multiple Variants**: Menampilkan semua varian produk (ukuran, warna, dll)
- **Informasi Harga**: Harga normal dan harga setelah diskon
- **Badge Stok**: Indikator stok tersedia untuk setiap varian
- **Click to Add**: Klik produk untuk langsung tambah ke keranjang

### 2. Scan Barcode
- **Input Barcode**: Field khusus untuk scan/input barcode
- **Auto Scan**: Tekan Enter untuk langsung mencari barang
- **Validasi Real-time**: 
  - Cek stok tersedia
  - Validasi tanggal kadaluarsa
  - Notifikasi jika barang tidak ditemukan
- **Auto Focus**: Input barcode selalu fokus untuk scanning cepat

### 3. Keranjang Transaksi
- **Daftar Item**: Tampilan detail barang yang dibeli
- **Quantity Control**: Tombol +/- untuk ubah jumlah
- **Remove Item**: Hapus item dari keranjang
- **Auto Calculate**: Hitung subtotal dan total otomatis
- **Discount Display**: Tampilkan badge diskon pada item

### 4. Pembayaran
- **Metode Pembayaran**: Pilihan Tunai atau Debit
- **Input Nominal**: Field untuk input jumlah dibayar
- **Auto Change**: Hitung kembalian otomatis (untuk tunai)
- **Hide Change**: Sembunyikan kembalian untuk pembayaran debit
- **Validasi Payment**: Cek kecukupan pembayaran sebelum proses

### 5. Cetak Struk
- **Auto Generate PDF**: Generate struk dalam format PDF
- **Thermal Paper Format**: Format 80mm untuk printer thermal
- **Informasi Lengkap**:
  - Header toko (nama, alamat, telepon)
  - Nomor transaksi & tanggal
  - Nama kasir
  - Daftar barang lengkap
  - Total, dibayar, kembalian
  - Footer ucapan terima kasih
- **Auto Open**: Popup konfirmasi untuk cetak struk

### 6. Validasi Kadaluarsa
- **Check Expiry Date**: Validasi otomatis saat scan/tambah barang
- **Block Expired**: Blokir penjualan barang kadaluarsa
- **Alert Message**: Notifikasi jelas untuk barang expired

## 🛠️ Teknologi

- **Backend**: Laravel 12.34.0
- **Frontend**: Tailwind CSS 3.x
- **Icons**: Bootstrap Icons 1.11.3
- **HTTP Client**: Axios
- **PDF Generator**: barryvdh/laravel-dompdf 3.1

## 📁 Struktur File

```
app/
├── Http/
│   └── Controllers/
│       ├── PosController.php         # Controller utama POS
│       └── SaleController.php        # Controller transaksi & struk
├── Models/
│   ├── Product.php                   # Model produk
│   ├── ProductVariant.php            # Model varian produk
│   ├── Sale.php                      # Model transaksi
│   └── SaleItem.php                  # Model detail transaksi

resources/
└── views/
    └── pos/
        ├── index.blade.php           # Halaman utama POS
        └── receipt.blade.php         # Template struk PDF

routes/
└── web.php                           # Routes POS
```

## 🚀 Routes

```php
// Middleware: auth, role:pegawai|admin
Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
Route::post('/pos/scan', [PosController::class, 'scanBarcode'])->name('pos.scan');
Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
Route::get('/pos/receipt/{sale}', [SaleController::class, 'receipt'])->name('pos.receipt');
```

## 💾 Database Schema

### products
- id
- name (nama produk)
- description
- image
- timestamps

### product_variants
- id
- product_id (FK)
- variant_name (nama varian: ukuran, warna, dll)
- barcode (nullable, unique)
- stock (stok tersedia)
- price (harga jual)
- cost_price (harga modal)
- discount (persentase diskon)
- expiry_date (tanggal kadaluarsa, nullable)
- timestamps

### sales
- id
- user_id (FK - kasir)
- total (total transaksi)
- payment_method (tunai/debit)
- paid_amount (jumlah dibayar)
- timestamps

### sale_items
- id
- sale_id (FK)
- product_variant_id (FK)
- quantity (jumlah dibeli)
- price (harga saat transaksi)
- timestamps

## 🎨 UI/UX Features

### Notifikasi
- **Success**: Notifikasi hijau untuk aksi berhasil
- **Error**: Notifikasi merah untuk error/gagal
- **Info**: Notifikasi biru untuk informasi
- **Auto Dismiss**: Hilang otomatis setelah 3 detik
- **Slide Animation**: Animasi slide-in dari kanan

### Responsif
- **Desktop**: Grid 3 kolom untuk katalog
- **Tablet**: Grid 2 kolom
- **Mobile**: Grid 1-2 kolom, scroll vertical

### User Experience
- Auto-focus pada input barcode
- Keyboard shortcuts (Enter untuk scan)
- Hover effects pada produk
- Loading states
- Confirmation dialogs untuk aksi penting

## 🔒 Security & Validasi

### Backend Validation
- ✅ Validasi stok tersedia
- ✅ Validasi tanggal kadaluarsa
- ✅ Validasi kecukupan pembayaran
- ✅ Transaction locking untuk concurrency
- ✅ Database transaction untuk data integrity

### Frontend Validation
- ✅ Check keranjang kosong
- ✅ Validasi jumlah pembayaran
- ✅ Validasi quantity vs stok
- ✅ Confirmation sebelum checkout
- ✅ Confirmation sebelum reset

## 📝 Cara Penggunaan

### Login Sebagai Pegawai
```
Email: pegawai@kasir.com
Password: pegawai123
```

### Workflow Transaksi
1. **Login** sebagai pegawai
2. **Scan Barcode** atau klik produk dari katalog
3. **Atur Quantity** dengan tombol +/-
4. **Pilih Metode Pembayaran** (tunai/debit)
5. **Input Jumlah Dibayar**
6. **Klik Bayar** untuk proses transaksi
7. **Cetak Struk** (optional)

### Scan Barcode
1. Fokus pada field "Scan Barcode"
2. Scan barcode dengan scanner atau ketik manual
3. Tekan Enter atau klik tombol "Scan"
4. Barang otomatis ditambahkan ke keranjang

### Reset Transaksi
- Klik tombol "Reset Transaksi" untuk kosongkan keranjang
- Konfirmasi dialog akan muncul
- Semua item akan dihapus dari keranjang

## 🐛 Error Handling

### Pesan Error yang Ditampilkan
- "Barang tidak ditemukan" - Barcode tidak ada di database
- "Stok barang habis" - Stok = 0
- "Barang sudah kadaluarsa dan tidak dapat dijual" - expiry_date < now()
- "Stok tidak mencukupi" - Quantity melebihi stok
- "Jumlah pembayaran kurang dari total" - Payment < total (tunai)
- "Keranjang kosong!" - Checkout tanpa item
- "Masukkan jumlah pembayaran" - Paid amount kosong

## 🎁 Bonus Features

### Implemented
✅ Reset Transaksi - Kosongkan keranjang sebelum simpan
✅ Flash Notification - Notifikasi animasi untuk setiap aksi
✅ PDF Receipt - Struk otomatis dalam format PDF
✅ Thermal Format - Format 80mm untuk printer thermal
✅ Auto Calculate - Hitung total dan kembalian otomatis
✅ Discount Display - Tampilkan diskon pada item
✅ Stock Badge - Badge stok pada setiap produk
✅ Expired Validation - Validasi kadaluarsa real-time

### Future Enhancements
- ⏳ Barcode scanner hardware integration
- ⏳ Cash drawer integration
- ⏳ Transaction history untuk pegawai
- ⏳ Shift management
- ⏳ Quick product search
- ⏳ Customer display
- ⏳ Multi-language support

## 📊 API Endpoints

### POST /pos/scan
Scan barcode dan ambil data barang

**Request:**
```json
{
  "barcode": "1234567890"
}
```

**Response Success:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "product_name": "Energen",
    "variant_name": "Vanilla",
    "price": 10000,
    "discount": 10,
    "price_after_discount": 9000,
    "stock": 100
  }
}
```

**Response Error:**
```json
{
  "success": false,
  "message": "Barang tidak ditemukan"
}
```

### POST /pos/checkout
Proses checkout dan simpan transaksi

**Request:**
```json
{
  "items": [
    {
      "variant_id": 1,
      "quantity": 2
    }
  ],
  "payment_method": "tunai",
  "paid_amount": 20000
}
```

**Response Success:**
```json
{
  "success": true,
  "message": "Transaksi berhasil",
  "data": {
    "sale_id": 1,
    "total": 18000,
    "paid_amount": 20000,
    "change": 2000
  }
}
```

### GET /pos/receipt/{sale}
Generate dan download struk PDF

**Response:** PDF file download

## 🔧 Konfigurasi

### Dompdf Configuration
Package otomatis terkonfigurasi setelah install. Untuk custom config, publish dengan:
```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### Thermal Printer Setup
Ukuran paper thermal 80mm sudah dikonfigurasi di controller:
```php
$pdf->setPaper([0, 0, 226.77, 841.89], 'portrait'); // 80mm width
```

## 🐞 Troubleshooting

### Barcode Scanner Tidak Berfungsi
- Pastikan scanner dikonfigurasi dengan suffix "Enter"
- Test scanner dengan notepad, pastikan ada Enter setelah scan
- Cek apakah cursor fokus di field barcode input

### PDF Tidak Generate
- Pastikan package dompdf sudah terinstall: `composer require barryvdh/laravel-dompdf`
- Clear cache: `php artisan optimize:clear`
- Cek permission folder storage

### Stok Tidak Update
- Cek koneksi database
- Pastikan migration sudah dijalankan
- Cek constraint foreign key

## 📞 Support

Untuk pertanyaan atau issue, silakan hubungi tim development.

---

**Dibuat dengan ❤️ untuk Sellin Kasir**  
**Version:** 1.0.0  
**Last Updated:** 22 Oktober 2025
