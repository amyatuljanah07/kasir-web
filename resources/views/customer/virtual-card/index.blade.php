@extends('layouts.customer')

@section('title', 'Kartu Saya')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }

    .card-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-title {
        color: white;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .virtual-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 30px;
        color: white;
        box-shadow: 0 15px 50px rgba(0,0,0,0.3);
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        max-width: 450px;
        margin-left: auto;
        margin-right: auto;
    }

    .virtual-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.3; }
    }

    .card-chip {
        width: 50px;
        height: 40px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        border-radius: 8px;
        margin-bottom: 30px;
        position: relative;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .card-number {
        font-size: 24px;
        font-weight: 600;
        letter-spacing: 3px;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .card-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        position: relative;
        z-index: 1;
    }

    .card-holder {
        font-size: 14px;
        opacity: 0.8;
        margin-bottom: 5px;
    }

    .card-name {
        font-size: 18px;
        font-weight: 600;
    }

    .card-balance-info {
        text-align: right;
    }

    .balance-label {
        font-size: 14px;
        opacity: 0.8;
        margin-bottom: 5px;
    }

    .balance-amount {
        font-size: 32px;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .card-logo {
        position: absolute;
        top: 30px;
        right: 30px;
        font-size: 24px;
        font-weight: 800;
        opacity: 0.3;
        z-index: 0;
    }

    .action-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .action-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .action-icon {
        font-size: 48px;
        margin-bottom: 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .action-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .action-desc {
        font-size: 14px;
        color: #6b7280;
    }

    .orders-section {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-item {
        border-bottom: 1px solid #e5e7eb;
        padding: 20px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-info h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .order-info p {
        font-size: 14px;
        color: #6b7280;
    }

    .order-status {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
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

    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
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

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 64px;
        opacity: 0.3;
        margin-bottom: 15px;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        padding: 40px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .modal-header {
        margin-bottom: 25px;
    }

    .modal-header h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-group input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .form-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn {
        flex: 1;
        padding: 14px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #6b7280;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    @media (max-width: 768px) {
        .virtual-card {
            padding: 30px 20px;
        }

        .card-number {
            font-size: 20px;
        }

        .balance-amount {
            font-size: 24px;
        }

        .action-cards {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="card-container">
    <h1 class="page-title">💳 Kartu Virtual Saya</h1>

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

    <div class="virtual-card">
        <div class="card-logo">SELLIN</div>
        <div class="card-chip"></div>
        <div class="card-number">{{ $virtualCard->card_number }}</div>
        <div class="card-info">
            <div class="card-holder-info">
                <div class="card-holder">PEMEGANG KARTU</div>
                <div class="card-name">{{ strtoupper(auth()->user()->name) }}</div>
                @if(auth()->user()->membership)
                    <div style="margin-top: 5px; font-size: 12px; opacity: 0.9;">
                        {{ auth()->user()->membership->level->name }} Member
                    </div>
                @endif
            </div>
            <div class="card-balance-info">
                <div class="balance-label">SALDO</div>
                <div class="balance-amount">Rp {{ number_format((float)auth()->user()->balance, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="action-cards">
        <a href="{{ route('customer.shop') }}" class="action-card">
            <div class="action-icon">🛒</div>
            <div class="action-title">Belanja Sekarang</div>
            <div class="action-desc">Mulai belanja dengan saldo Anda</div>
        </a>

        <a href="{{ route('customer.balance.topup') }}" class="action-card">
            <div class="action-icon">💰</div>
            <div class="action-title">Top-up Saldo</div>
            <div class="action-desc">Isi saldo untuk belanja</div>
        </a>

        @if(!auth()->user()->membership)
        <a href="{{ route('customer.membership') }}" class="action-card">
            <div class="action-icon">⭐</div>
            <div class="action-title">Join Member</div>
            <div class="action-desc">Dapat diskon & benefit menarik</div>
        </a>
        @else
        <a href="{{ route('customer.membership.exclusive') }}" class="action-card">
            <div class="action-icon">�</div>
            <div class="action-title">Member Exclusive</div>
            <div class="action-desc">Lihat halaman khusus member</div>
        </a>
        @endif

        <div class="action-card" onclick="openPinModal()">
            <div class="action-icon">🔒</div>
            <div class="action-title">Ubah PIN</div>
            <div class="action-desc">Ganti PIN untuk keamanan</div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="orders-section" id="orders">
        <h2 class="section-title">
            <i class="bi bi-clock-history"></i>
            Riwayat Order Terakhir
        </h2>

        @if($orders->count() > 0)
            @foreach($orders as $order)
            <div class="order-item">
                <div class="order-info">
                    <h4>{{ $order->order_number }}</h4>
                    <p>{{ $order->created_at->format('d M Y, H:i') }} • Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
                <span class="order-status status-{{ $order->status }}">
                    @if($order->status == 'pending') ⏳ Pending
                    @elseif($order->status == 'paid') ✅ Dibayar
                    @elseif($order->status == 'verified') 🎉 Diverifikasi
                    @elseif($order->status == 'completed') ✔️ Selesai
                    @else ❌ Dibatalkan
                    @endif
                </span>
            </div>
            @endforeach

            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('customer.orders') }}" class="btn btn-primary" style="display: inline-block; text-decoration: none; max-width: 300px;">
                    Lihat Semua Order
                </a>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>Belum ada order</p>
            </div>
        @endif
    </div>
</div>

<!-- Change PIN Modal -->
<div class="modal" id="pinModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>🔒 Ubah PIN</h3>
        </div>
        <form action="{{ route('customer.virtual-card.change-pin') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="current_pin">PIN Lama</label>
                <input type="password" id="current_pin" name="current_pin" maxlength="4" pattern="[0-9]{4}" placeholder="Masukkan PIN lama" required>
            </div>
            <div class="form-group">
                <label for="new_pin">PIN Baru</label>
                <input type="password" id="new_pin" name="new_pin" maxlength="4" pattern="[0-9]{4}" placeholder="Masukkan PIN baru (4 digit)" required>
            </div>
            <div class="form-group">
                <label for="new_pin_confirmation">Konfirmasi PIN Baru</label>
                <input type="password" id="new_pin_confirmation" name="new_pin_confirmation" maxlength="4" pattern="[0-9]{4}" placeholder="Ulangi PIN baru" required>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-secondary" onclick="closePinModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openPinModal() {
        document.getElementById('pinModal').classList.add('show');
    }

    function closePinModal() {
        document.getElementById('pinModal').classList.remove('show');
    }

    // Close modal when clicking outside
    document.getElementById('pinModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePinModal();
        }
    });

    // Only allow numbers in PIN inputs
    document.querySelectorAll('input[type="password"]').forEach(input => {
        input.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endsection
