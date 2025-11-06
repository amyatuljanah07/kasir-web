<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #000;
        }
        .header p {
            font-size: 12px;
            color: #666;
        }
        .info-box {
            background: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .info-box h3 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #007bff;
        }
        .info-box p {
            margin: 3px 0;
            font-size: 11px;
        }
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        .summary-item {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .summary-item:not(:last-child) {
            border-right: none;
        }
        .summary-item .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .summary-item .value {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead {
            background: #343a40;
            color: white;
        }
        table th {
            padding: 10px 5px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        table td {
            padding: 8px 5px;
            border-bottom: 1px solid #dee2e6;
            font-size: 10px;
        }
        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        table tbody tr:hover {
            background: #e9ecef;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success { background: #28a745; color: white; }
        .badge-primary { background: #007bff; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
        .badge-info { background: #17a2b8; color: white; }
        .badge-secondary { background: #6c757d; color: white; }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p>Sistem Kasir - Sellin</p>
        <p style="font-size: 10px; margin-top: 5px;">Dicetak: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>

    @if($filters['start_date'] || $filters['end_date'] || $filters['user_id'] || $filters['product_id'] || $filters['payment_method'])
    <div class="info-box">
        <h3>Filter Laporan</h3>
        @if($filters['start_date'] && $filters['end_date'])
            <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') }}</p>
        @endif
        @if($filters['user_id'])
            <p><strong>Kasir ID:</strong> {{ $filters['user_id'] }}</p>
        @endif
        @if($filters['product_id'])
            <p><strong>Produk ID:</strong> {{ $filters['product_id'] }}</p>
        @endif
        @if($filters['payment_method'])
            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($filters['payment_method']) }}</p>
        @endif
    </div>
    @endif

    <div class="summary">
        <div class="summary-item">
            <div class="label">Total Transaksi</div>
            <div class="value" style="color: #007bff;">{{ $sales->count() }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Total Penjualan</div>
            <div class="value">Rp{{ number_format($sales->sum('total'), 0, ',', '.') }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Total Keuntungan</div>
            <div class="value">Rp{{ number_format($totalKeuntungan, 0, ',', '.') }}</div>
        </div>
    </div>

    @if($sales->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 12%;">Kode</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 18%;">Kasir</th>
                <th style="width: 8%;" class="text-center">Items</th>
                <th style="width: 15%;" class="text-right">Total</th>
                <th style="width: 13%;" class="text-right">Diskon</th>
                <th style="width: 15%;">Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $index => $sale)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $sale->barcode }}</td>
                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $sale->cashier ? $sale->cashier->name : '-' }}</td>
                <td class="text-center">{{ $sale->items->count() }}</td>
                <td class="text-right"><strong>Rp{{ number_format($sale->total, 0, ',', '.') }}</strong></td>
                <td class="text-right">
                    @if($sale->discount > 0)
                        Rp{{ number_format($sale->discount, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <span class="badge 
                        @if($sale->payment_method == 'cash') badge-success
                        @elseif($sale->payment_method == 'debit') badge-primary
                        @elseif($sale->payment_method == 'credit') badge-warning
                        @else badge-info
                        @endif">
                        {{ strtoupper($sale->payment_method) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: #e9ecef; font-weight: bold;">
                <td colspan="5" class="text-right" style="padding: 12px 5px;">GRAND TOTAL:</td>
                <td class="text-center">{{ $sales->sum(function($sale) { return $sale->items->count(); }) }}</td>
                <td class="text-right" style="color: #28a745;">Rp{{ number_format($sales->sum('total'), 0, ',', '.') }}</td>
                <td class="text-right">Rp{{ number_format($sales->sum('discount'), 0, ',', '.') }}</td>
                <td>-</td>
            </tr>
        </tfoot>
    </table>

    <!-- Detail Items per Transaksi -->
    <div style="page-break-before: always; margin-top: 40px;">
        <h3 style="margin-bottom: 20px; font-size: 16px; border-bottom: 2px solid #333; padding-bottom: 10px;">
            DETAIL PRODUK PER TRANSAKSI
        </h3>
        @foreach($sales as $index => $sale)
        <div style="margin-bottom: 25px; background: #f8f9fa; padding: 15px; border-left: 4px solid #007bff;">
            <p style="font-weight: bold; margin-bottom: 10px; font-size: 12px;">
                #{{ $index + 1 }} - {{ $sale->barcode }} | {{ $sale->created_at->format('d/m/Y H:i') }}
            </p>
            <table style="margin-bottom: 0;">
                <thead style="background: #6c757d;">
                    <tr>
                        <th>Produk</th>
                        <th>Varian</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                    <tr>
                        <td>{{ $item->variant->product->name }}</td>
                        <td>{{ $item->variant->variant_name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right"><strong>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
    @else
    <div class="no-data">
        <p>Tidak ada data transaksi yang sesuai dengan filter</p>
    </div>
    @endif

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem</p>
        <p>© {{ date('Y') }} Sellin - Sistem Kasir</p>
    </div>
</body>
</html>
