@extends('layouts.admin')

@section('content')
<div class="container py-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Katalog Barang</h2>
    </div>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="text-muted small">{{ $product->description }}</p>
                        <ul class="list-group">
                            @forelse($product->variants as $variant)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <strong>{{ $variant->variant_name }}</strong>
                                            <div class="text-muted small">
                                                <i class="bi bi-box-seam"></i> Stok: {{ $variant->stock }}
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            @if($variant->discount > 0)
                                                <div>
                                                    <small class="text-muted text-decoration-line-through">
                                                        Rp{{ number_format($variant->price,0,',','.') }}
                                                    </small>
                                                </div>
                                                <div class="text-success fw-bold">
                                                    Rp{{ number_format($variant->price * (1 - $variant->discount / 100),0,',','.') }}
                                                </div>
                                                <span class="badge bg-success">-{{ $variant->discount }}%</span>
                                            @else
                                                <div class="fw-bold">Rp{{ number_format($variant->price,0,',','.') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted">
                                    <small>Tidak ada stok tersedia</small>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada produk tersedia saat ini.
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection
