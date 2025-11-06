<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS - Kasir | Sellin Kasir</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: #F9FAFB;
            color: #1E293B;
        }
        
        /* Modern Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .navbar-brand i {
            font-size: 2rem;
            background: linear-gradient(135deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .navbar-title {
            background: linear-gradient(135deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .btn-nav {
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }
        
        .btn-report {
            background: #EFF6FF;
            color: #3B82F6;
        }
        
        .btn-report:hover {
            background: #3B82F6;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
            border: none;
            cursor: pointer;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        .time-display {
            color: #64748B;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .grid-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        
        /* Card Styles */
        .card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .card-title i {
            color: #3B82F6;
        }
        
        /* Scan Section */
        .scan-section {
            margin-bottom: 1.5rem;
        }
        
        .scan-label {
            display: block;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .scan-input-group {
            display: flex;
            gap: 0.8rem;
        }
        
        .scan-input {
            flex: 1;
            padding: 0.85rem 1rem;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: #F8FAFC;
        }
        
        .scan-input:focus {
            outline: none;
            border-color: #3B82F6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        .btn-scan {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            color: white;
            padding: 0.85rem 1.5rem;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .btn-scan:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            max-height: 600px;
            overflow-y: auto;
            padding-right: 0.5rem;
        }
        
        .product-grid::-webkit-scrollbar {
            width: 6px;
        }
        
        .product-grid::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 10px;
        }
        
        .product-grid::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }
        
        .product-card {
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            padding: 0.8rem;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: #3B82F6;
        }
        
        .product-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 0.8rem;
        }
        
        .product-image-placeholder {
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, #E2E8F0, #CBD5E1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.8rem;
        }
        
        .product-image-placeholder i {
            font-size: 2.5rem;
            color: #94A3B8;
        }
        
        .product-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: #1E293B;
            margin-bottom: 0.3rem;
        }
        
        .product-variant {
            font-size: 0.8rem;
            color: #64748B;
            margin-bottom: 0.5rem;
        }
        
        .product-price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .product-price-old {
            font-size: 0.75rem;
            color: #94A3B8;
            text-decoration: line-through;
        }
        
        .product-price {
            font-weight: 700;
            font-size: 0.9rem;
            color: #1E293B;
        }
        
        .product-price-discount {
            font-weight: 700;
            font-size: 0.9rem;
            color: #10B981;
        }
        
        .product-stock {
            font-size: 0.75rem;
            background: #DBEAFE;
            color: #1E40AF;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-weight: 600;
        }
        
        .product-discount-badge {
            display: inline-block;
            font-size: 0.75rem;
            background: #FEE2E2;
            color: #991B1B;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-weight: 600;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #94A3B8;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #CBD5E1;
            display: block;
            margin-bottom: 1rem;
        }
        
        /* Cart Sidebar */
        .cart-sidebar {
            position: sticky;
            top: 100px;
        }
        
        .customer-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #F1F5F9;
        }
        
        .customer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.8rem;
        }
        
        .customer-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .form-select, .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #E2E8F0;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.3s;
            background: #F8FAFC;
            margin-bottom: 0.8rem;
        }
        
        .form-select:focus, .form-input:focus {
            outline: none;
            border-color: #3B82F6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        .member-badge {
            background: #FEF3C7;
            border: 2px solid #FDE68A;
            border-radius: 10px;
            padding: 0.8rem;
            text-align: center;
            margin-top: 0.8rem;
        }
        
        .member-badge-text {
            color: #92400E;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .member-badge i {
            color: #F59E0B;
        }
        
        /* Cart Items */
        .cart-items-container {
            max-height: 280px;
            overflow-y: auto;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #F1F5F9;
        }
        
        .cart-items-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .cart-items-container::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 10px;
        }
        
        .cart-items-container::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }
        
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #F1F5F9;
        }
        
        .cart-item-info {
            flex: 1;
        }
        
        .cart-item-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: #1E293B;
            margin-bottom: 0.3rem;
        }
        
        .cart-item-details {
            font-size: 0.8rem;
            color: #64748B;
        }
        
        .cart-item-actions {
            text-align: right;
        }
        
        .cart-item-price {
            font-weight: 700;
            font-size: 0.95rem;
            color: #1E293B;
            margin-bottom: 0.5rem;
        }
        
        .cart-item-buttons {
            display: flex;
            gap: 0.3rem;
        }
        
        .btn-cart-action {
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            border: none;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-minus {
            background: #FEE2E2;
            color: #991B1B;
        }
        
        .btn-minus:hover {
            background: #EF4444;
            color: white;
        }
        
        .btn-plus {
            background: #D1FAE5;
            color: #065F46;
        }
        
        .btn-plus:hover {
            background: #10B981;
            color: white;
        }
        
        .btn-remove {
            background: #F1F5F9;
            color: #64748B;
        }
        
        .btn-remove:hover {
            background: #94A3B8;
            color: white;
        }
        
        /* Price Summary */
        .price-summary {
            margin-bottom: 1.5rem;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            font-size: 0.9rem;
            color: #475569;
        }
        
        .price-row-discount {
            color: #10B981;
        }
        
        .price-row-total {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1E293B;
            padding-top: 0.8rem;
            border-top: 2px solid #E2E8F0;
        }
        
        .price-row-total .price-value {
            color: #3B82F6;
        }
        
        /* Payment Section */
        .payment-section {
            margin-bottom: 1.5rem;
        }
        
        .change-display {
            background: #D1FAE5;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .change-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .change-label {
            font-weight: 600;
            color: #065F46;
        }
        
        .change-amount {
            font-size: 1.3rem;
            font-weight: 700;
            color: #10B981;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }
        
        .btn-checkout {
            width: 100%;
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        
        .btn-reset {
            width: 100%;
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
            padding: 0.8rem;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        /* Modal */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .modal.hidden {
            display: none;
        }
        
        .modal-content {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .modal-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1E293B;
        }
        
        .btn-close {
            background: none;
            border: none;
            color: #64748B;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-close:hover {
            color: #1E293B;
        }
        
        .form-group {
            margin-bottom: 1.2rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .required {
            color: #EF4444;
        }
        
        .form-help {
            font-size: 0.8rem;
            color: #64748B;
            margin-top: 0.3rem;
        }
        
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #E2E8F0;
            border-radius: 10px;
            font-size: 0.9rem;
            resize: vertical;
            min-height: 80px;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        .info-box {
            background: #FEF3C7;
            border: 2px solid #FDE68A;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .info-box-text {
            font-size: 0.85rem;
            color: #92400E;
        }
        
        .info-box i {
            color: #F59E0B;
        }
        
        .modal-buttons {
            display: flex;
            gap: 0.8rem;
        }
        
        .btn-modal {
            flex: 1;
            padding: 0.8rem;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-cancel {
            background: #F1F5F9;
            color: #475569;
        }
        
        .btn-cancel:hover {
            background: #E2E8F0;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            color: white;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        /* Notification */
        .notification {
            position: fixed;
            top: 100px;
            right: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 2000;
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .notification-success {
            background: linear-gradient(135deg, #10B981, #059669);
        }
        
        .notification-error {
            background: linear-gradient(135deg, #EF4444, #DC2626);
        }
        
        .notification-info {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .grid-container {
                grid-template-columns: 1fr;
            }
            
            .cart-sidebar {
                position: static;
            }
            
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            
            .navbar {
                padding: 1rem;
            }
            
            .navbar-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .navbar-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .time-display {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <i class="bi bi-wallet2"></i>
                <span class="navbar-title">POS Kasir - {{ auth()->user()->name }}</span>
            </div>
            <div class="navbar-actions">
                @if(auth()->user()->role->name == 'pegawai')
                <a href="{{ route('cashier.verification') }}" class="btn-nav btn-report" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="bi bi-shield-check"></i> Verifikasi Order
                </a>
                <a href="{{ route('cashier.reports') }}" class="btn-nav btn-report">
                    <i class="bi bi-file-earmark-bar-graph"></i> Laporan Saya
                </a>
                @endif
                <span class="time-display">
                    <i class="bi bi-clock"></i> {{ now()->format('d M Y, H:i') }}
                </span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    <button type="submit" class="btn-nav btn-logout">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="grid-container">
            <!-- Katalog Barang -->
            <div>
                <div class="card">
                    <h2 class="card-title">
                        <i class="bi bi-grid-3x3"></i> Katalog Barang
                    </h2>
                    
                    <!-- Scan Barcode -->
                    <div class="scan-section">
                        <label class="scan-label">
                            <i class="bi bi-upc-scan"></i> Scan Barcode
                        </label>
                        <div class="scan-input-group">
                            <input type="text" 
                                   id="barcodeInput" 
                                   class="scan-input" 
                                   placeholder="Scan atau ketik barcode...">
                            <button onclick="scanBarcode()" class="btn-scan">
                                <i class="bi bi-upc-scan"></i> Scan
                            </button>
                        </div>
                    </div>

                    <!-- Grid Produk -->
                    <div class="product-grid">
                        @forelse($products as $product)
                            @foreach($product->variants as $variant)
                            <div class="product-card" 
                                 onclick="addToCart({{ $variant->id }}, '{{ $product->name }} - {{ $variant->variant_name }}', {{ $variant->price }}, {{ $variant->discount }}, {{ $variant->stock }})">
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="product-image">
                                @else
                                <div class="product-image-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                                @endif
                                
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-variant">{{ $variant->variant_name }}</div>
                                
                                <div class="product-price-row">
                                    <div>
                                        @if($variant->discount > 0)
                                        <div class="product-price-old">Rp {{ number_format($variant->price, 0, ',', '.') }}</div>
                                        <div class="product-price-discount">
                                            Rp {{ number_format($variant->price * (1 - $variant->discount/100), 0, ',', '.') }}
                                        </div>
                                        @else
                                        <div class="product-price">
                                            Rp {{ number_format($variant->price, 0, ',', '.') }}
                                        </div>
                                        @endif
                                    </div>
                                    <span class="product-stock">
                                        Stok: {{ $variant->stock }}
                                    </span>
                                </div>
                                
                                @if($variant->discount > 0)
                                <span class="product-discount-badge">
                                    -{{ $variant->discount }}%
                                </span>
                                @endif
                            </div>
                            @endforeach
                        @empty
                        <div class="empty-state" style="grid-column: 1 / -1;">
                            <i class="bi bi-inbox"></i>
                            <p>Tidak ada barang tersedia</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Keranjang & Pembayaran -->
            <div>
                <div class="card cart-sidebar">
                    <h2 class="card-title">
                        <i class="bi bi-cart-check"></i> Keranjang
                    </h2>

                    <!-- Pilih Customer -->
                    <div class="customer-section">
                        <div class="customer-header">
                            <label class="customer-label">
                                <i class="bi bi-person"></i> Pilih Pelanggan
                            </label>
                            <button onclick="openRegisterModal()" class="btn-register">
                                <i class="bi bi-person-plus"></i> Daftar Baru
                            </button>
                        </div>
                        <select id="customerSelect" class="form-select" onchange="selectCustomer()">
                            <option value="" data-name="Umum" data-member="0">Umum (Tanpa Data)</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" 
                                    data-name="{{ $customer->name }}" 
                                    data-member="{{ $customer->is_member ? '1' : '0' }}">
                                {{ $customer->name }} - {{ $customer->email }}
                                @if($customer->is_member) ⭐ @endif
                            </option>
                            @endforeach
                        </select>
                        
                        <input type="text" 
                               id="customerNameInput" 
                               class="form-input" 
                               placeholder="Nama untuk struk (opsional)" 
                               value="Umum">
                        
                        <div id="memberBadge" class="member-badge hidden">
                            <span class="member-badge-text">
                                <i class="bi bi-star-fill"></i> MEMBER - Diskon 5%
                            </span>
                        </div>
                    </div>

                    <!-- Daftar Item -->
                    <div class="cart-items-container" id="cartItems">
                        <div class="empty-state" id="emptyCart">
                            <i class="bi bi-cart-x"></i>
                            <p>Keranjang kosong</p>
                        </div>
                    </div>

                    <!-- Ringkasan Harga -->
                    <div class="price-summary">
                        <div class="price-row">
                            <span>Subtotal:</span>
                            <span>Rp <span id="subtotalPrice">0</span></span>
                        </div>
                        <div class="price-row price-row-discount" id="discountRow" style="display: none;">
                            <span>Diskon Member (5%):</span>
                            <span>- Rp <span id="discountAmount">0</span></span>
                        </div>
                        <div class="price-row price-row-total">
                            <span>Total:</span>
                            <span class="price-value">Rp <span id="totalPrice">0</span></span>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="payment-section">
                        <label class="scan-label">Metode Pembayaran</label>
                        <select id="paymentMethod" class="form-select" onchange="toggleChangeInput()">
                            <option value="cash">Cash / Tunai</option>
                            <option value="debit">Debit Card</option>
                            <option value="credit">Credit Card</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>

                    <!-- Input Jumlah Bayar -->
                    <div class="payment-section" id="paidAmountDiv">
                        <label class="scan-label">Jumlah Dibayar</label>
                        <input type="number" 
                               id="paidAmount" 
                               class="form-input" 
                               placeholder="0" 
                               min="0">
                    </div>

                    <!-- Kembalian -->
                    <div class="change-display" id="changeDiv">
                        <div class="change-row">
                            <span class="change-label">Kembalian:</span>
                            <span class="change-amount">Rp <span id="changeAmount">0</span></span>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="action-buttons">
                        <button onclick="processCheckout()" class="btn-checkout">
                            <i class="bi bi-cash-coin"></i> Bayar
                        </button>
                        <button onclick="resetCart()" class="btn-reset">
                            <i class="bi bi-trash"></i> Reset Transaksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Setup axios
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
        
        let cart = [];
        let subtotal = 0;
        let selectedCustomerId = null;
        let selectedCustomerName = 'Umum';
        let isMember = false;

        // Pilih customer
        function selectCustomer() {
            const select = document.getElementById('customerSelect');
            const option = select.options[select.selectedIndex];
            
            selectedCustomerId = option.value || null;
            selectedCustomerName = option.getAttribute('data-name');
            isMember = option.getAttribute('data-member') === '1';
            
            // Update input nama
            const nameInput = document.getElementById('customerNameInput');
            nameInput.value = selectedCustomerName;
            nameInput.disabled = !!selectedCustomerId; // disable jika ada customer terpilih
            
            // Show/hide badge member
            document.getElementById('memberBadge').classList.toggle('hidden', !isMember);
            
            // Recalculate dengan diskon member
            calculateTotal();
        }

        // Toggle input kembalian berdasarkan metode pembayaran
        function toggleChangeInput() {
            const method = document.getElementById('paymentMethod').value;
            const changeDiv = document.getElementById('changeDiv');
            const paidAmountDiv = document.getElementById('paidAmountDiv');
            const paidInput = paidAmountDiv.querySelector('input');
            
            if (method === 'cash') {
                changeDiv.style.display = 'block';
                paidInput.required = true;
            } else {
                changeDiv.style.display = 'none';
                const totalNum = parseInt(document.getElementById('totalPrice').textContent.replace(/\./g, '')) || 0;
                paidInput.value = totalNum;
                document.getElementById('changeAmount').textContent = '0';
            }
        }

        // Auto-scan barcode saat Enter
        document.getElementById('barcodeInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                scanBarcode();
            }
        });

        // Auto-hitung kembalian
        document.getElementById('paidAmount').addEventListener('input', function() {
            const paid = parseInt(this.value) || 0;
            const totalNum = parseInt(document.getElementById('totalPrice').textContent.replace(/\./g, '')) || 0;
            const change = Math.max(0, paid - totalNum);
            document.getElementById('changeAmount').textContent = formatNumber(change);
        });

        // Scan barcode
        function scanBarcode() {
            const barcode = document.getElementById('barcodeInput').value.trim();
            
            if (!barcode) {
                alert('Masukkan barcode terlebih dahulu');
                return;
            }

            axios.post('/pos/scan', { barcode: barcode }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => {
                    const data = response.data.data;
                    addToCart(data.id, data.product_name + ' - ' + data.variant_name, data.price, data.discount, data.stock);
                    document.getElementById('barcodeInput').value = '';
                    document.getElementById('barcodeInput').focus();
                    
                    // Notifikasi sukses
                    showNotification('Barang ditambahkan ke keranjang', 'success');
                })
                .catch(error => {
                    const message = error.response?.data?.message || 'Barang tidak ditemukan';
                    showNotification(message, 'error');
                    document.getElementById('barcodeInput').value = '';
                    document.getElementById('barcodeInput').focus();
                });
        }

        // Tambah ke keranjang
        function addToCart(id, name, price, discount, stock) {
            const existing = cart.find(item => item.id === id);
            
            if (existing) {
                if (existing.qty >= stock) {
                    showNotification('Stok tidak mencukupi', 'error');
                    return;
                }
                existing.qty++;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    discount: discount,
                    qty: 1,
                    stock: stock
                });
            }
            
            renderCart();
        }

        // Render keranjang
        function renderCart() {
            const cartDiv = document.getElementById('cartItems');
            const emptyCart = document.getElementById('emptyCart');
            
            if (cart.length === 0) {
                emptyCart.style.display = 'block';
                subtotal = 0;
            } else {
                emptyCart.style.display = 'none';
                
                let html = '';
                subtotal = 0;
                
                cart.forEach((item, index) => {
                    const priceAfterDiscount = item.price * (1 - item.discount / 100);
                    const itemSubtotal = priceAfterDiscount * item.qty;
                    subtotal += itemSubtotal;
                    
                    html += `
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <div class="cart-item-name">${item.name}</div>
                                <div class="cart-item-details">
                                    Rp ${formatNumber(priceAfterDiscount)} x ${item.qty}
                                    ${item.discount > 0 ? `<span class="product-discount-badge" style="margin-left: 0.5rem;">-${item.discount}%</span>` : ''}
                                </div>
                            </div>
                            <div class="cart-item-actions">
                                <div class="cart-item-price">Rp ${formatNumber(itemSubtotal)}</div>
                                <div class="cart-item-buttons">
                                    <button onclick="updateQty(${index}, -1)" class="btn-cart-action btn-minus" title="Kurangi">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <button onclick="updateQty(${index}, 1)" class="btn-cart-action btn-plus" title="Tambah">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                    <button onclick="removeItem(${index})" class="btn-cart-action btn-remove" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                cartDiv.innerHTML = html;
            }
            
            calculateTotal();
        }

        // Hitung total dengan diskon member
        function calculateTotal() {
            // Hitung diskon member (5%)
            const memberDiscount = isMember ? subtotal * 0.05 : 0;
            const total = subtotal - memberDiscount;
            
            // Update UI
            document.getElementById('subtotalPrice').textContent = formatNumber(subtotal);
            document.getElementById('discountAmount').textContent = formatNumber(memberDiscount);
            document.getElementById('totalPrice').textContent = formatNumber(total);
            
            // Show/hide diskon row
            const discountRow = document.getElementById('discountRow');
            discountRow.style.display = isMember ? 'flex' : 'none';
            
            // Update paid amount jika bukan cash
            const paymentMethod = document.getElementById('paymentMethod').value;
            if (paymentMethod !== 'cash') {
                document.getElementById('paidAmount').value = total;
            }
            
            // Reset kembalian
            document.getElementById('changeAmount').textContent = '0';
            
            return total;
        }

        // Update quantity
        function updateQty(index, change) {
            const item = cart[index];
            const newQty = item.qty + change;
            
            if (newQty <= 0) {
                removeItem(index);
            } else if (newQty <= item.stock) {
                item.qty = newQty;
                renderCart();
            } else {
                showNotification('Stok tidak mencukupi', 'error');
            }
        }

        // Hapus item
        function removeItem(index) {
            cart.splice(index, 1);
            renderCart();
        }

        // Reset keranjang
        function resetCart() {
            if (confirm('Yakin ingin mengosongkan keranjang?')) {
                cart = [];
                renderCart();
                document.getElementById('paidAmount').value = '';
                showNotification('Keranjang dikosongkan', 'info');
            }
        }

        // Proses checkout
        function processCheckout() {
            if (cart.length === 0) {
                showNotification('Keranjang kosong!', 'error');
                return;
            }
            
            // Validasi customer name harus diisi
            const customerNameInput = document.getElementById('customerNameInput');
            if (!customerNameInput.value.trim()) {
                showNotification('Masukkan nama pelanggan', 'error');
                customerNameInput.focus();
                return;
            }
            
            const total = calculateTotal();
            const paymentMethod = document.getElementById('paymentMethod').value;
            const paidAmount = parseInt(document.getElementById('paidAmount').value) || 0;
            
            if (paidAmount <= 0) {
                showNotification('Masukkan jumlah pembayaran', 'error');
                return;
            }
            
            if (paymentMethod === 'tunai' && paidAmount < total) {
                showNotification('Jumlah pembayaran kurang dari total', 'error');
                return;
            }
            
            // Konfirmasi dengan info customer dan discount
            let confirmMsg = `Pelanggan: ${customerNameInput.value}`;
            if (isMember) {
                const discount = subtotal * 0.05;
                confirmMsg += `\nMember Discount: Rp ${formatNumber(discount)}`;
            }
            confirmMsg += `\nSubtotal: Rp ${formatNumber(subtotal)}`;
            confirmMsg += `\nTotal: Rp ${formatNumber(total)}`;
            confirmMsg += `\nDibayar: Rp ${formatNumber(paidAmount)}`;
            confirmMsg += `\n\nProses transaksi?`;
            
            if (!confirm(confirmMsg)) {
                return;
            }
            
            const items = cart.map(item => ({
                variant_id: item.id,
                quantity: item.qty
            }));
            
            axios.post('/pos/checkout', {
                items: items,
                payment_method: paymentMethod,
                paid_amount: paidAmount,
                customer_id: selectedCustomerId,
                customer_name: customerNameInput.value.trim()
            }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                const data = response.data.data;
                
                // Tampilkan info transaksi
                let successMsg = `Transaksi berhasil! Kode: ${data.barcode}`;
                if (data.discount > 0) {
                    successMsg += `\nDiskon Member: Rp ${formatNumber(data.discount)}`;
                }
                showNotification(successMsg, 'success');
                
                // Tanya cetak struk
                if (confirm('Apakah Anda ingin mencetak struk?')) {
                    window.open(`/pos/receipt/${data.sale_id}`, '_blank');
                }
                
                // Reset semua
                cart = [];
                selectedCustomerId = null;
                selectedCustomerName = '';
                isMember = false;
                subtotal = 0;
                
                renderCart();
                document.getElementById('customerSelect').value = '';
                document.getElementById('customerNameInput').value = '';
                document.getElementById('customerNameInput').disabled = true;
                document.getElementById('memberBadge').style.display = 'none';
                document.getElementById('paidAmount').value = '';
                document.getElementById('barcodeInput').focus();
            })
            .catch(error => {
                console.error('Error detail:', error);
                const message = error.response?.data?.message || 'Terjadi kesalahan saat proses transaksi';
                showNotification(message, 'error');
            });
        }

        // Format number
        function formatNumber(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Show notification
        function showNotification(message, type) {
            const classes = {
                success: 'notification-success',
                error: 'notification-error',
                info: 'notification-info'
            };
            
            const notif = document.createElement('div');
            notif.className = `notification ${classes[type]}`;
            notif.textContent = message;
            
            document.body.appendChild(notif);
            
            setTimeout(() => {
                notif.remove();
            }, 3000);
        }

        // Open register modal
        function openRegisterModal() {
            document.getElementById('registerModal').classList.remove('hidden');
            document.getElementById('regName').focus();
        }

        // Close register modal
        function closeRegisterModal() {
            document.getElementById('registerModal').classList.add('hidden');
            document.getElementById('registerForm').reset();
        }

        // Submit register customer
        function submitRegisterCustomer(event) {
            event.preventDefault();
            
            const submitBtn = document.getElementById('submitRegisterBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mendaftar...';
            
            const formData = {
                name: document.getElementById('regName').value,
                email: document.getElementById('regEmail').value,
                phone: document.getElementById('regPhone').value,
                address: document.getElementById('regAddress').value,
            };
            
            axios.post('/pos/register-customer', formData, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => {
                    const customer = response.data.data;
                    
                    showNotification(`${customer.name} berhasil didaftarkan!`, 'success');
                    
                    // Tambahkan ke dropdown
                    const select = document.getElementById('customerSelect');
                    const option = document.createElement('option');
                    option.value = customer.id;
                    option.setAttribute('data-name', customer.name);
                    option.setAttribute('data-member', customer.is_member ? '1' : '0');
                    option.textContent = `${customer.name} - ${customer.email}`;
                    if (customer.is_member) {
                        option.textContent += ' ⭐';
                    }
                    select.appendChild(option);
                    
                    // Auto-select customer baru
                    select.value = customer.id;
                    selectCustomer();
                    
                    // Close modal
                    closeRegisterModal();
                    
                    // Info password
                    setTimeout(() => {
                        alert(`Member berhasil didaftarkan!\n\nNama: ${customer.name}\nEmail: ${customer.email}\nPassword: member123\n\n⭐ Status: MEMBER (Diskon 5%)\n⚠️ Sarankan customer untuk mengganti password setelah login pertama kali.`);
                    }, 500);
                })
                .catch(error => {
                    const message = error.response?.data?.message || 'Gagal mendaftarkan customer';
                    showNotification(message, 'error');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-lg"></i> Daftar';
                });
        }

        // Focus pada barcode input saat load
        window.onload = function() {
            document.getElementById('barcodeInput').focus();
        };
    </script>

    <!-- Modal Daftar Customer Baru -->
    <div id="registerModal" class="modal hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="bi bi-person-plus"></i> Daftar Pelanggan Baru
                </h3>
                <button onclick="closeRegisterModal()" class="btn-close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            
            <form id="registerForm" onsubmit="submitRegisterCustomer(event)">
                <div class="form-group">
                    <label class="form-label">
                        Nama Lengkap <span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="regName" 
                           name="name" 
                           required
                           class="form-input">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        Email <span class="required">*</span>
                    </label>
                    <input type="email" 
                           id="regEmail" 
                           name="email" 
                           required
                           class="form-input">
                    <p class="form-help">Password default: member123 (bisa diganti nanti)</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        No. HP/WA <span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="regPhone" 
                           name="phone" 
                           required
                           class="form-input"
                           placeholder="08xx-xxxx-xxxx">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        Alamat <span class="required">*</span>
                    </label>
                    <textarea id="regAddress" 
                              name="address" 
                              required 
                              rows="3"
                              class="form-textarea"></textarea>
                </div>
                
                <div class="info-box">
                    <p class="info-box-text">
                        <i class="bi bi-star-fill"></i> <strong>Otomatis jadi Member</strong><br>
                        <span style="font-size: 0.8rem;">Pelanggan yang didaftarkan akan otomatis mendapat diskon 5%</span>
                    </p>
                </div>
                
                <div class="modal-buttons">
                    <button type="button" 
                            onclick="closeRegisterModal()"
                            class="btn-modal btn-cancel">
                        Batal
                    </button>
                    <button type="submit" 
                            id="submitRegisterBtn"
                            class="btn-modal btn-submit">
                        <i class="bi bi-check-lg"></i> Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
