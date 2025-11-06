<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tutup Kasir - {{ $cashierName }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 2px solid #000; 
            padding-bottom: 10px; 
        }
        .header h2 { 
            margin: 0 0 10px 0; 
            font-size: 20px; 
        }
        .header p { 
            margin: 5px 0; 
        }
        .info-box { 
            background: #f8f9fa; 
            padding: 10px; 
            margin: 15px 0; 
            border-radius: 5px; 
            border: 1px solid #ddd;
        }
        .summary-grid { 
            display: table; 
            width: 100%; 
            margin: 20px 0; 
            border-collapse: collapse;
        }
        .summary-item { 
            display: table-cell; 
            width: 25%; 
            padding: 15px; 
            text-align: center; 
            border: 1px solid #ddd;
        }
        .summary-item.blue { background: #e3f2fd; }
        .summary-item.green { background: #c8e6c9; }
        .summary-item.yellow { background: #fff9c4; }
        .summary-item.purple { background: #e1bee7; }
        .summary-label { 
            font-size: 10px; 
            color: #666; 
            margin-bottom: 5px;
        }
        .summary-value { 
            font-size: 18px; 
            font-weight: bold; 
            color: #333;
        }
        .summary-value.money { 
            font-size: 14px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #f8f9fa; 
            font-weight: bold; 
            font-size: 11px;
            text-transform: uppercase;
        }
        .text-right { 
            text-align: right; 
        }
        .total-row { 
            background-color: #d4edda; 
            font-weight: bold; 
        }
        .footer { 
            margin-top: 30px; 
            text-align: center; 
            font-size: 10px; 
            color: #666; 
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .payment-summary-table { 
            border: none; 
            margin-top: 10px; 
        }
        .payment-summary-table td { 
            border: none; 
            padding: 5px 10px;
        }
        .badge { 
            background: #ffc107; 
            padding: 2px 6px; 
            border-radius: 3px; 
            font-size: 9px; 
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN TUTUP KASIR</h2>
        <p><strong>Kasir:</strong> {{ $cashierName }}</p>
        <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} 
           s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        <p><strong>Dicetak:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="summary-grid">
        <div class="summary-item blue">
            <div class="summary-label">Total Transaksi</div>
            <div class="summary-value">{{ $totalTransaksi }}</div>
        </div>
        <div class="summary-item green">
            <div class="summary-label">Total Penjualan</div>
            <div class="summary-value money">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
        </div>
        <div class="summary-item yellow">
            <div class="summary-label">Total Diskon</div>
            <div class="summary-value money">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</div>
        </div>
        <div class="summary-item purple">
            <div class="summary-label">Keuntungan</div>
            <div class="summary-value money">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</div>
        </div>
    </div>

    @if($paymentSummary->count() > 0)
    <div class="info-box">
        <strong>Ringkasan per Metode Pembayaran:</strong>
        <table class="payment-summary-table">
            @foreach($paymentSummary as $method => $data)
            <tr>
                <td style="width: 30%;"><strong>{{ strtoupper($method) }}</strong></td>
                <td style="width: 30%;">{{ $data['count'] }} transaksi</td>
                <td style="text-align: right; font-weight: bold;">
                    Rp {{ number_format($data['total'], 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif

    <h3 style="margin-top: 30px; margin-bottom: 10px; font-size: 16px;">Detail Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Waktu</th>
                <th width="18%">Customer</th>
                <th width="30%">Items</th>
                <th width="10%">Metode</th>
                <th width="12%">Diskon</th>
                <th width="13%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $index => $sale)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-size: 10px;">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td style="font-size: 11px;">
                    {{ $sale->user ? $sale->user->name : ($sale->customer_name ?: 'Tidak Diketahui') }}
                    @if($sale->user && $sale->user->is_member)
                        <span class="badge">MEMBER</span>
                    @endif
                </td>
                <td style="font-size: 10px;">
                    @foreach($sale->items as $item)
                        {{ $item->variant->product->name }} ({{ $item->quantity }}x)<br>
                    @endforeach
                </td>
                <td style="font-size: 10px; text-transform: uppercase;">{{ $sale->payment_method }}</td>
                <td class="text-right" style="font-size: 11px;">
                    @if($sale->discount > 0)
                        -Rp {{ number_format($sale->discount, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-right" style="font-size: 11px;"><strong>Rp {{ number_format($sale->total, 0, ',', '.') }}</strong></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right"><strong>GRAND TOTAL:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p><strong>Laporan Tutup Kasir</strong> - Generated by Sellin POS System</p>
        <p>{{ now()->format('d F Y - H:i:s') }}</p>
    </div>
</body>
</html>
