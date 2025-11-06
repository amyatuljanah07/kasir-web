@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Laporan Transaksi</h2>
            <p class="text-muted mb-0">Detail semua transaksi penjualan dengan filter lengkap</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-funnel me-2"></i>Filter Laporan
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" 
                           value="{{ request('start_date') }}" placeholder="Pilih tanggal">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" 
                           value="{{ request('end_date') }}" placeholder="Pilih tanggal">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Kasir</label>
                    <select name="user_id" class="form-select">
                        <option value="">Semua Kasir</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ ucfirst($user->role->name) }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Produk</label>
                    <select name="product_id" class="form-select">
                        <option value="">Semua Produk</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Metode Pembayaran</label>
                    <select name="payment_method" class="form-select">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="debit" {{ request('payment_method') == 'debit' ? 'selected' : '' }}>Debit</option>
                        <option value="credit" {{ request('payment_method') == 'credit' ? 'selected' : '' }}>Credit</option>
                        <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.reports') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                    <button type="submit" formaction="{{ route('admin.reports.export') }}" 
                            formtarget="_blank" class="btn btn-success">
                        <i class="bi bi-file-pdf"></i> Export PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Metrik Singkat -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                            <i class="bi bi-receipt text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Total Transaksi</p>
                            <h4 class="fw-bold mb-0">{{ $sales->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                            <i class="bi bi-cash-stack text-success fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Total Penjualan</p>
                            <h4 class="fw-bold mb-0">Rp{{ number_format($sales->sum('total'), 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                            <i class="bi bi-graph-up-arrow text-warning fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Total Keuntungan</p>
                            <h4 class="fw-bold mb-0 text-success">Rp{{ number_format($totalKeuntungan, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Filter Aktif -->
    @if(request()->anyFilled(['start_date', 'end_date', 'user_id', 'product_id', 'payment_method']))
    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Filter Aktif:</strong>
        @if(request('start_date') && request('end_date'))
            Periode {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
        @endif
        @if(request('user_id'))
            | Kasir: {{ $users->find(request('user_id'))->name }}
        @endif
        @if(request('product_id'))
            | Produk: {{ $products->find(request('product_id'))->name }}
        @endif
        @if(request('payment_method'))
            | Pembayaran: {{ ucfirst(request('payment_method')) }}
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Tabel Transaksi -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="fw-bold mb-0">Daftar Transaksi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal & Waktu</th>
                            <th>Kasir</th>
                            <th>Items</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Metode Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $index => $sale)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $sale->barcode }}</span>
                            </td>
                            <td>
                                <div>{{ $sale->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $sale->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                @if($sale->cashier)
                                    <span class="text-info fw-semibold">{{ $sale->cashier->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $sale->items->count() }} item</span>
                            </td>
                            <td>
                                <strong class="text-success">Rp{{ number_format($sale->total, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                @if($sale->discount > 0)
                                    <span class="badge bg-danger">-Rp{{ number_format($sale->discount, 0, ',', '.') }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    @if($sale->payment_method == 'cash') bg-success
                                    @elseif($sale->payment_method == 'debit') bg-primary
                                    @elseif($sale->payment_method == 'credit') bg-warning
                                    @else bg-info
                                    @endif">
                                    {{ ucfirst($sale->payment_method) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pos.receipt', $sale) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Cetak Struk" target="_blank">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                @if(request()->hasAny(['start_date', 'end_date', 'user_id', 'product_id', 'payment_method']))
                                    Tidak ada transaksi yang sesuai dengan filter
                                @else
                                    Belum ada transaksi
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
