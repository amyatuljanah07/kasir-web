@extends('layouts.admin')@extends('layouts.app')



@section('content')@section('title', 'Detail Transaksi')

<div class="container py-4">

    <a href="{{ route('customer.transactions') }}" class="btn btn-outline-secondary mb-3">@section('content')

        <i class="bi bi-arrow-left"></i> Kembali<div class="max-w-7xl mx-auto px-4 py-6">

    </a>    <div class="mb-6">

        <a href="{{ route('customer.transactions') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition mb-4">

    <div class="card shadow-sm">            ← Kembali ke Riwayat

        <div class="card-header bg-primary text-white">        </a>

            <h4 class="mb-0"><i class="bi bi-receipt"></i> Detail Transaksi</h4>        <h1 class="text-3xl font-bold text-gray-800">📄 Detail Transaksi</h1>

        </div>        <p class="text-gray-600 mt-1">Nomor Transaksi: <strong class="text-blue-600">#{{ $transaction->barcode ?? $transaction->id }}</strong></p>

        <div class="card-body">    </div>

            <!-- Transaction Info -->

            <div class="row mb-4">    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="col-md-6">        {{-- Info Transaksi --}}

                    <table class="table table-sm">        <div class="lg:col-span-1">

                        <tr>            <div class="bg-white rounded-lg shadow-md overflow-hidden">

                            <th width="150">No Transaksi:</th>                <div class="bg-blue-500 text-white px-6 py-4">

                            <td><code>{{ $transaction->barcode }}</code></td>                    <h6 class="text-lg font-semibold">ℹ️ Informasi Transaksi</h6>

                        </tr>                </div>

                        <tr>                <div class="p-6">

                            <th>Tanggal:</th>                    <div class="space-y-3 text-sm">

                            <td>{{ $transaction->created_at->format('d F Y H:i') }}</td>                        <div class="flex justify-between border-b pb-2">

                        </tr>                            <span class="text-gray-600">Tanggal:</span>

                        <tr>                            <span class="font-semibold">{{ $transaction->created_at->format('d M Y') }}</span>

                            <th>Kasir:</th>                        </div>

                            <td>{{ $transaction->cashier->name }}</td>                        <div class="flex justify-between border-b pb-2">

                        </tr>                            <span class="text-gray-600">Waktu:</span>

                    </table>                            <span class="font-semibold">{{ $transaction->created_at->format('H:i:s') }}</span>

                </div>                        </div>

                <div class="col-md-6">                        <div class="flex justify-between border-b pb-2">

                    <table class="table table-sm">                            <span class="text-gray-600">Customer:</span>

                        <tr>                            <span class="font-semibold">{{ $transaction->customer_name }}</span>

                            <th width="150">Customer:</th>                        </div>

                            <td>{{ $transaction->customer_name }}</td>                        <div class="flex justify-between border-b pb-2">

                        </tr>                            <span class="text-gray-600">Metode:</span>

                        <tr>                            <span class="inline-block bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold uppercase">

                            <th>Metode Bayar:</th>                                {{ $transaction->payment_method }}

                            <td>                            </span>

                                @if($transaction->payment_method == 'cash')                        </div>

                                    <span class="badge bg-success">Tunai</span>                        @if($transaction->discount > 0)

                                @elseif($transaction->payment_method == 'debit')                        <div class="flex justify-between pb-2">

                                    <span class="badge bg-info">Debit</span>                            <span class="text-gray-600">Status:</span>

                                @else                            <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">

                                    <span class="badge bg-warning">QRIS</span>                                ⭐ Member

                                @endif                            </span>

                            </td>                        </div>

                        </tr>                        @endif

                        <tr>                    </div>

                            <th>Diskon Member:</th>                    <div class="mt-6">

                            <td>{{ $transaction->discount }}%</td>                        <a href="{{ route('customer.transactions.download', $transaction->id) }}" 

                        </tr>                           class="block w-full bg-green-500 hover:bg-green-600 text-white text-center px-4 py-3 rounded-lg transition font-semibold">

                    </table>                            📥 Download Struk PDF

                </div>                        </a>

            </div>                    </div>

                </div>

            <!-- Items Table -->            </div>

            <h5 class="mb-3">Item Belanja</h5>        </div>

            <div class="table-responsive">

                <table class="table table-bordered">        {{-- Detail Items --}}

                    <thead class="table-light">        <div class="lg:col-span-2">

                        <tr>            <div class="bg-white rounded-lg shadow-md overflow-hidden">

                            <th>No</th>                <div class="bg-gray-50 px-6 py-4 border-b">

                            <th>Produk</th>                    <h6 class="text-lg font-semibold text-gray-800">🛒 Detail Barang Dibeli</h6>

                            <th>Varian</th>                </div>

                            <th>Harga</th>                <div class="overflow-x-auto">

                            <th>Qty</th>                    <table class="w-full">

                            <th>Subtotal</th>                        <thead class="bg-gray-100 border-b">

                        </tr>                            <tr>

                    </thead>                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>

                    <tbody>                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>

                        @foreach($transaction->items as $item)                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Varian</th>

                        <tr>                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Qty</th>

                            <td>{{ $loop->iteration }}</td>                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Harga</th>

                            <td>{{ $item->variant->product->name }}</td>                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Subtotal</th>

                            <td>{{ $item->variant->size }}</td>                            </tr>

                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>                        </thead>

                            <td>{{ $item->quantity }}</td>                        <tbody class="divide-y divide-gray-200">

                            <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>                            @foreach($transaction->items as $index => $item)

                        </tr>                            <tr class="hover:bg-gray-50">

                        @endforeach                                <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>

                    </tbody>                                <td class="px-4 py-3">

                    <tfoot>                                    <span class="font-semibold text-gray-800">{{ $item->variant->product->name }}</span>

                        <tr>                                </td>

                            <th colspan="5" class="text-end">Subtotal:</th>                                <td class="px-4 py-3">

                            <th>Rp {{ number_format($transaction->items->sum(fn($i) => $i->quantity * $i->price), 0, ',', '.') }}</th>                                    @if($item->variant->size)

                        </tr>                                        <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">

                        @if($transaction->discount > 0)                                            {{ $item->variant->size }}

                        <tr>                                        </span>

                            <th colspan="5" class="text-end">Diskon ({{ $transaction->discount }}%):</th>                                    @else

                            <th>- Rp {{ number_format($transaction->items->sum(fn($i) => $i->quantity * $i->price) * $transaction->discount / 100, 0, ',', '.') }}</th>                                        <span class="text-gray-400 text-xs">-</span>

                        </tr>                                    @endif

                        @endif                                </td>

                        <tr class="table-success">                                <td class="px-4 py-3 text-center">

                            <th colspan="5" class="text-end">TOTAL:</th>                                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">

                            <th>Rp {{ number_format($transaction->total, 0, ',', '.') }}</th>                                        {{ $item->quantity }}

                        </tr>                                    </span>

                        <tr>                                </td>

                            <th colspan="5" class="text-end">Bayar:</th>                                <td class="px-4 py-3 text-right text-sm">

                            <th>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</th>                                    Rp {{ number_format($item->price, 0, ',', '.') }}

                        </tr>                                </td>

                        <tr>                                <td class="px-4 py-3 text-right font-semibold text-sm">

                            <th colspan="5" class="text-end">Kembalian:</th>                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}

                            <th>Rp {{ number_format($transaction->paid_amount - $transaction->total, 0, ',', '.') }}</th>                                </td>

                        </tr>                            </tr>

                    </tfoot>                            @endforeach

                </table>                        </tbody>

            </div>                        <tfoot class="bg-gray-50 border-t-2">

                            <tr>

            <!-- Actions -->                                <th colspan="5" class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Subtotal:</th>

            <div class="text-end mt-4">                                <th class="px-4 py-3 text-right text-sm font-semibold">

                <a href="{{ route('customer.transactions.download', $transaction->id) }}" class="btn btn-primary" target="_blank">                                    Rp {{ number_format($transaction->total + $transaction->discount, 0, ',', '.') }}

                    <i class="bi bi-printer"></i> Cetak Struk                                </th>

                </a>                            </tr>

            </div>                            @if($transaction->discount > 0)

        </div>                            <tr>

    </div>                                <th colspan="5" class="px-4 py-2 text-right text-sm text-yellow-700">

</div>                                    Diskon Member ({{ number_format(($transaction->discount / ($transaction->total + $transaction->discount)) * 100, 0) }}%):

@endsection                                </th>

                                <th class="px-4 py-2 text-right text-sm text-yellow-700">
                                    - Rp {{ number_format($transaction->discount, 0, ',', '.') }}
                                </th>
                            </tr>
                            @endif
                            <tr class="bg-green-50">
                                <th colspan="5" class="px-4 py-4 text-right text-base font-bold text-gray-800">TOTAL BAYAR:</th>
                                <th class="px-4 py-4 text-right text-xl font-bold text-green-600">
                                    Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
