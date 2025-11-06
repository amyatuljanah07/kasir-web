<!DOCTYPE html><!DOCTYPE html>

<html><html>

<head><head>

    <meta charset="UTF-8">    <meta charset="utf-8">

    <title>Struk - {{ $transaction->barcode }}</title>    <title>Struk #{{ $sale->barcode ?? $sale->id }}</title>

    <style>    <style>

        body {        body { 

            font-family: 'Courier New', monospace;            font-family: 'Courier New', monospace; 

            width: 300px;            width: 80mm; 

            margin: 0 auto;            margin: 0 auto; 

            padding: 20px;            font-size: 12px; 

        }            padding: 10px;

        .header {        }

            text-align: center;        .center { text-align: center; }

            margin-bottom: 20px;        .header { 

            border-bottom: 2px dashed #000;            border-bottom: 2px dashed #000; 

            padding-bottom: 10px;            padding-bottom: 10px; 

        }            margin-bottom: 10px; 

        .header h2 {        }

            margin: 0;        .info-section { 

            font-size: 20px;            margin: 10px 0; 

        }        }

        .info {        .divider { 

            margin-bottom: 15px;            border-top: 1px dashed #000; 

            font-size: 12px;            margin: 10px 0; 

        }        }

        .info div {        .total-section { 

            display: flex;            border-top: 2px dashed #000; 

            justify-content: space-between;            margin-top: 10px; 

            margin: 5px 0;            padding-top: 10px; 

        }        }

        .items {        .footer { 

            border-top: 1px dashed #000;            border-top: 1px dashed #000; 

            border-bottom: 1px dashed #000;            margin-top: 15px; 

            padding: 10px 0;            padding-top: 10px; 

            margin: 15px 0;            font-size: 10px; 

        }        }

        .item {        table { 

            margin: 8px 0;            width: 100%; 

            font-size: 12px;            border-collapse: collapse; 

        }        }

        .item-name {        .bold { font-weight: bold; }

            font-weight: bold;        .item-row { margin: 8px 0; }

        }    </style>

        .item-detail {</head>

            display: flex;<body>

            justify-content: space-between;    <div class="header center">

            margin-top: 3px;        <h2 style="margin: 5px 0; font-size: 18px;">SELLIN POS</h2>

        }        <p style="margin: 2px 0; font-size: 11px;">Jl. Contoh No. 123, Jakarta</p>

        .totals {        <p style="margin: 2px 0; font-size: 11px;">Telp: 0812-3456-7890</p>

            font-size: 12px;        <p style="margin: 2px 0; font-size: 11px;">www.sellinpos.com</p>

            margin: 10px 0;    </div>

        }

        .totals div {    <div class="center info-section">

            display: flex;        <p style="margin: 2px 0;"><strong>STRUK PEMBELIAN</strong></p>

            justify-content: space-between;        <p style="margin: 2px 0; font-size: 11px;">No: {{ $sale->barcode ?? $sale->id }}</p>

            margin: 5px 0;        <p style="margin: 2px 0; font-size: 11px;">{{ $sale->created_at->format('d/m/Y H:i:s') }}</p>

        }    </div>

        .total-final {

            font-size: 14px;    <table style="margin: 10px 0; font-size: 11px;">

            font-weight: bold;        <tr>

            border-top: 2px solid #000;            <td style="width: 35%;">Customer:</td>

            padding-top: 5px;            <td class="bold">{{ $sale->customer_name }}</td>

            margin-top: 10px;        </tr>

        }        @if($sale->user && $sale->user->is_member)

        .footer {        <tr>

            text-align: center;            <td>Status:</td>

            margin-top: 20px;            <td class="bold">MEMBER ⭐</td>

            font-size: 11px;        </tr>

            border-top: 2px dashed #000;        @endif

            padding-top: 10px;        <tr>

        }            <td>Pembayaran:</td>

        @media print {            <td class="bold">{{ strtoupper($sale->payment_method) }}</td>

            body {        </tr>

                width: 80mm;    </table>

            }

        }    <div class="divider"></div>

    </style>

</head>    <div style="margin: 10px 0;">

<body>        @foreach($sale->items as $item)

    <div class="header">        <div class="item-row">

        <h2>SELLIN POS</h2>            <div class="bold" style="font-size: 11px;">{{ $item->variant->product->name }}</div>

        <div>Jl. Contoh No. 123</div>            <table style="font-size: 10px; margin-top: 2px;">

        <div>Telp: 081234567890</div>                <tr>

    </div>                    <td style="width: 60%;">

                        {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}

    <div class="info">                        @if($item->variant->size)

        <div>                            ({{ $item->variant->size }})

            <span>No Transaksi:</span>                        @endif

            <span>{{ $transaction->barcode }}</span>                    </td>

        </div>                    <td class="bold" style="text-align: right;">

        <div>                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}

            <span>Tanggal:</span>                    </td>

            <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>                </tr>

        </div>            </table>

        <div>        </div>

            <span>Kasir:</span>        @endforeach

            <span>{{ $transaction->cashier->name }}</span>    </div>

        </div>

        <div>    <div class="total-section">

            <span>Customer:</span>        <table style="font-size: 11px;">

            <span>{{ $transaction->customer_name }}</span>            <tr>

        </div>                <td style="width: 60%;">Subtotal:</td>

    </div>                <td class="bold" style="text-align: right;">

                    Rp {{ number_format($sale->total + $sale->discount, 0, ',', '.') }}

    <div class="items">                </td>

        @foreach($transaction->items as $item)            </tr>

        <div class="item">            @if($sale->discount > 0)

            <div class="item-name">{{ $item->variant->product->name }} ({{ $item->variant->size }})</div>            <tr>

            <div class="item-detail">                <td>Diskon Member ({{ number_format(($sale->discount / ($sale->total + $sale->discount)) * 100, 0) }}%):</td>

                <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>                <td class="bold" style="text-align: right; color: #d97706;">

                <span>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>                    - Rp {{ number_format($sale->discount, 0, ',', '.') }}

            </div>                </td>

        </div>            </tr>

        @endforeach            @endif

    </div>            <tr style="font-size: 14px; border-top: 1px solid #000;">

                <td class="bold" style="padding-top: 5px;">TOTAL:</td>

    <div class="totals">                <td class="bold" style="text-align: right; padding-top: 5px;">

        <div>                    Rp {{ number_format($sale->total, 0, ',', '.') }}

            <span>Subtotal:</span>                </td>

            <span>Rp {{ number_format($transaction->items->sum(fn($i) => $i->quantity * $i->price), 0, ',', '.') }}</span>            </tr>

        </div>            @if($sale->paid_amount)

        @if($transaction->discount > 0)            <tr style="font-size: 11px;">

        <div>                <td>Bayar:</td>

            <span>Diskon ({{ $transaction->discount }}%):</span>                <td style="text-align: right;">Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</td>

            <span>- Rp {{ number_format($transaction->items->sum(fn($i) => $i->quantity * $i->price) * $transaction->discount / 100, 0, ',', '.') }}</span>            </tr>

        </div>            <tr style="font-size: 11px;">

        @endif                <td>Kembali:</td>

        <div class="total-final">                <td style="text-align: right;">Rp {{ number_format($sale->change, 0, ',', '.') }}</td>

            <span>TOTAL:</span>            </tr>

            <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>            @endif

        </div>        </table>

        <div>    </div>

            <span>Bayar:</span>

            <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>    <div class="footer center">

        </div>        <p style="margin: 5px 0; font-weight: bold;">Terima kasih atas kunjungan Anda!</p>

        <div>        <p style="margin: 5px 0;">Barang yang sudah dibeli tidak dapat ditukar</p>

            <span>Kembalian:</span>        <p style="margin: 5px 0;">Simpan struk ini sebagai bukti pembelian</p>

            <span>Rp {{ number_format($transaction->paid_amount - $transaction->total, 0, ',', '.') }}</span>        <p style="margin: 10px 0 5px 0; font-size: 9px;">Powered by Sellin POS System</p>

        </div>        <p style="margin: 2px 0; font-size: 9px;">{{ now()->format('d/m/Y H:i:s') }}</p>

        <div>    </div>

            <span>Metode:</span></body>

            <span>{{ strtoupper($transaction->payment_method) }}</span></html>

        </div>
    </div>

    <div class="footer">
        <div>Terima Kasih Atas Kunjungan Anda!</div>
        <div>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
