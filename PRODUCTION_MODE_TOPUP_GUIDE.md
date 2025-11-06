# 🏭 PRODUCTION MODE - TOP-UP VERIFICATION SYSTEM

## 📌 Overview
Sistem verifikasi top-up untuk mode produksi yang mengharuskan admin memverifikasi bukti transfer sebelum saldo customer diaktifkan.

---

## 🎯 Features Implemented

### 1. **Customer Side**
- ✅ Upload bukti pembayaran (JPEG/PNG/JPG, max 2MB)
- ✅ Preview gambar sebelum upload
- ✅ Status "Pending" setelah submit
- ✅ Tampilan riwayat dengan status (Pending/Completed/Rejected)
- ✅ Alasan penolakan ditampilkan jika rejected

### 2. **Admin Side**
- ✅ Dashboard verifikasi dengan 2 tab (Pending & History)
- ✅ Lihat bukti transfer dalam modal/new tab
- ✅ Approve top-up dengan update saldo otomatis
- ✅ Reject top-up dengan wajib isi alasan
- ✅ DB Transaction untuk data consistency
- ✅ Menu navigasi "Top-Up Verification"

---

## 🗄️ Database Changes

### Migration: `2025_11_01_042603_add_production_fields_to_balance_transactions_table.php`

**New Columns:**
```php
$table->string('proof_of_payment')->nullable();       // Path bukti transfer
$table->foreignId('verified_by')->nullable()->constrained('users'); // Admin verifikator
$table->string('rejection_reason')->nullable();       // Alasan reject
$table->timestamp('verified_at')->nullable();         // Waktu verifikasi
```

**Status Workflow:**
- `pending` → Customer baru submit, menunggu verifikasi
- `completed` → Admin approve, saldo sudah masuk
- `rejected` → Admin reject, perlu upload ulang

---

## 📂 Files Modified/Created

### **Controllers**

#### `app/Http/Controllers/Customer/BalanceController.php`
**Changes:**
```php
// Validate file upload
'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048'

// Store file
$path = $request->file('proof_of_payment')->store('payment-proofs', 'public');

// Set status to pending
'status' => 'pending'
```

#### `app/Http/Controllers/Admin/TopUpController.php` (NEW)
**Methods:**
- `index()` - List pending & completed top-ups
- `approve($id)` - Approve & add balance to user
- `reject(Request, $id)` - Reject with reason

### **Models**

#### `app/Models/BalanceTransaction.php`
**Added:**
```php
protected $fillable = [
    // ... existing fields
    'proof_of_payment',
    'verified_by',
    'rejection_reason',
    'verified_at',
];

protected $casts = [
    // ... existing casts
    'verified_at' => 'datetime',
];

public function verifier() {
    return $this->belongsTo(User::class, 'verified_by');
}
```

### **Views**

#### `resources/views/customer/balance/topup.blade.php`
**Added:**
- File upload input (required)
- Image preview dengan JavaScript
- Validation client-side (ukuran file)

#### `resources/views/customer/balance/confirmation.blade.php` (REBUILT)
**Changed:**
- ⏳ Icon instead of ✅
- "Permintaan Diterima" instead of "Berhasil"
- Warning box tentang waktu verifikasi 5-15 menit
- Link lihat bukti transfer
- Removed demo approve button

#### `resources/views/customer/balance/index.blade.php`
**Added:**
- Badge status: Pending (yellow), Completed (green), Rejected (red)
- Display rejection reason

#### `resources/views/admin/topup/index.blade.php` (NEW)
**Features:**
- Tab switching (Pending | History)
- Table dengan thumbnail bukti transfer
- Approve button (green)
- Reject button dengan modal input alasan
- Pagination untuk kedua tab

#### `resources/views/layouts/admin.blade.php`
**Added:**
- Menu item "Top-Up Verification" dengan icon credit-card
- Active state routing

### **Routes**

#### `routes/web.php`
**Added in Admin Routes:**
```php
Route::get('topup', [TopUpController::class, 'index'])->name('topup.index');
Route::post('topup/{id}/approve', [TopUpController::class, 'approve'])->name('topup.approve');
Route::post('topup/{id}/reject', [TopUpController::class, 'reject'])->name('topup.reject');
```

---

## 🔄 Workflow

### **Customer Workflow:**
1. Customer buka halaman Top-Up
2. Pilih metode pembayaran
3. Upload bukti transfer (wajib)
4. Submit request
5. Redirect ke confirmation page (status: pending)
6. Cek status di halaman "Saldo Saya"
7. Tunggu 5-15 menit untuk verifikasi

### **Admin Workflow:**
1. Admin login & buka menu "Top-Up Verification"
2. Lihat daftar pending requests
3. Klik "Lihat Bukti" untuk cek transfer
4. **APPROVE:**
   - Klik "✅ Approve"
   - Saldo customer otomatis bertambah
   - Status berubah → completed
   - Transaksi masuk ke tab History
5. **REJECT:**
   - Klik "❌ Tolak"
   - Modal muncul, wajib isi alasan
   - Status berubah → rejected
   - Customer lihat alasan di riwayat

---

## 💾 Storage Configuration

### **Public Disk** (`storage/public/payment-proofs/`)
File bukti transfer disimpan di:
```
storage/app/public/payment-proofs/xxxxx.jpg
```

**Access via:**
```php
asset('storage/payment-proofs/xxxxx.jpg')
```

**Symbolic Link:**
```bash
php artisan storage:link
```
Link: `public/storage` → `storage/app/public`

---

## 🔐 Security & Validation

### **Customer Upload:**
- Wajib upload file (required)
- Hanya image: JPEG, PNG, JPG
- Max size: 2MB (2048 KB)
- Preview before submit (JavaScript)

### **Admin Verification:**
- Only admin role can access
- DB Transaction untuk approve (update balance + transaction)
- Rejection reason wajib diisi (max 500 chars)
- Check status sebelum proses (prevent double approve)

---

## 🧪 Testing Checklist

### **Customer:**
- [ ] Upload file berhasil dengan preview
- [ ] Validation error jika file > 2MB
- [ ] Validation error jika bukan image
- [ ] Status pending muncul di confirmation
- [ ] Status pending muncul di riwayat
- [ ] Bukti transfer bisa dibuka di new tab
- [ ] Rejection reason muncul jika ditolak

### **Admin:**
- [ ] Menu "Top-Up Verification" muncul di sidebar
- [ ] Tab pending menampilkan daftar yang benar
- [ ] Tab history menampilkan completed & rejected
- [ ] Link bukti transfer bisa dibuka
- [ ] Approve berhasil tambah saldo customer
- [ ] Reject berhasil dengan alasan
- [ ] Pagination berfungsi
- [ ] Badge status (pending/completed/rejected) sesuai

### **Database:**
- [ ] proof_of_payment tersimpan dengan path benar
- [ ] verified_by terisi dengan admin ID
- [ ] verified_at terisi timestamp
- [ ] rejection_reason terisi jika rejected
- [ ] balance_after terisi saat approve
- [ ] User.balance bertambah saat approve

---

## 📊 Database Queries

### **Get Pending Top-Ups:**
```php
BalanceTransaction::where('type', 'credit')
    ->where('status', 'pending')
    ->with('user')
    ->orderBy('created_at', 'desc')
    ->paginate(20);
```

### **Get Verification History:**
```php
BalanceTransaction::where('type', 'credit')
    ->whereIn('status', ['completed', 'rejected'])
    ->with(['user', 'verifier'])
    ->orderBy('verified_at', 'desc')
    ->paginate(10);
```

### **Approve with Transaction:**
```php
DB::beginTransaction();
try {
    $user->balance += $transaction->amount;
    $user->save();
    
    $transaction->update([
        'status' => 'completed',
        'balance_after' => $user->balance,
        'completed_at' => now(),
        'verified_by' => auth()->id(),
        'verified_at' => now(),
    ]);
    
    DB::commit();
} catch (\Exception $e) {
    DB::rollback();
}
```

---

## 🚀 Next Steps (Optional Enhancements)

### **Notifications:**
- [ ] Email notification saat approved
- [ ] Email notification saat rejected
- [ ] Real-time notification (Pusher/WebSocket)

### **Advanced Features:**
- [ ] Batch approve multiple transactions
- [ ] Export report (Excel/PDF)
- [ ] Auto-reject after 24 hours
- [ ] Upload multiple proofs (receipt + mutation)
- [ ] OCR validation for bank transfer
- [ ] Webhook to payment gateway

### **Analytics:**
- [ ] Daily verification stats
- [ ] Average verification time
- [ ] Rejection rate by reason
- [ ] Top-up amount trends

---

## 📝 Notes

1. **Demo vs Production:**
   - Demo: Auto-approve saat submit
   - Production: Wajib upload bukti → pending → admin verify

2. **Balance Source:**
   - Single source of truth: `users.balance`
   - NOT `virtual_cards.balance` (deprecated)

3. **File Upload:**
   - Stored in `storage/app/public/payment-proofs/`
   - Accessible via `public/storage/payment-proofs/`
   - Requires `php artisan storage:link`

4. **Status Management:**
   - Only 1 active status at a time
   - Transition: pending → completed/rejected (final)
   - Cannot re-approve rejected transactions

---

## 👨‍💻 Developer: AI Assistant
## 📅 Implemented: {{ date('Y-m-d') }}
## 🏷️ Version: 1.0 - Production Mode
