<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Order - Kasir | Sellin Kasir</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #f9fafb;
    }

    /* Navbar Styles */
    .navbar {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 15px 0;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .navbar-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .navbar-brand i {
        font-size: 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .navbar-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }

    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .btn-nav {
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-pos {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-pos:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-report {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .btn-report:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
    }

    .btn-logout {
        background: #ef4444;
        color: white;
    }

    .btn-logout:hover {
        background: #dc2626;
    }

    .time-display {
        font-size: 14px;
        color: #6b7280;
    }

    .verification-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .page-header {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .page-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-header p {
        font-size: 16px;
        color: #6b7280;
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        border-left: 4px solid;
    }

    .stat-card.pending {
        border-left-color: #f59e0b;
    }

    .stat-card.verified {
        border-left-color: #10b981;
    }

    .stat-icon {
        font-size: 40px;
        margin-bottom: 15px;
    }

    .stat-label {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .orders-grid {
        display: grid;
        gap: 20px;
        margin-bottom: 40px;
    }

    .order-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border-left: 4px solid #f59e0b;
    }

    .order-card.verified {
        border-left-color: #10b981;
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

    .order-number {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .order-meta {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6b7280;
    }

    .meta-item i {
        font-size: 16px;
    }

    .customer-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .order-items {
        background: #f9fafb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .order-items h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 15px;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .item-row:last-child {
        border-bottom: none;
    }

    .item-name {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 3px;
    }

    .item-variant {
        font-size: 13px;
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
        gap: 20px;
    }

    .total-section {
        text-align: right;
    }

    .total-label {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .total-amount {
        font-size: 32px;
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

    .btn {
        padding: 14px 24px;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-family: 'Poppins', sans-serif;
    }

    .btn-verify {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-verify:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-complete {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-complete:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .verified-badge {
        background: #d1fae5;
        color: #065f46;
        padding: 10px 20px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .verifier-info {
        background: #f9fafb;
        border-radius: 12px;
        padding: 15px;
        margin-top: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .verifier-info i {
        font-size: 24px;
        color: #667eea;
    }

    .verifier-info div h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 3px;
    }

    .verifier-info div p {
        font-size: 13px;
        color: #6b7280;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #6b7280;
        background: white;
        border-radius: 20px;
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

    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(5px);
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 24px;
        padding: 40px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .modal-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .modal-header h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .modal-header p {
        font-size: 16px;
        color: #6b7280;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
    }

    .form-group input {
        width: 100%;
        padding: 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 600;
        text-align: center;
        letter-spacing: 3px;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        text-transform: uppercase;
    }

    .form-group input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #6b7280;
        flex: 1;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        flex: 1;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
        }

        .order-footer {
            flex-direction: column-reverse;
            align-items: flex-start;
        }

        .total-section {
            text-align: left;
            width: 100%;
        }

        .order-actions {
            width: 100%;
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('pos.index') }}" class="navbar-brand">
                <i class="bi bi-wallet2"></i>
                <span class="navbar-title">Verifikasi Order - {{ auth()->user()->name }}</span>
            </a>
            <div class="navbar-actions">
                <a href="{{ route('pos.index') }}" class="btn-nav btn-pos">
                    <i class="bi bi-cash-register"></i> Kembali ke POS
                </a>
                <a href="{{ route('cashier.reports') }}" class="btn-nav btn-report">
                    <i class="bi bi-file-earmark-bar-graph"></i> Laporan Saya
                </a>
                <span class="time-display">
                    <i class="bi bi-clock"></i> {{ now()->format('d M Y, H:i') }}
                </span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-nav btn-logout">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

<div class="verification-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>
            <i class="bi bi-shield-check"></i>
            Verifikasi Pesanan Virtual Card
        </h1>
        <p>Verifikasi dan serahkan pesanan customer yang telah dibayar dengan Virtual Card</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="bi bi-x-circle"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="stat-card pending">
            <div class="stat-icon">⏳</div>
            <div class="stat-label">Menunggu Pickup</div>
            <div class="stat-value">{{ $pendingOrders->count() }}</div>
        </div>
        <div class="stat-card verified">
            <div class="stat-icon">✅</div>
            <div class="stat-label">Diverifikasi Hari Ini</div>
            <div class="stat-value">{{ $verifiedToday->count() }}</div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div>
        <h2 class="section-title">
            <i class="bi bi-hourglass-split"></i>
            Pesanan Menunggu Pickup ({{ $pendingOrders->count() }})
        </h2>

        @if($pendingOrders->count() > 0)
            <div class="orders-grid">
                @foreach($pendingOrders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h3 class="order-number">{{ $order->order_number }}</h3>
                            <div class="order-meta">
                                <span class="meta-item">
                                    <i class="bi bi-calendar"></i>
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </span>
                                <span class="meta-item">
                                    <i class="bi bi-credit-card"></i>
                                    Virtual Card
                                </span>
                            </div>
                        </div>
                        <span class="customer-badge">
                            <i class="bi bi-person"></i>
                            {{ $order->user->name }}
                        </span>
                    </div>

                    <div class="order-items">
                        <h4>📦 Items:</h4>
                        @foreach($order->items as $item)
                        <div class="item-row">
                            <div>
                                <div class="item-name">{{ $item->variant->product->name }}</div>
                                <div class="item-variant">{{ $item->variant->variant_name }} × {{ $item->quantity }}</div>
                            </div>
                            <div class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="order-footer">
                        <div class="order-actions">
                            <button class="btn btn-verify" onclick="openVerifyModal({{ $order->id }}, '{{ $order->order_number }}')">
                                <i class="bi bi-shield-check"></i>
                                Verifikasi & Serahkan
                            </button>
                        </div>

                        <div class="total-section">
                            <div class="total-label">Total</div>
                            <div class="total-amount">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h3>Tidak Ada Pesanan Menunggu</h3>
                <p>Semua pesanan sudah diverifikasi atau belum ada pesanan baru</p>
            </div>
        @endif
    </div>

    <!-- Verified Today -->
    @if($verifiedToday->count() > 0)
    <div style="margin-top: 50px;">
        <h2 class="section-title">
            <i class="bi bi-check-circle"></i>
            Sudah Diverifikasi Hari Ini ({{ $verifiedToday->count() }})
        </h2>

        <div class="orders-grid">
            @foreach($verifiedToday as $order)
            <div class="order-card verified">
                <div class="order-header">
                    <div>
                        <h3 class="order-number">{{ $order->order_number }}</h3>
                        <div class="order-meta">
                            <span class="meta-item">
                                <i class="bi bi-calendar"></i>
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>
                    <span class="verified-badge">
                        <i class="bi bi-check-circle"></i>
                        Diverifikasi
                    </span>
                </div>

                <div class="order-items">
                    <h4>📦 Items:</h4>
                    @foreach($order->items as $item)
                    <div class="item-row">
                        <div>
                            <div class="item-name">{{ $item->variant->product->name }}</div>
                            <div class="item-variant">{{ $item->variant->variant_name }} × {{ $item->quantity }}</div>
                        </div>
                        <div class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>

                <div class="verifier-info">
                    <i class="bi bi-person-check-fill"></i>
                    <div>
                        <h5>Diverifikasi oleh {{ $order->verifier->name }}</h5>
                        <p>{{ $order->verified_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="order-footer" style="margin-top: 20px;">
                    <div class="order-actions">
                        <span class="customer-badge">
                            <i class="bi bi-person"></i>
                            {{ $order->user->name }}
                        </span>
                        <a href="{{ route('cashier.verification.print', $order->id) }}" target="_blank" class="btn btn-complete">
                            <i class="bi bi-printer"></i>
                            Cetak Struk
                        </a>
                    </div>

                    <div class="total-section">
                        <div class="total-label">Total</div>
                        <div class="total-amount">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Verify Modal -->
<div class="modal" id="verifyModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>🔍 Verifikasi Pesanan</h3>
            <p>Minta customer menunjukkan kode order mereka</p>
        </div>

        <form id="verifyForm" method="POST">
            @csrf
            <div class="form-group">
                <label for="order_number">Masukkan Kode Order</label>
                <input type="text" id="order_number" name="order_number" placeholder="ORD-20250128-0001" required autocomplete="off">
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-secondary" onclick="closeVerifyModal()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-shield-check"></i> Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentOrderId = null;

    function openVerifyModal(orderId, orderNumber) {
        currentOrderId = orderId;
        document.getElementById('order_number').value = '';
        document.getElementById('order_number').placeholder = orderNumber;
        document.getElementById('verifyForm').action = `/cashier/verification/${orderId}/verify`;
        document.getElementById('verifyModal').classList.add('show');
        document.getElementById('order_number').focus();
    }

    function closeVerifyModal() {
        document.getElementById('verifyModal').classList.remove('show');
        currentOrderId = null;
    }

    // Close modal when clicking outside
    document.getElementById('verifyModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeVerifyModal();
        }
    });

    // Auto uppercase
    document.getElementById('order_number').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });
</script>
</body>
</html>
