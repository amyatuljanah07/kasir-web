<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Penjualan Saya - Kasir | Sellin Kasir</title>
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

    .btn-verification {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-verification:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
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

    .reports-container {
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

    .filter-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select {
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 20px;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #6b7280;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }

    .stats-grid {
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
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }

    .stat-card.blue::before {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-card.green::before {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-card.yellow::before {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-card.purple::before {
        background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .stat-label {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
    }

    .stat-icon {
        font-size: 32px;
        opacity: 0.3;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .payment-summary {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .payment-summary h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .payment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .payment-item {
        background: #f9fafb;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .payment-item:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
    }

    .payment-method {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .payment-count {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .payment-total {
        font-size: 20px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .table-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .table-header {
        background: #f9fafb;
        padding: 20px 30px;
        border-bottom: 2px solid #e5e7eb;
    }

    .table-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f9fafb;
    }

    th {
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    th.text-right {
        text-align: right;
    }

    tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s ease;
    }

    tbody tr:hover {
        background: #f9fafb;
    }

    td {
        padding: 16px 20px;
        font-size: 14px;
        color: #374151;
    }

    td.text-right {
        text-align: right;
    }

    .customer-name {
        font-weight: 600;
        color: #1f2937;
    }

    .member-badge {
        display: inline-block;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        font-size: 10px;
        padding: 4px 8px;
        border-radius: 8px;
        font-weight: 600;
        margin-left: 8px;
    }

    .payment-badge {
        display: inline-block;
        background: #f3f4f6;
        color: #6b7280;
        font-size: 11px;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .discount-text {
        color: #f59e0b;
        font-weight: 600;
    }

    .total-text {
        color: #10b981;
        font-weight: 700;
    }

    tfoot {
        background: #ecfdf5;
        border-top: 2px solid #10b981;
    }

    tfoot th {
        padding: 20px;
        font-size: 14px;
        font-weight: 700;
        color: #1f2937;
    }

    .grand-total {
        font-size: 20px !important;
        color: #10b981 !important;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state-icon {
        font-size: 80px;
        opacity: 0.3;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .empty-state p {
        font-size: 16px;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .table-wrapper {
            overflow-x: scroll;
        }
    }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('pos.index') }}" class="navbar-brand">
                <i class="bi bi-bar-chart-fill"></i>
                <span class="navbar-title">Laporan Penjualan - {{ auth()->user()->name }}</span>
            </a>
            <div class="navbar-actions">
                <a href="{{ route('pos.index') }}" class="btn-nav btn-pos">
                    <i class="bi bi-cash-register"></i> Kembali ke POS
                </a>
                <a href="{{ route('cashier.verification') }}" class="btn-nav btn-verification">
                    <i class="bi bi-shield-check"></i> Verifikasi Order
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

<div class="reports-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>
            <i class="bi bi-bar-chart-fill"></i>
            Laporan Penjualan Saya
        </h1>
        <p>Tutup Kasir & Rekap Transaksi</p>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <form method="GET" action="{{ route('cashier.reports') }}">
            <div class="filter-grid">
                <div class="form-group">
                    <label><i class="bi bi-calendar-event"></i> Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label><i class="bi bi-calendar-check"></i> Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label><i class="bi bi-credit-card"></i> Metode Pembayaran</label>
                    <select name="payment_method">
                        <option value="">Semua Metode</option>
                        <option value="tunai" {{ request('payment_method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Transfer Bank</option>
                    </select>
                </div>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('cashier.reports') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
                <a href="{{ route('cashier.reports.export', request()->all()) }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Total Transaksi</div>
                    <div class="stat-value">{{ $totalTransaksi }}</div>
                </div>
                <div class="stat-icon">🧾</div>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Total Penjualan</div>
                    <div class="stat-value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon">💰</div>
            </div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Total Diskon</div>
                    <div class="stat-value">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon">🏷️</div>
            </div>
        </div>
        <div class="stat-card purple">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Keuntungan</div>
                    <div class="stat-value">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon">📈</div>
            </div>
        </div>
    </div>

    <!-- Payment Summary -->
    @if($paymentSummary->count() > 0)
    <div class="payment-summary">
        <h3><i class="bi bi-credit-card"></i> Ringkasan per Metode Pembayaran</h3>
        <div class="payment-grid">
            @foreach($paymentSummary as $method => $data)
            <div class="payment-item">
                <div class="payment-method">
                    @if($method === 'tunai')
                        💵 TUNAI
                    @elseif($method === 'bank')
                        🏦 TRANSFER BANK
                    @else
                        {{ strtoupper($method) }}
                    @endif
                </div>
                <div class="payment-count">{{ $data['count'] }} transaksi</div>
                <div class="payment-total">Rp {{ number_format($data['total'], 0, ',', '.') }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Transaction Table -->
    <div class="table-card">
        <div class="table-header">
            <h3><i class="bi bi-list-check"></i> Daftar Transaksi</h3>
        </div>
        <div class="table-wrapper">
            @if($sales->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Metode</th>
                        <th>Diskon</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $index => $sale)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="customer-name">{{ $sale->user ? $sale->user->name : 'Guest' }}</span>
                            @if($sale->user && $sale->user->is_member)
                                <span class="member-badge">⭐ MEMBER</span>
                            @endif
                        </td>
                        <td style="font-size: 12px;">
                            @foreach($sale->items as $item)
                                <div>{{ $item->variant->product->name }} ({{ $item->quantity }}x)</div>
                            @endforeach
                        </td>
                        <td>
                            <span class="payment-badge">
                                @if($sale->payment_method === 'tunai')
                                    💵 TUNAI
                                @elseif($sale->payment_method === 'bank')
                                    🏦 BANK
                                @else
                                    {{ strtoupper($sale->payment_method) }}
                                @endif
                            </span>
                        </td>
                        <td>
                            @if($sale->discount > 0)
                                <span class="discount-text">-Rp {{ number_format($sale->discount, 0, ',', '.') }}</span>
                            @else
                                <span style="color: #9ca3af;">-</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <span class="total-text">Rp {{ number_format($sale->total, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align: right;">GRAND TOTAL:</th>
                        <th class="text-right grand-total">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
            @else
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h3>Belum Ada Transaksi</h3>
                <p>Belum ada transaksi pada periode ini</p>
            </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>
