@extends('layouts.customer')

@section('title', 'Detail Pesanan')

@section('content')
<style>
    .order-detail-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .back-button:hover {
        gap: 12px;
    }

    .order-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .order-number-large {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .order-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .meta-label {
        font-size: 13px;
        opacity: 0.9;
    }

    .meta-value {
        font-size: 18px;
        font-weight: 600;
    }

    .status-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        border-radius: 30px;
        font-size: 16px;
        font-weight: 600;
        margin-top: 15px;
    }

    .status-paid {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    .status-verified {
        background: #d1fae5;
        color: #065f46;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .content-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .items-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #f9fafb;
        border-radius: 12px;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .item-variant {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .item-qty-price {
        font-size: 14px;
        color: #6b7280;
    }

    .item-subtotal {
        font-size: 18px;
        font-weight: 700;
        color: #667eea;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-top: 1px solid #e5e7eb;
    }

    .summary-row:first-child {
        border-top: none;
    }

    .summary-row.total {
        border-top: 2px solid #e5e7eb;
        padding-top: 20px;
        margin-top: 10px;
    }

    .summary-label {
        font-size: 16px;
        color: #6b7280;
    }

    .summary-value {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }

    .summary-row.total .summary-label {
        font-size: 20px;
        font-weight: 600;
        color: #1f2937;
    }

    .summary-row.total .summary-value {
        font-size: 28px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .info-box {
        background: #dbeafe;
        border-left: 4px solid #3b82f6;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }

    .info-box.success {
        background: #d1fae5;
        border-left-color: #10b981;
    }

    .info-box h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-box p {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.6;
    }

    .verification-card {
        background: linear-gradient(135deg, #f0fdf4 0%, #d1fae5 100%);
        border-radius: 16px;
        padding: 25px;
        margin-top: 20px;
        border: 2px solid #6ee7b7;
    }

    .verification-card h4 {
        font-size: 18px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .verifier-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .verifier-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 20px;
    }

    .verifier-details h5 {
        font-size: 16px;
        font-weight: 600;
        color: #065f46;
        margin-bottom: 3px;
    }

    .verifier-details p {
        font-size: 14px;
        color: #059669;
    }

    @media (max-width: 768px) {
        .order-header-card {
            padding: 25px;
        }

        .order-number-large {
            font-size: 24px;
        }

        .order-meta-grid {
            grid-template-columns: 1fr;
        }

        .item-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .item-subtotal {
            align-self: flex-end;
        }
    }
</style>

<div class="order-detail-container">
    <a href="{{ route('customer.orders') }}" class="back-button">
        <i class="bi bi-arrow-left"></i>
        Kembali ke Daftar Pesanan
    </a>

    <!-- Order Header -->
    <div class="order-header-card">
        <h1 class="order-number-large">{{ $order->order_number }}</h1>
        
        <div class="status-badge-large status-{{ $order->status }}">
            @if($order->status == 'pending')
                <i class="bi bi-hourglass-split"></i> Pending
            @elseif($order->status == 'paid')
                <i class="bi bi-check-circle"></i> Dibayar - Menunggu Pickup
            @elseif($order->status == 'verified')
                <i class="bi bi-patch-check"></i> Diverifikasi
            @elseif($order->status == 'completed')
                <i class="bi bi-check-all"></i> Selesai
            @else
                <i class="bi bi-x-circle"></i> Dibatalkan
            @endif
        </div>

        <div class="order-meta-grid">
            <div class="meta-item">
                <span class="meta-label">📅 Tanggal Order</span>
                <span class="meta-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">💳 Metode Pembayaran</span>
                <span class="meta-value">
                    @if($order->payment_method == 'balance')
                        Kartu Virtual
                    @elseif($order->payment_method == 'virtual_card')
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
            <div class="meta-item">
                <span class="meta-label">👤 Atas Nama</span>
                <span class="meta-value">{{ $order->user->name }}</span>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="content-card">
        <h2 class="section-title">
            <i class="bi bi-box-seam"></i>
            Detail Pesanan
        </h2>

        <div class="items-list">
            @foreach($order->items as $item)
            <div class="item-row">
                <div class="item-details">
                    <div class="item-name">{{ $item->variant->product->name }}</div>
                    <div class="item-variant">{{ $item->variant->variant_name }}</div>
                    <div class="item-qty-price">
                        {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                    </div>
                </div>
                <div class="item-subtotal">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Payment Summary -->
    <div class="content-card">
        <h2 class="section-title">
            <i class="bi bi-receipt"></i>
            Ringkasan Pembayaran
        </h2>

        @if($order->discount_amount > 0)
        <div class="summary-row">
            <span class="summary-label">Subtotal</span>
            <span class="summary-value">Rp {{ number_format($order->total + $order->discount_amount, 0, ',', '.') }}</span>
        </div>

        <div class="summary-row" style="color: #10b981;">
            <span class="summary-label">
                <i class="bi bi-gift-fill"></i> Diskon Member
            </span>
            <span class="summary-value">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="summary-row total">
            <span class="summary-label">Total Pembayaran</span>
            <span class="summary-value">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
        </div>

        <!-- Tombol Lihat Struk - Untuk semua status yang sudah dibayar -->
        @if(in_array($order->status, ['paid', 'verified', 'completed']))
        <div style="margin-top: 25px; text-align: center;">
            <a href="{{ route('customer.orders.receipt', $order->id) }}" target="_blank" 
               style="display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 16px; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3); transition: transform 0.2s;"
               onmouseover="this.style.transform='translateY(-2px)'"
               onmouseout="this.style.transform='translateY(0)'">
                <i class="bi bi-receipt-cutoff" style="font-size: 24px;"></i>
                <span>📄 Lihat Struk Digital</span>
            </a>
        </div>
        @endif

        @if($order->status == 'paid')
        <div class="info-box">
            <h4><i class="bi bi-info-circle-fill"></i> Pesanan Menunggu Pickup</h4>
            <p>
                Tunjukkan kode order <strong>{{ $order->order_number }}</strong> ke kasir untuk mengambil pesanan Anda.
                Kasir akan memverifikasi pesanan sebelum menyerahkan barang.
            </p>
        </div>
        @endif

        @if($order->verified_by && in_array($order->status, ['verified', 'completed']))
        <div class="verification-card">
            <h4>
                <i class="bi bi-patch-check-fill"></i>
                Pesanan Diverifikasi
            </h4>
            <div class="verifier-info">
                <div class="verifier-avatar">
                    {{ strtoupper(substr($order->verifier->name, 0, 1)) }}
                </div>
                <div class="verifier-details">
                    <h5>{{ $order->verifier->name }}</h5>
                    <p>{{ $order->verified_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($order->status == 'completed')
        <div class="info-box success">
            <h4><i class="bi bi-check-circle-fill"></i> Transaksi Selesai</h4>
            <p>
                Terima kasih telah berbelanja! Pesanan Anda telah selesai dan barang sudah diserahkan.
            </p>
        </div>
        @endif
    </div>
</div>
@endsection
