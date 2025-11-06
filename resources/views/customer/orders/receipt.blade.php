<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #f3f4f6;
            padding: 20px;
        }

        .receipt-container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border: 2px dashed #1f2937;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #1f2937;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .store-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .store-tagline {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .store-info {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.6;
        }

        .order-info {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #d1d5db;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .info-label {
            color: #6b7280;
        }

        .info-value {
            font-weight: 600;
            color: #1f2937;
        }

        .order-number-big {
            font-size: 18px;
            font-weight: 700;
            text-align: center;
            margin: 15px 0;
            padding: 10px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            letter-spacing: 1px;
        }

        .items-section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .item {
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dotted #d1d5db;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .item-variant {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }

        .item-qty-price {
            color: #6b7280;
        }

        .item-subtotal {
            font-weight: 600;
        }

        .summary-section {
            border-top: 2px dashed #1f2937;
            padding-top: 15px;
            margin-top: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .summary-row.total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #d1d5db;
            font-size: 18px;
            font-weight: 700;
        }

        .payment-info {
            margin-top: 20px;
            padding: 15px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .payment-method {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 10px;
        }

        .status-paid {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dashed #1f2937;
            text-align: center;
        }

        .thank-you {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .footer-note {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .qr-section {
            margin: 20px 0;
            text-align: center;
        }

        .qr-placeholder {
            width: 150px;
            height: 150px;
            margin: 0 auto 10px;
            background: #f9fafb;
            border: 2px dashed #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #9ca3af;
        }

        .print-button {
            display: block;
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 20px;
            font-family: 'Segoe UI', sans-serif;
        }

        .print-button:hover {
            opacity: 0.9;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .receipt-container {
                max-width: 100%;
                box-shadow: none;
                border: none;
            }

            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-header">
            <div class="store-name">SELLIN KASIR</div>
            <div class="store-tagline">Smart POS System</div>
            <div class="store-info">
                Jl. Contoh No. 123<br>
                Telp: (021) 1234-5678<br>
                Email: info@sellinkasir.com
            </div>
        </div>

        <!-- Order Number -->
        <div class="order-number-big">{{ $order->order_number }}</div>

        <!-- Order Info -->
        <div class="order-info">
            <div class="info-row">
                <span class="info-label">Tanggal:</span>
                <span class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Customer:</span>
                <span class="info-value">{{ $order->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">
                    @if($order->status == 'paid')
                        DIBAYAR
                    @elseif($order->status == 'completed')
                        SELESAI
                    @else
                        {{ strtoupper($order->status) }}
                    @endif
                </span>
            </div>
        </div>

        <!-- Items -->
        <div class="items-section">
            <div class="section-title">Detail Pesanan</div>
            @foreach($order->items as $item)
            <div class="item">
                <div class="item-name">{{ $item->variant->product->name }}</div>
                <div class="item-variant">{{ $item->variant->variant_name }}</div>
                <div class="item-details">
                    <span class="item-qty-price">
                        {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                    </span>
                    <span class="item-subtotal">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="summary-section">
            @if($order->discount_amount > 0)
            <div class="summary-row">
                <span>SUBTOTAL</span>
                <span>Rp {{ number_format($order->total + $order->discount_amount, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row" style="color: #10b981;">
                <span>DISKON MEMBER</span>
                <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="summary-row total">
                <span>TOTAL</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            <div class="payment-method">
                <span style="color: #6b7280;">Metode Pembayaran:</span>
                <span style="font-weight: 600;">
                    @if($order->payment_method == 'balance' || $order->payment_method == 'virtual_card')
                        Kartu Virtual
                    @elseif($order->payment_method == 'cash')
                        Tunai
                    @elseif($order->payment_method == 'transfer')
                        Transfer Bank
                    @else
                        {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                    @endif
                </span>
            </div>
            <div class="payment-method">
                <span style="color: #6b7280;">Status Pembayaran:</span>
                <span class="status-badge status-{{ $order->status }}">
                    @if($order->status == 'paid')
                        LUNAS
                    @elseif($order->status == 'completed')
                        SELESAI
                    @else
                        {{ strtoupper($order->status) }}
                    @endif
                </span>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="qr-section">
            <div class="qr-placeholder">
                <div style="text-align: center;">
                    <div style="font-size: 40px; margin-bottom: 10px;">📱</div>
                    <div>Scan untuk verifikasi</div>
                </div>
            </div>
            <div style="font-size: 11px; color: #6b7280;">
                Tunjukkan struk ini ke kasir
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">TERIMA KASIH!</div>
            <div class="footer-note">
                Simpan struk ini sebagai bukti pembayaran.<br>
                Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.
            </div>
            <div style="font-size: 11px; color: #9ca3af; margin-top: 10px;">
                Dicetak: {{ now()->format('d M Y, H:i:s') }}
            </div>
        </div>

        <!-- Print Button -->
        <button class="print-button" onclick="window.print()">
            🖨️ Cetak Struk
        </button>
    </div>
</body>
</html>
