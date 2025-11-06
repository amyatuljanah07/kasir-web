<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
            max-width: 300px;
            margin: 0 auto;
        }
        
        .receipt {
            border: 1px dashed #333;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 1px dashed #333;
            padding-bottom: 10px;
        }
        
        .store-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .store-info {
            font-size: 11px;
            color: #555;
        }
        
        .section {
            margin-bottom: 15px;
        }
        
        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .items-table {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .item-row {
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #ddd;
        }
        
        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .item-variant {
            font-size: 11px;
            color: #666;
            margin-bottom: 2px;
        }
        
        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        
        .total-section {
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 13px;
        }
        
        .grand-total {
            font-weight: bold;
            font-size: 16px;
            border-top: 1px solid #333;
            padding-top: 5px;
            margin-top: 5px;
        }
        
        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #333;
            font-size: 11px;
        }
        
        .thank-you {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .receipt {
                border: none;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(139, 92, 246, 0.2);
        }
        
        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(139, 92, 246, 0.3);
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">🖨️ Cetak Struk</button>
    
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="store-name">SELLIN KASIR</div>
            <div class="store-info">Smart POS System</div>
            <div class="store-info">Virtual Card Payment</div>
        </div>
        
        <!-- Order Info -->
        <div class="section">
            <div class="section-title">INFORMASI PESANAN</div>
            <div class="info-row">
                <span>No. Pesanan:</span>
                <span><strong>{{ $order->order_number }}</strong></span>
            </div>
            <div class="info-row">
                <span>Tanggal:</span>
                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span>Pelanggan:</span>
                <span>{{ $order->user->name }}</span>
            </div>
            @if($order->user->phone)
            <div class="info-row">
                <span>Telepon:</span>
                <span>{{ $order->user->phone }}</span>
            </div>
            @endif
        </div>
        
        <!-- Items -->
        <div class="section">
            <div class="section-title">DETAIL PESANAN</div>
            <div class="items-table">
                @foreach($order->items as $item)
                <div class="item-row">
                    <div class="item-name">{{ $item->variant->product->name }}</div>
                    @if($item->variant->variant_name !== 'Default')
                    <div class="item-variant">Varian: {{ $item->variant->variant_name }}</div>
                    @endif
                    <div class="item-details">
                        <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Totals -->
        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <!-- Payment Info -->
        <div class="section">
            <div class="section-title">PEMBAYARAN</div>
            <div class="info-row">
                <span>Metode:</span>
                <span><strong>{{ strtoupper($order->payment_method) }}</strong></span>
            </div>
            @if($order->payment_method === 'virtual_card')
            <div class="info-row">
                <span>Kartu:</span>
                <span>{{ $order->user->virtualCard->card_number }}</span>
            </div>
            @endif
            <div class="info-row">
                <span>Status:</span>
                <span><strong>LUNAS</strong></span>
            </div>
        </div>
        
        <!-- Verification Info -->
        @if($order->verified_by)
        <div class="section">
            <div class="section-title">VERIFIKASI</div>
            <div class="info-row">
                <span>Diverifikasi oleh:</span>
                <span>{{ $order->verifier->name }}</span>
            </div>
            <div class="info-row">
                <span>Waktu:</span>
                <span>{{ $order->verified_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
        @endif
        
        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">Terima Kasih!</div>
            <div>Silakan tunjukkan struk ini saat pengambilan</div>
            <div style="margin-top: 10px;">{{ $order->created_at->format('d M Y H:i:s') }}</div>
        </div>
    </div>
    
    <script>
        // Auto print ketika halaman dibuka (opsional)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html>
