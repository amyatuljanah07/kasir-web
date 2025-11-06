# 📸 Perbaikan Upload Foto Profil

## Masalah yang Diperbaiki
User tidak bisa upload foto profil - foto tidak muncul dan tidak tersimpan di database.

## Solusi yang Diterapkan

### 1. **Perbaikan Form Structure** ✅
- **Masalah Sebelumnya**: Ada 2 form terpisah yang submit ke endpoint sama
  - Form 1: Upload foto saja (form tersembunyi)
  - Form 2: Edit profil tanpa foto
- **Solusi**: Gabungkan menjadi 1 form dengan `enctype="multipart/form-data"`
  ```blade
  <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
      <input type="file" name="profile_photo" id="photoUpload" accept="image/*" style="display: none;">
      <!-- Form fields lainnya -->
  </form>
  ```

### 2. **Perbaikan Controller Logic** ✅
- **Masalah Sebelumnya**: Field `name` dan `email` required, padahal saat upload foto field ini tidak ter-submit
- **Solusi**: 
  - Ubah validasi `name` dan `email` dari `required` menjadi `nullable`
  - Pisahkan logika upload foto vs update profil
  - Tambahkan pesan sukses yang berbeda untuk upload foto
  ```php
  if ($request->hasFile('profile_photo')) {
      // Delete old photo
      if ($user->profile_photo) {
          Storage::disk('public')->delete($user->profile_photo);
      }
      
      // Store new photo
      $path = $file->store('profile-photos', 'public');
      $user->profile_photo = $path;
      $user->save();
      
      return back()->with('success', 'Foto profil berhasil diupdate! 📸');
  }
  ```

### 3. **Persiapan Storage** ✅
- Buat direktori `storage/app/public/profile-photos/`
- Set permissions: `chmod -R 775`
- Verifikasi symbolic link `public/storage` sudah terhubung ke `storage/app/public`

### 4. **Validasi File Upload** ✅
- **Client-side validation** (JavaScript):
  - Maksimal ukuran file: 2MB
  - Tipe file yang diizinkan: JPG, JPEG, PNG, GIF
  - Alert jika file tidak valid
- **Server-side validation** (Controller):
  ```php
  'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
  ```

### 5. **UX Improvements** ✅
- ✅ Preview foto sebelum submit (real-time)
- ✅ Loading overlay saat upload: "📸 Mengupload foto..."
- ✅ Auto-submit form setelah pilih foto (tidak perlu klik tombol simpan)
- ✅ Pesan error yang jelas jika ada masalah validasi
- ✅ Replace placeholder dengan foto setelah upload

### 6. **Error Handling** ✅
- Tampilkan validation errors di UI
- Pesan error yang user-friendly dengan emoji
- Loading indicator untuk feedback visual

## Cara Menggunakan

### Upload Foto Profil Baru:
1. Buka halaman profil: `/customer/profile`
2. Klik icon kamera (📷) di pojok kanan bawah foto profil
3. Pilih foto dari komputer (max 2MB, format JPG/PNG/GIF)
4. Foto akan otomatis di-preview dan diupload
5. Tunggu loading selesai
6. Halaman reload dengan foto profil baru

### Hapus Foto Profil:
1. Klik tombol "🗑️ Hapus Foto" di bawah foto profil
2. Konfirmasi penghapusan
3. Foto akan terhapus dan kembali ke placeholder

## File yang Dimodifikasi

### 1. `app/Http/Controllers/Customer/ProfileController.php`
- Ubah validasi `name` & `email` jadi nullable
- Pisahkan logik upload foto dan update profil
- Tambahkan pesan sukses berbeda
- Save user setelah upload foto

### 2. `resources/views/customer/profile/index.blade.php`
- Gabungkan 2 form jadi 1
- Tambahkan `enctype="multipart/form-data"`
- Tambahkan loading overlay
- Perbaiki JavaScript validation
- Auto-submit form setelah pilih foto
- Tampilkan validation errors

### 3. Storage Setup
- `storage/app/public/profile-photos/` - direktori foto
- `public/storage` → symlink ke `storage/app/public`

## Testing

### Test Manual:
1. Login sebagai customer (Oca)
2. Buka `/customer/profile`
3. Upload foto (pilih file JPG/PNG < 2MB)
4. Cek apakah foto muncul
5. Refresh halaman - foto harus tetap ada
6. Cek database: `users.profile_photo` harus terisi path
7. Cek storage: file harus ada di `storage/app/public/profile-photos/`
8. Cek public: foto harus bisa diakses via `public/storage/profile-photos/`

### Test dengan Tinker:
```bash
php artisan tinker

$user = User::find(2); // Oca
echo $user->profile_photo; // Harus ada path
echo $user->getProfilePhotoUrlAttribute(); // Harus return URL
```

## Teknologi yang Digunakan
- **Laravel Storage**: `Storage::disk('public')`
- **File Upload**: `store('profile-photos', 'public')`
- **Symbolic Link**: `php artisan storage:link`
- **JavaScript**: FileReader API untuk preview
- **Validation**: Laravel request validation

## Troubleshooting

### Foto tidak muncul setelah upload:
1. Cek symbolic link: `ls -la public/storage`
2. Cek permissions: `ls -la storage/app/public/profile-photos`
3. Cek path di database: `SELECT profile_photo FROM users WHERE id = 2`
4. Cek file fisik: `ls storage/app/public/profile-photos/`

### Error "The file could not be uploaded":
1. Cek ukuran file < 2MB
2. Cek format file (JPG/PNG/GIF)
3. Cek permissions direktori `storage/app/public/profile-photos`
4. Cek `php.ini`: `upload_max_filesize` dan `post_max_size`

### Foto lama tidak terhapus:
- Controller sudah handle delete old photo sebelum upload yang baru
- Cek logs: `tail -f storage/logs/laravel.log`

## Status
✅ **FIXED & TESTED** - Upload foto profil sekarang berfungsi dengan baik!

---
*Updated: November 1, 2025*
*Developer: GitHub Copilot*
