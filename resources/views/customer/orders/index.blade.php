@extends('layouts.customer')

@section('title', 'Pesanan Saya')

@section('content')
<style>
    .orders-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .order-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .order-info h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .order-date {
        font-size: 14px;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .order-status {
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-paid {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-verified {
        background: #d1fae5;
        color: #065f46;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .order-items {
        border-top: 2px solid #f3f4f6;
        border-bottom: 2px solid #f3f4f6;
        padding: 20px 0;
        margin-bottom: 20px;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
    }

    .item-details h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .item-details p {
        font-size: 14px;
        color: #6b7280;
    }

    .item-price {
        font-size: 16px;
        font-weight: 700;
        color: #667eea;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .order-total {
        text-align: right;
    }

    .total-label {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .total-amount {
        font-size: 28px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .order-actions {
        display: flex;
        gap: 10px;
    }

    .btn-detail {
        padding: 12px 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .verification-info {
        background: #f9fafb;
        border-radius: 12px;
        padding: 15px;
        margin-top: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .verification-info i {
        font-size: 24px;
        color: #667eea;
    }

    .verification-info div h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 3px;
    }

    .verification-info div p {
        font-size: 13px;
        color: #6b7280;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 80px;
        opacity: 0.3;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #1f2937;
    }

    .empty-state p {
        font-size: 16px;
        margin-bottom: 30px;
    }

    .btn-shop {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-shop:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 40px;
    }

    .pagination a, .pagination span {
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .pagination a {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .pagination a:hover {
        background: #667eea;
        color: white;
    }

    .pagination .active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
        }

        .order-footer {
            flex-direction: column-reverse;
            align-items: flex-start;
        }

        .order-total {
            text-align: left;
            width: 100%;
        }

        .order-actions {
            width: 100%;
        }

        .btn-detail {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<div class="orders-container">
    <h1 class="page-title">
        <i class="bi bi-bag-check"></i>
        Pesanan Saya
    </h1>

    @if($orders->count() > 0)
        <div class="orders-list">
            @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div class="order-info">
                        <h3>{{ $order->order_number }}</h3>
                        <p class="order-date">
                            <i class="bi bi-calendar"></i>
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <span class="order-status status-{{ $order->status }}">
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
                    </span>
                </div>

                <div class="order-items">
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="item-details">
                            <h4>{{ $item->variant->product->name }}</h4>
                            <p>{{ $item->variant->variant_name }} × {{ $item->quantity }}</p>
                        </div>
                        <span class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="order-footer">
                    <div class="order-actions">
                        <a href="{{ route('customer.orders.show', $order->id) }}" class="btn-detail">
                            <i class="bi bi-eye"></i>
                            Lihat Detail
                        </a>
                    </div>

                    <div class="order-total">
                        <div class="total-label">Total Pembayaran</div>
                        <div class="total-amount">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    </div>
                </div>

                @if($order->status == 'paid')
                <div class="verification-info">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        <h5>📦 Pesanan Menunggu Pickup</h5>
                        <p>Silakan tunjukkan kode order ini ke kasir untuk mengambil pesanan Anda</p>
                    </div>
                </div>
                @endif

                @if($order->verified_by && in_array($order->status, ['verified', 'completed']))
                <div class="verification-info">
                    <i class="bi bi-person-check-fill"></i>
                    <div>
                        <h5>✅ Diverifikasi oleh {{ $order->verifier->name }}</h5>
                        <p>{{ $order->verified_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="pagination">
            {{ $orders->links() }}
        </div>
        @endif

    @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h3>Belum Ada Pesanan</h3>
            <p>Mulai belanja sekarang dan nikmati kemudahan pembayaran dengan Virtual Card!</p>
            <a href="{{ route('customer.shop') }}" class="btn-shop">
                <i class="bi bi-cart-plus"></i>
                Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
