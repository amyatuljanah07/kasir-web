# 🛒 Sistem E-Commerce - Dokumentasi

## 📋 Daftar Isi
1. [Gambaran Umum](#gambaran-umum)
2. [Fitur Utama](#fitur-utama)
3. [Alur Kerja](#alur-kerja)
4. [File yang Dibuat](#file-yang-dibuat)
5. [Cara Menggunakan](#cara-menggunakan)

---

## 🎯 Gambaran Umum

Sistem E-Commerce memungkinkan customer untuk:
- Browse produk di katalog online
- Menambahkan produk ke keranjang belanja
- Checkout dan memilih metode pembayaran
- Upload bukti pembayaran
- Tracking status pesanan

---

## ✨ Fitur Utama

### 1. Shopping Cart
- Tambah produk ke keranjang
- Update jumlah item
- Hapus item dari keranjang
- Kosongkan keranjang
- Badge notifikasi jumlah item di navbar
- **Otomatis diskon 5% untuk member**

### 2. Checkout
- Form alamat pengiriman
- Pilihan metode pembayaran:
  - Transfer Bank
  - Cash on Delivery (COD)
  - E-Wallet (GoPay/OVO/Dana)
- Catatan pesanan (opsional)
- Validasi stok sebelum checkout
- Generate order number otomatis (Format: `ORD-YYYYMMDD-XXX`)

### 3. Order Management
- Order history dengan filter
- Detail pesanan dengan timeline status
- Upload bukti pembayaran (untuk transfer/ewallet)
- Cancel pesanan (hanya untuk pending_payment dan paid)
- Tracking number untuk pesanan yang sudah dikirim

### 4. Order Status Flow
```
pending_payment → paid → processing → shipped → completed
                    ↓
                cancelled
```

---

## 🔄 Alur Kerja

### Customer Flow:

1. **Browse Katalog**
   - Customer login dengan role "customer"
   - Browse produk di `/catalog`
   - Lihat produk dengan varian dan harga

2. **Add to Cart**
   - Klik tombol "Tambah ke Keranjang" pada varian produk
   - Badge cart di navbar akan update otomatis
   - Sistem cek stok sebelum menambahkan

3. **View Cart**
   - Akses `/cart` untuk melihat keranjang
   - Update quantity (dengan validasi stok)
   - Hapus item yang tidak diinginkan
   - Lihat ringkasan: Subtotal, Diskon Member (5%), Total

4. **Checkout**
   - Klik "Lanjut ke Pembayaran"
   - Isi form alamat pengiriman
   - Pilih metode pembayaran
   - Review pesanan dan total
   - Klik "Buat Pesanan"

5. **Payment**
   - Untuk Transfer/E-wallet: Upload bukti pembayaran
   - Untuk COD: Tunggu barang datang

6. **Order Tracking**
   - Akses `/orders` untuk melihat semua pesanan
   - Klik detail pesanan untuk melihat status
   - Timeline status pesanan
   - Tracking number (jika sudah dikirim)

---

## 📁 File yang Dibuat

### Database Migrations:
- `2025_10_23_031458_create_carts_and_cart_items_tables.php`
- `2025_10_23_031631_create_orders_and_order_items_tables.php`

### Models:
- `app/Models/Cart.php` - Manage keranjang belanja
- `app/Models/CartItem.php` - Item di keranjang
- `app/Models/Order.php` - Data pesanan
- `app/Models/OrderItem.php` - Item dalam pesanan

### Controllers:
- `app/Http/Controllers/Customer/CartController.php`
  - `index()` - View cart
  - `add()` - Add to cart (AJAX)
  - `update()` - Update quantity (AJAX)
  - `remove()` - Remove item (AJAX)
  - `clear()` - Clear cart (AJAX)
  - `count()` - Get cart count (AJAX)

- `app/Http/Controllers/Customer/OrderController.php`
  - `checkout()` - Show checkout page
  - `store()` - Process checkout
  - `index()` - Order history
  - `show()` - Order detail
  - `uploadPayment()` - Upload payment proof
  - `cancel()` - Cancel order

### Views:
- `resources/views/catalog/index.blade.php` (Updated)
  - Added "Add to Cart" buttons
  - Cart badge in navbar
  - Stock display
  - AJAX functionality

- `resources/views/customer/cart/index.blade.php`
  - Cart items list
  - Quantity controls
  - Remove item buttons
  - Order summary
  - Member discount display

- `resources/views/customer/orders/checkout.blade.php`
  - Shipping form
  - Payment method selection
  - Order summary
  - Terms & conditions

- `resources/views/customer/orders/index.blade.php`
  - Order history list
  - Filters (status, payment_status, date range)
  - Order cards with products preview

- `resources/views/customer/orders/show.blade.php`
  - Order detail
  - Status timeline
  - Payment upload form
  - Tracking info
  - Cancel button

### Routes:
```php
// Shopping Cart
GET  /cart
POST /cart/add
PATCH /cart/{item}
DELETE /cart/{item}
DELETE /cart/clear
GET  /cart/count

// Orders
GET  /orders
GET  /orders/checkout
POST /orders/checkout
GET  /orders/{orderNumber}
POST /orders/{orderNumber}/payment
POST /orders/{orderNumber}/cancel
```

---

## 🚀 Cara Menggunakan

### Untuk Customer:

1. **Login sebagai Customer**
   - Email: customer@example.com
   - Password: password

2. **Mulai Belanja**
   - Klik menu "Katalog"
   - Browse produk yang tersedia
   - Klik "Tambah ke Keranjang" pada produk yang diinginkan

3. **Checkout**
   - Klik icon keranjang atau "Keranjang" di navbar
   - Review items dan quantities
   - Klik "Lanjut ke Pembayaran"
   - Isi alamat lengkap
   - Pilih metode pembayaran
   - Klik "Buat Pesanan"

4. **Bayar Pesanan**
   - Jika pilih Transfer/E-wallet:
     - Transfer ke rekening yang ditampilkan
     - Upload bukti transfer
   - Jika pilih COD: Siapkan uang tunai saat barang datang

5. **Track Pesanan**
   - Menu "Pesanan Saya" untuk melihat semua pesanan
   - Klik pesanan untuk melihat detail dan status

---

## 💡 Tips & Notes

### Member Benefits:
- Customer dengan status member mendapat diskon 5% otomatis
- Diskon langsung terapply di keranjang dan checkout
- Terlihat di ringkasan pembayaran

### Order Number Format:
- Format: `ORD-YYYYMMDD-XXX`
- Contoh: `ORD-20251023-001`
- Sequential per hari

### Stock Management:
- Stok berkurang saat order dibuat (bukan saat add to cart)
- Stok kembali jika order dibatalkan
- Validasi stok sebelum checkout

### Payment Proof:
- Max file size: 2MB
- Format: JPG, PNG
- Disimpan di `storage/app/public/payment_proofs/`

### Order Status:
- **pending_payment**: Menunggu pembayaran customer
- **paid**: Pembayaran sudah dikonfirmasi admin
- **processing**: Pesanan sedang disiapkan
- **shipped**: Pesanan sudah dikirim (ada tracking number)
- **completed**: Pesanan selesai diterima customer
- **cancelled**: Pesanan dibatalkan

### Cancel Order:
- Hanya bisa cancel jika status: `pending_payment` atau `paid`
- Tidak bisa cancel jika sudah `processing`, `shipped`, atau `completed`
- Stok akan dikembalikan otomatis

---

## 🔒 Security Features:
- Middleware `auth` dan `role:customer` untuk proteksi routes
- Validasi kepemilikan order (user hanya bisa lihat ordernya sendiri)
- Stock validation sebelum checkout
- Transaction rollback jika error saat checkout
- CSRF protection pada semua forms

---

## 📊 Database Schema:

### carts
- id
- user_id (FK → users)
- timestamps

### cart_items
- id
- cart_id (FK → carts, cascade)
- product_variant_id (FK → product_variants, cascade)
- quantity
- price (snapshot saat add to cart)
- timestamps

### orders
- id
- order_number (unique)
- user_id (FK → users)
- customer_name, customer_phone, customer_address (snapshot)
- subtotal, discount, shipping_cost, total
- payment_method (transfer/cod/ewallet)
- payment_status (pending/paid/failed)
- payment_proof (file path, nullable)
- status (enum 6 status)
- shipping_tracking_number (nullable)
- shipped_at, completed_at (nullable timestamps)
- notes
- timestamps

### order_items
- id
- order_id (FK → orders, cascade)
- product_variant_id (FK → product_variants, cascade)
- product_name, variant_name (snapshot)
- quantity
- price (per unit)
- subtotal
- timestamps

---

✅ **Sistem E-commerce siap digunakan!**

Untuk Admin Order Management, silakan lihat dokumentasi terpisah (coming soon).
