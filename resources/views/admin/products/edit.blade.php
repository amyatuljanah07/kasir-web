@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Produk</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $product->name) }}" 
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
                                  rows="3">{{ old('description', $product->description) }}</textarea>
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
                            <option value="Makanan" {{ old('category', $product->category) == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Minuman" {{ old('category', $product->category) == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Snack" {{ old('category', $product->category) == 'Snack' ? 'selected' : '' }}>Snack</option>
                            <option value="Alat Tulis" {{ old('category', $product->category) == 'Alat Tulis' ? 'selected' : '' }}>Alat Tulis</option>
                            <option value="Elektronik" {{ old('category', $product->category) == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                            <option value="Peralatan Rumah Tangga" {{ old('category', $product->category) == 'Peralatan Rumah Tangga' ? 'selected' : '' }}>Peralatan Rumah Tangga</option>
                            <option value="Lainnya" {{ old('category', $product->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>
                        
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px;">
                                <p class="text-muted small mb-0">Gambar saat ini</p>
                            </div>
                        @endif

                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image"
                               accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Upload gambar baru jika ingin mengganti. Format: JPG, PNG. Maksimal 2MB</small>
                    </div>

                    <!-- Member Exclusive Settings -->
                    <div class="mb-3">
                        <div class="card border-warning">
                            <div class="card-body">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           role="switch" 
                                           id="is_early_access" 
                                           name="is_early_access" 
                                           value="1"
                                           {{ old('is_early_access', $product->is_early_access) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_early_access">
                                        <strong>🌟 Produk Eksklusif Member</strong>
                                        <br><small class="text-muted">Hanya member yang dapat membeli produk ini</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Update Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Varian Produk</h5>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                    <i class="bi bi-plus-circle"></i> Tambah Varian
                </button>
            </div>
            <div class="card-body">
                @if($product->variants->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama Varian</th>
                                    <th>Barcode</th>
                                    <th>Stok</th>
                                    <th>Harga Jual</th>
                                    <th>Harga Modal</th>
                                    <th>Diskon</th>
                                    <th>Kadaluarsa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->variants as $variant)
                                <tr>
                                    <td>{{ $variant->variant_name }}</td>
                                    <td><small>{{ $variant->barcode }}</small></td>
                                    <td>
                                        <span class="badge bg-{{ $variant->stock > 0 ? 'success' : 'danger' }}">
                                            {{ $variant->stock }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($variant->price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($variant->cost_price, 0, ',', '.') }}</td>
                                    <td>{{ $variant->discount }}%</td>
                                    <td>
                                        @if($variant->expiry_date)
                                            <small class="{{ $variant->expiry_date < now() ? 'text-danger' : '' }}">
                                                {{ \Carbon\Carbon::parse($variant->expiry_date)->format('d/m/Y') }}
                                            </small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" 
                                                onclick="editVariant({{ $variant->id }}, '{{ $variant->variant_name }}', '{{ $variant->barcode }}', {{ $variant->stock }}, {{ $variant->price }}, {{ $variant->cost_price }}, {{ $variant->discount }}, '{{ $variant->expiry_date }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.variants.destroy', $variant) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus varian ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> Belum ada varian untuk produk ini. Silakan tambah varian (ukuran, warna, dll) beserta stok dan harganya.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Varian -->
<div class="modal fade" id="addVariantModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.variants.store', $product) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Varian Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="variant_name" class="form-label">Nama Varian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="variant_name" placeholder="Contoh: Merah, Size L, 500ml" required>
                        <small class="text-muted">Ukuran, warna, atau tipe lainnya</small>
                    </div>
                    <div class="mb-3">
                        <label for="barcode" class="form-label">Barcode</label>
                        <input type="text" class="form-control" name="barcode" placeholder="Opsional">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="stock" min="0" value="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="discount" class="form-label">Diskon (%)</label>
                            <input type="number" class="form-control" name="discount" min="0" max="100" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cost_price" class="form-label">Harga Modal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="cost_price" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga Jual <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="price" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="expiry_date" class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" class="form-control" name="expiry_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Varian</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Varian -->
<div class="modal fade" id="editVariantModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editVariantForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Varian Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_variant_name" class="form-label">Nama Varian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="variant_name" id="edit_variant_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_barcode" class="form-label">Barcode</label>
                        <input type="text" class="form-control" name="barcode" id="edit_barcode">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_stock" class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="stock" id="edit_stock" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_discount" class="form-label">Diskon (%)</label>
                            <input type="number" class="form-control" name="discount" id="edit_discount" min="0" max="100">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_cost_price" class="form-label">Harga Modal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="cost_price" id="edit_cost_price" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_price" class="form-label">Harga Jual <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="price" id="edit_price" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_expiry_date" class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" class="form-control" name="expiry_date" id="edit_expiry_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Varian</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editVariant(id, name, barcode, stock, price, costPrice, discount, expiryDate) {
    document.getElementById('editVariantForm').action = `/admin/variants/${id}`;
    document.getElementById('edit_variant_name').value = name;
    document.getElementById('edit_barcode').value = barcode || '';
    document.getElementById('edit_stock').value = stock;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_cost_price').value = costPrice;
    document.getElementById('edit_discount').value = discount;
    document.getElementById('edit_expiry_date').value = expiryDate || '';
    
    var modal = new bootstrap.Modal(document.getElementById('editVariantModal'));
    modal.show();
}
</script>
@endsection
