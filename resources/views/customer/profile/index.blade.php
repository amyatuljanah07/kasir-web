@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
<style>
    .profile-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }

    .profile-avatar-container {
        position: relative;
        width: 150px;
        margin: 0 auto 20px;
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .profile-avatar-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        color: white;
        font-weight: 700;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .upload-photo-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        transition: transform 0.2s;
    }

    .upload-photo-btn:hover {
        transform: scale(1.1);
    }

    .profile-name {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .profile-email {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 15px;
    }

    .membership-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 16px;
        color: white;
        margin-top: 10px;
    }

    .badge-nova { background: linear-gradient(135deg, #10b981, #059669); }
    .badge-stellar { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .badge-galaxy { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
    }

    .save-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #1f2937;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    @media (max-width: 768px) {
        .grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .alert {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }

    .delete-photo-btn {
        background: #ef4444;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        margin-top: 10px;
    }

    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 24px;
        font-weight: 700;
    }

    .loading-overlay.active {
        display: flex;
    }
</style>

<div class="loading-overlay" id="loadingOverlay">
    <div>
        <div style="text-align: center;">
            <div style="font-size: 60px; margin-bottom: 20px;">📸</div>
            <div>Mengupload foto...</div>
        </div>
    </div>
</div>

<div class="profile-container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Oops! Ada kesalahan:</strong>
            <ul style="margin: 10px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar-container">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="profile-avatar" id="profileImage">
                @else
                    <div class="profile-avatar-placeholder">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <label for="photoUpload" class="upload-photo-btn" title="Upload foto profil">
                    📷
                </label>
            </div>
            
            <h1 class="profile-name">{{ auth()->user()->name }}</h1>
            <p class="profile-email">{{ auth()->user()->email }}</p>
            
            @if(auth()->user()->membership)
                @php
                    $level = auth()->user()->membership->level;
                    $badgeClass = 'badge-' . strtolower($level->name);
                @endphp
                <div class="membership-badge {{ $badgeClass }}">
                    @if($level->slug === 'nova')
                        ⭐
                    @elseif($level->slug === 'stellar')
                        🌟
                    @else
                        🌌
                    @endif
                    {{ $level->name }} Member
                </div>
            @else
                <a href="{{ route('customer.membership') }}" class="membership-badge" style="background: #6b7280; text-decoration: none;">
                    Belum Member - Gabung Sekarang!
                </a>
            @endif
        </div>

        @if(auth()->user()->profile_photo)
        <form action="{{ route('customer.profile.delete-photo') }}" method="POST" style="text-align: center;">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-photo-btn" onclick="return confirm('Hapus foto profil?')">
                🗑️ Hapus Foto
            </button>
        </form>
        @endif

        <hr style="margin: 40px 0; border: none; border-top: 2px solid #e5e7eb;">

        <h2 class="section-title">📝 Edit Profil</h2>
        
        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
            @csrf
            @method('PUT')
            
            <!-- Hidden file input for photo upload -->
            <input type="file" name="profile_photo" id="photoUpload" accept="image/*" style="display: none;" onchange="previewAndSubmit(this)">

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">No. HP / WhatsApp</label>
                    <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}" placeholder="08xxxxxxxxxx">
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birthdate" class="form-control" value="{{ auth()->user()->birthdate?->format('Y-m-d') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select name="gender" class="form-control">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="male" {{ auth()->user()->gender === 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ auth()->user()->gender === 'female' ? 'selected' : '' }}>Perempuan</option>
                    <option value="other" {{ auth()->user()->gender === 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="address" class="form-control" rows="3" placeholder="Jalan, Kota, Provinsi, Kode Pos">{{ auth()->user()->address }}</textarea>
            </div>

            <button type="submit" class="save-btn">
                💾 Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
    // Preview and auto-submit photo
    function previewAndSubmit(input) {
        const file = input.files[0];
        if (file) {
            // Validate file size (max 2MB)
            if (file.size > 2048 * 1024) {
                alert('❌ Ukuran foto terlalu besar! Maksimal 2MB.\n\nUkuran file Anda: ' + (file.size / 1024 / 1024).toFixed(2) + ' MB');
                input.value = '';
                return;
            }

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('❌ File harus berupa gambar!\n\nTipe yang diizinkan: JPG, JPEG, PNG, GIF');
                input.value = '';
                return;
            }

            // Show loading
            document.getElementById('loadingOverlay').classList.add('active');

            // Preview image
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.getElementById('profileImage');
                if (img) {
                    img.src = event.target.result;
                } else {
                    // Replace placeholder with image
                    const placeholder = document.querySelector('.profile-avatar-placeholder');
                    if (placeholder) {
                        placeholder.outerHTML = `<img src="${event.target.result}" class="profile-avatar" id="profileImage">`;
                    }
                }
            };
            reader.readAsDataURL(file);

            // Auto-submit form after preview
            setTimeout(() => {
                document.getElementById('profileForm').submit();
            }, 800);
        }
    }
</script>
@endsection
