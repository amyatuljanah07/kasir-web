<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian #{{ $sale->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            padding: 10px;
            width: 80mm;
            max-width: 80mm;
            background: white;
            margin: 0 auto;
        }
        .receipt-container {
            width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 8px;
        }
        .header .logo {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
            letter-spacing: 2px;
        }
        .header p {
            font-size: 10px;
            margin: 1px 0;
            line-height: 1.3;
        }
        .divider {
            border-bottom: 1px dashed #000;
            margin: 8px 0;
        }
        .info-row {
            font-size: 11px;
            margin: 2px 0;
            display: flex;
            justify-content: space-between;
        }
        .info-row .label {
            flex: 0 0 auto;
        }
        .info-row .value {
            flex: 1;
            text-align: right;
        }
        .items {
            margin: 8px 0;
        }
        .item {
            margin: 6px 0;
        }
        .item-name {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 2px;
            text-transform: uppercase;
        }
        .item-detail {
            font-size: 11px;
            display: flex;
            justify-content: space-between;
            margin: 1px 0;
        }
        .item-detail .left {
            flex: 1;
        }
        .item-detail .right {
            text-align: right;
            flex: 0 0 auto;
            padding-left: 10px;
        }
        .totals {
            margin-top: 8px;
        }
        .total-row {
            font-size: 11px;
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        .total-row.main {
            font-size: 13px;
            font-weight: bold;
            margin-top: 5px;
        }
        .payment {
            margin-top: 8px;
        }
        .payment-row {
            font-size: 11px;
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 10px;
        }
        .footer .thank {
            font-weight: bold;
            margin: 5px 0;
        }
        
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }
            body {
                padding: 5px;
                margin: 0;
                width: 80mm;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">SELLIN KASIR</div>
            <p>Jl. Raya Contoh Cikajang Kel. Contoh Kec</p>
            <p>Cisurupan Kab. Jakarta 44163, 44163</p>
        </div>

        <div class="divider"></div>

        <!-- Transaction Info -->
        <div class="info-row">
            <span class="label">{{ $sale->created_at->format('d.m.y-H:i') }}</span>
            <span class="value">{{ $sale->created_at->format('d.m.y') }} {{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}/KASIR/{{ str_pad(auth()->user()->id ?? 1, 2, '0', STR_PAD_LEFT) }}</span>
        </div>

        <div class="divider"></div>

        <!-- Items -->
        <div class="items">
            @foreach($sale->items as $item)
            @if($item->variant && $item->variant->product)
            <div class="item">
                <div class="item-name">{{ strtoupper($item->variant->product->name) }} {{ $item->variant->variant_name ? strtoupper($item->variant->variant_name) : '' }}</div>
                <div class="item-detail">
                    <span class="left">{{ $item->quantity }}</span>
                    <span class="left">{{ number_format($item->price, 0, ',', '.') }}</span>
                    <span class="right">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="divider"></div>

        <!-- Totals -->
        <div class="totals">
            <div class="total-row">
                <span>HARGA JUAL :</span>
                <span>{{ number_format($sale->total, 0, ',', '.') }}</span>
            </div>
            
            @php
                $memberDiscount = 0;
                if($sale->user && $sale->user->membership) {
                    $memberDiscount = $sale->total * ($sale->user->membership->discount_percentage / 100);
                }
            @endphp
            
            @if($memberDiscount > 0)
            <div class="total-row">
                <span>DISKON MEMBER :</span>
                <span>({{ number_format($memberDiscount, 0, ',', '.') }})</span>
            </div>
            @endif
            
            <div class="divider"></div>
            
            <div class="total-row main">
                <span>TOTAL :</span>
                <span>{{ number_format($sale->total - $memberDiscount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment -->
        <div class="payment">
            <div class="payment-row">
                <span>{{ strtoupper($sale->payment_method) }} :</span>
                <span>{{ number_format($sale->paid_amount, 0, ',', '.') }}</span>
            </div>
            @if($sale->payment_method === 'tunai' || $sale->payment_method === 'cash')
            <div class="payment-row">
                <span>KEMBALI :</span>
                <span>{{ number_format($sale->change ?? 0, 0, ',', '.') }}</span>
            </div>
            @endif
        </div>

        <div class="divider"></div>

        <!-- Footer -->
        <div class="footer">
            <p class="thank">TERIMA KASIH</p>
            <p>ANDA HEMAT : {{ number_format($memberDiscount, 0, ',', '.') }}</p>
            <div class="divider"></div>
            <p>LAYANAN KONSUMEN SMS 0811 1500 280</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
