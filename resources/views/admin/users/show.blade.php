@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail User & Riwayat Transaksi</h2>
            <p class="text-muted mb-0">{{ $user->name }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-3 mb-4">
        <!-- Informasi User -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                        <i class="bi bi-person fs-1 text-primary"></i>
                    </div>
                    <h4 class="fw-bold">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge 
                            @if($user->role->name == 'admin') bg-danger
                            @elseif($user->role->name == 'pegawai') bg-primary
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($user->role->name) }}
                        </span>
                        
                        @if($user->is_member)
                        <span class="badge bg-warning">Member</span>
                        @endif
                        
                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <hr>

                    <div class="row text-start">
                        <div class="col-12 mb-2">
                            <small class="text-muted">Bergabung sejak</small>
                            <div class="fw-semibold">{{ $user->created_at->format('d F Y') }}</div>
                        </div>
                        <div class="col-12 mb-2">
                            <small class="text-muted">Total Transaksi</small>
                            <div class="fw-semibold">{{ $totalTransactions }} transaksi</div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Total Pembelian</small>
                            <div class="fw-semibold text-success">Rp{{ number_format($totalSpent, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold mb-0">Riwayat Transaksi</h5>
                    <ul class="nav nav-tabs mt-3" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#orders-tab">
                                <i class="bi bi-cart"></i> Order Online ({{ $user->orders->count() }})
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sales-tab">
                                <i class="bi bi-receipt"></i> Transaksi POS ({{ $user->sales->count() }})
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Orders Tab -->
                        <div class="tab-pane fade show active" id="orders-tab">
                            @forelse($user->orders as $order)
                            <div class="card mb-3 border">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-info">{{ $order->order_number }}</span>
                                            <small class="text-muted ms-2">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <div>
                                            <span class="badge 
                                                @if($order->status == 'pending') bg-warning
                                                @elseif($order->status == 'paid') bg-info
                                                @elseif($order->status == 'verified') bg-success
                                                @elseif($order->status == 'completed') bg-primary
                                                @else bg-danger
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Detail Barang -->
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Produk</th>
                                                    <th>Varian</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-end">Harga</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                <tr>
                                                    <td>{{ $item->variant->product->name }}</td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">{{ $item->variant->variant_name }}</span>
                                                    </td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                                    <td class="text-end fw-semibold">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <hr>

                                    <!-- Total -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="bi bi-credit-card"></i> {{ ucfirst($order->payment_method) }}
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            @if($order->discount_amount > 0)
                                            <div class="mb-1">
                                                <small class="text-muted">Diskon:</small>
                                                <span class="text-danger">-Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                                            </div>
                                            @endif
                                            <div>
                                                <strong>Total: </strong>
                                                <span class="text-success fs-5 fw-bold">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                <p>User ini belum pernah order online</p>
                            </div>
                            @endforelse
                        </div>

                        <!-- Sales Tab -->
                        <div class="tab-pane fade" id="sales-tab">
                    @forelse($user->sales as $sale)
                    <div class="card mb-3 border">
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-secondary">{{ $sale->barcode }}</span>
                                    <small class="text-muted ms-2">{{ $sale->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <div>
                                    <span class="badge 
                                        @if($sale->payment_method == 'cash') bg-success
                                        @elseif($sale->payment_method == 'debit') bg-primary
                                        @else bg-info
                                        @endif">
                                        {{ ucfirst($sale->payment_method) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Detail Barang -->
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Varian</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-end">Diskon</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sale->items as $item)
                                        <tr>
                                            <td>{{ $item->variant->product->name }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $item->variant->variant_name }}</span>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                @if($item->discount > 0)
                                                    <span class="text-danger">-Rp{{ number_format($item->discount, 0, ',', '.') }}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-end fw-semibold">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <hr>

                            <!-- Total -->
                            <div class="row">
                                <div class="col-md-6">
                                    @if($sale->customer_name)
                                    <small class="text-muted">Customer: {{ $sale->customer_name }}</small>
                                    @endif
                                </div>
                                <div class="col-md-6 text-end">
                                    @if($sale->discount > 0)
                                    <div class="mb-1">
                                        <small class="text-muted">Diskon Transaksi:</small>
                                        <span class="text-danger">-Rp{{ number_format($sale->discount, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                    <div>
                                        <strong>Total: </strong>
                                        <span class="text-success fs-5 fw-bold">Rp{{ number_format($sale->total, 0, ',', '.') }}</span>
                                    </div>
                                    <small class="text-muted">
                                        Bayar: Rp{{ number_format($sale->paid_amount, 0, ',', '.') }} | 
                                        Kembalian: Rp{{ number_format($sale->change, 0, ',', '.') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        <p>User ini belum pernah transaksi POS</p>
                    </div>
                    @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
