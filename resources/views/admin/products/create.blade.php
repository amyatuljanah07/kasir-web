@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Tambah Produk Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" 
                                name="category" 
                                required>
                            <option value="">Pilih Kategori</option>
                            <option value="Makanan" {{ old('category') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Minuman" {{ old('category') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Snack" {{ old('category') == 'Snack' ? 'selected' : '' }}>Snack</option>
                            <option value="Alat Tulis" {{ old('category') == 'Alat Tulis' ? 'selected' : '' }}>Alat Tulis</option>
                            <option value="Elektronik" {{ old('category') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                            <option value="Peralatan Rumah Tangga" {{ old('category') == 'Peralatan Rumah Tangga' ? 'selected' : '' }}>Peralatan Rumah Tangga</option>
                            <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image"
                               accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Catatan Penting</h6>
            <p class="mb-2"><strong>Setelah menambahkan produk, Anda bisa menambahkan varian produk:</strong></p>
            <ul class="mb-0">
                <li>Klik tombol <strong>"Edit"</strong> pada produk yang baru dibuat</li>
                <li>Di halaman edit, klik <strong>"Tambah Varian"</strong></li>
                <li>Isi detail varian seperti: nama varian (ukuran, warna, dll), stok, harga jual, harga modal, barcode, diskon, dan tanggal kadaluarsa</li>
                <li>Setiap produk bisa memiliki banyak varian dengan stok dan harga yang berbeda</li>
            </ul>
        </div>
    </div>
</div>
@endsection
