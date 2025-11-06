@extends('layouts.admin')@extends('layouts.app')



@section('content')@section('title', 'Riwayat Belanja Saya')

<div class="container py-4">

    <div class="card shadow-sm">@section('content')

        <div class="card-header bg-primary text-white"><div class="max-w-7xl mx-auto px-4 py-6">

            <h4 class="mb-0"><i class="bi bi-clock-history"></i> Riwayat Transaksi POS</h4>    <div class="mb-6">

        </div>        <h1 class="text-3xl font-bold text-gray-800">🛍️ Riwayat Belanja Saya</h1>

        <div class="card-body">        <p class="text-gray-600 mt-1">Semua transaksi pembelian Anda</p>

            <!-- Filter Form -->    </div>

            <form method="GET" class="row g-3 mb-4">

                <div class="col-md-3">    {{-- Metrik Cards --}}

                    <label class="form-label">Tanggal Mulai</label>    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">

                </div>            <div class="flex justify-content-between align-items-start">

                <div class="col-md-3">                <div>

                    <label class="form-label">Tanggal Akhir</label>                    <p class="text-blue-100 text-sm mb-1">Total Transaksi</p>

                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">                    <h3 class="text-3xl font-bold">{{ $totalTransaksi }}</h3>

                </div>                </div>

                <div class="col-md-3">                <div class="text-4xl opacity-50">🧾</div>

                    <label class="form-label">Metode Pembayaran</label>            </div>

                    <select name="payment_method" class="form-select">        </div>

                        <option value="">Semua</option>        <div class="bg-gradient-to-br from-pink-500 to-red-500 rounded-lg shadow-lg p-6 text-white">

                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>            <div class="flex justify-between items-start">

                        <option value="debit" {{ request('payment_method') == 'debit' ? 'selected' : '' }}>Debit</option>                <div>

                        <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>                    <p class="text-pink-100 text-sm mb-1">Total Belanja</p>

                    </select>                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h3>

                </div>                </div>

                <div class="col-md-3 d-flex align-items-end">                <div class="text-4xl opacity-50">💰</div>

                    <button type="submit" class="btn btn-primary me-2">            </div>

                        <i class="bi bi-funnel"></i> Filter        </div>

                    </button>        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg shadow-lg p-6 text-white">

                    <a href="{{ route('customer.transactions') }}" class="btn btn-secondary">            <div class="flex justify-between items-start">

                        <i class="bi bi-arrow-clockwise"></i> Reset                <div>

                    </a>                    <p class="text-yellow-100 text-sm mb-1">Total Hemat (Diskon)</p>

                </div>                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalDiskonDiterima, 0, ',', '.') }}</h3>

            </form>                </div>

                <div class="text-4xl opacity-50">🏷️</div>

            <!-- Transactions Table -->            </div>

            @if($transactions->count() > 0)        </div>

            <div class="table-responsive">    </div>

                <table class="table table-hover">

                    <thead class="table-light">    {{-- Filter Card --}}

                        <tr>    <div class="bg-white rounded-lg shadow-md p-6 mb-6">

                            <th>No</th>        <form method="GET" action="{{ route('customer.transactions') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">

                            <th>Tanggal</th>            <div>

                            <th>No Transaksi</th>                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>

                            <th>Kasir</th>                <input type="date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ request('start_date') }}">

                            <th>Total</th>            </div>

                            <th>Metode Bayar</th>            <div>

                            <th>Aksi</th>                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Akhir</label>

                        </tr>                <input type="date" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ request('end_date') }}">

                    </thead>            </div>

                    <tbody>            <div>

                        @foreach($transactions as $transaction)                <label class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>

                        <tr>                <select name="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                            <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>                    <option value="">Semua Metode</option>

                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>

                            <td><code>{{ $transaction->barcode }}</code></td>                    <option value="debit" {{ request('payment_method') == 'debit' ? 'selected' : '' }}>Debit</option>

                            <td>{{ $transaction->cashier->name }}</td>                    <option value="credit" {{ request('payment_method') == 'credit' ? 'selected' : '' }}>Credit</option>

                            <td><strong>Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong></td>                    <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>

                            <td>                </select>

                                @if($transaction->payment_method == 'cash')            </div>

                                    <span class="badge bg-success">Tunai</span>            <div class="flex items-end gap-2">

                                @elseif($transaction->payment_method == 'debit')                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">

                                    <span class="badge bg-info">Debit</span>                    🔍 Filter

                                @else                </button>

                                    <span class="badge bg-warning">QRIS</span>                <a href="{{ route('customer.transactions') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">

                                @endif                    ✖ Reset

                            </td>                </a>

                            <td>            </div>

                                <a href="{{ route('customer.transactions.show', $transaction->id) }}" class="btn btn-sm btn-primary">        </form>

                                    <i class="bi bi-eye"></i> Detail    </div>

                                </a>

                                <a href="{{ route('customer.transactions.download', $transaction->id) }}" class="btn btn-sm btn-secondary" target="_blank">    {{-- Daftar Transaksi --}}

                                    <i class="bi bi-printer"></i> Struk    @if($transactions->count() > 0)

                                </a>        <div class="space-y-4">

                            </td>            @foreach($transactions as $transaction)

                        </tr>            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">

                        @endforeach                <div class="p-6">

                    </tbody>                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">

                </table>                        {{-- Tanggal & No --}}

            </div>                        <div class="md:col-span-2 text-center md:text-left">

                            <div class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold mb-2">

            <!-- Pagination -->                                #{{ $transaction->barcode ?? $transaction->id }}

            <div class="d-flex justify-content-center mt-4">                            </div>

                {{ $transactions->links() }}                            <p class="text-sm text-gray-600">

            </div>                                📅 {{ $transaction->created_at->format('d M Y') }}

            @else                            </p>

            <div class="alert alert-info text-center">                            <p class="text-sm text-gray-600">

                <i class="bi bi-info-circle"></i> Belum ada transaksi POS.                                🕐 {{ $transaction->created_at->format('H:i') }}

            </div>                            </p>

            @endif                        </div>

        </div>                        

    </div>                        {{-- Items --}}

</div>                        <div class="md:col-span-5">

@endsection                            <h6 class="font-semibold text-gray-800 mb-2">🛒 Items Dibeli:</h6>

                            <div class="text-sm space-y-1">
                                @foreach($transaction->items as $item)
                                    <div class="flex justify-between">
                                        <span class="text-gray-700">
                                            • {{ $item->variant->product->name }}
                                            @if($item->variant->size)
                                                <span class="text-gray-500">({{ $item->variant->size }})</span>
                                            @endif
                                        </span>
                                        <span class="text-gray-500">{{ $item->quantity }}x</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        {{-- Total & Status --}}
                        <div class="md:col-span-3">
                            <div class="mb-2 flex flex-wrap gap-2">
                                <span class="inline-block bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold uppercase">
                                    💳 {{ $transaction->payment_method }}
                                </span>
                                @if($transaction->discount > 0)
                                    <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        🏷️ Diskon {{ number_format(($transaction->discount / ($transaction->total + $transaction->discount)) * 100, 0) }}%
                                    </span>
                                @endif
                            </div>
                            @if($transaction->discount > 0)
                            <p class="text-sm text-gray-500 line-through mb-1">
                                Rp {{ number_format($transaction->total + $transaction->discount, 0, ',', '.') }}
                            </p>
                            @endif
                            <h5 class="text-2xl font-bold text-green-600">
                                Rp {{ number_format($transaction->total, 0, ',', '.') }}
                            </h5>
                        </div>
                        
                        {{-- Actions --}}
                        <div class="md:col-span-2 flex flex-col gap-2">
                            <a href="{{ route('customer.transactions.show', $transaction->id) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white text-center px-4 py-2 rounded-lg transition text-sm">
                                👁️ Detail
                            </a>
                            <a href="{{ route('customer.transactions.download', $transaction->id) }}" 
                               class="bg-green-500 hover:bg-green-600 text-white text-center px-4 py-2 rounded-lg transition text-sm">
                                📥 Struk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="text-6xl mb-4">📭</div>
            <h5 class="text-xl font-semibold text-gray-700 mb-2">Belum ada transaksi</h5>
            <p class="text-gray-500 mb-4">Mulai belanja sekarang!</p>
            <a href="/catalog" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition">
                🛒 Lihat Katalog
            </a>
        </div>
    @endif
</div>
@endsection
