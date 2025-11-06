<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS Tablet - Kasir | Sellin Kasir</title>
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
            padding-bottom: 120px; /* Space for floating cart */
        }
        
        /* Top Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-container {
            max-width: 1600px;
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
            background: linear-gradient(135deg, #667eea, #764ba2);
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
        
        .btn-verify {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
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
        
        .time-display {
            color: #64748B;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        /* Main Container */
        .main-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Search Bar */
        .search-section {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }
        
        .search-box {
            position: relative;
            max-width: 600px;
        }
        
        .search-box input {
            width: 100%;
            padding: 1rem 3rem 1rem 1rem;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .search-box button {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .search-box button:hover {
            transform: translateY(-50%) scale(1.05);
        }
        
        /* Category Tabs */
        .category-tabs {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            overflow-x: auto;
            display: flex;
            gap: 1rem;
            position: sticky;
            top: 80px;
            z-index: 99;
        }
        
        .category-tabs::-webkit-scrollbar {
            height: 6px;
        }
        
        .category-tabs::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }
        
        .category-tab {
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            background: #F1F5F9;
            color: #64748B;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .category-tab:hover {
            background: #E2E8F0;
            transform: translateY(-2px);
        }
        
        .category-tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .category-tab i {
            font-size: 1.2rem;
        }
        
        /* Product Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .product-card {
            background: white;
            border-radius: 16px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
        
        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s;
        }
        
        .product-card:hover::before {
            transform: scaleX(1);
        }
        
        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 1rem;
            background: #F1F5F9;
        }
        
        .product-name {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #1E293B;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-variant {
            font-size: 0.85rem;
            color: #64748B;
            margin-bottom: 0.5rem;
        }
        
        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.8rem;
        }
        
        .product-price {
            font-weight: 700;
            font-size: 1.1rem;
            color: #10b981;
        }
        
        .product-stock {
            background: #EFF6FF;
            color: #3B82F6;
            padding: 0.3rem 0.8rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .discount-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #EF4444;
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        /* Floating Cart Bottom Bar */
        .floating-cart {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
            z-index: 999;
            transition: all 0.3s;
        }
        
        .cart-preview {
            max-width: 1600px;
            margin: 0 auto;
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }
        
        .cart-info {
            display: flex;
            align-items: center;
            gap: 2rem;
            flex: 1;
        }
        
        .cart-icon-badge {
            position: relative;
        }
        
        .cart-icon-badge i {
            font-size: 2rem;
            color: #667eea;
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #EF4444;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .cart-summary {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }
        
        .cart-items-count {
            font-size: 0.9rem;
            color: #64748B;
            font-weight: 500;
        }
        
        .cart-total {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .cart-actions {
            display: flex;
            gap: 1rem;
        }
        
        .btn-view-cart {
            background: #F1F5F9;
            color: #475569;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-view-cart:hover {
            background: #E2E8F0;
            transform: translateY(-2px);
        }
        
        .btn-checkout {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        /* Checkout Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1000;
            animation: fadeIn 0.3s;
        }
        
        .modal-overlay.active {
            display: block;
        }
        
        .checkout-modal {
            position: fixed;
            bottom: -100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 24px 24px 0 0;
            max-height: 80vh;
            overflow-y: auto;
            z-index: 1001;
            transition: bottom 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.2);
        }
        
        .checkout-modal.active {
            bottom: 0;
        }
        
        .modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 2px solid #F1F5F9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
        }
        
        .modal-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .btn-close-modal {
            background: #F1F5F9;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .btn-close-modal:hover {
            background: #E2E8F0;
            transform: rotate(90deg);
        }
        
        .modal-body {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .cart-items-list {
            margin-bottom: 2rem;
        }
        
        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background: #F9FAFB;
            border-radius: 12px;
            margin-bottom: 1rem;
            align-items: center;
        }
        
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            background: white;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }
        
        .item-variant {
            font-size: 0.85rem;
            color: #64748B;
        }
        
        .item-price {
            font-weight: 600;
            color: #10b981;
            margin-top: 0.3rem;
        }
        
        .item-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            padding: 0.5rem;
            border-radius: 10px;
        }
        
        .qty-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .qty-btn.minus {
            background: #FEE2E2;
            color: #EF4444;
        }
        
        .qty-btn.plus {
            background: #D1FAE5;
            color: #10b981;
        }
        
        .qty-btn:hover {
            transform: scale(1.1);
        }
        
        .qty-display {
            min-width: 40px;
            text-align: center;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .btn-remove {
            background: #FEE2E2;
            color: #EF4444;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-remove:hover {
            background: #EF4444;
            color: white;
            transform: scale(1.1);
        }
        
        .checkout-form {
            background: #F9FAFB;
            padding: 2rem;
            border-radius: 16px;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #1E293B;
        }
        
        .form-control {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .price-summary {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 2rem;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #F1F5F9;
        }
        
        .price-row:last-child {
            border-bottom: none;
        }
        
        .price-row.total {
            font-size: 1.3rem;
            font-weight: 700;
            color: #667eea;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid #E2E8F0;
        }
        
        .member-badge {
            display: inline-block;
            background: linear-gradient(135deg, #FCD34D, #F59E0B);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .btn-process-payment {
            width: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1.2rem;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1.5rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-process-payment:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        /* Notifications */
        .notification {
            position: fixed;
            top: 100px;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            display: none;
            animation: slideInRight 0.3s;
        }
        
        .notification.active {
            display: block;
        }
        
        .notification.success {
            background: #10b981;
            color: white;
        }
        
        .notification.error {
            background: #EF4444;
            color: white;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 1rem;
            }
            
            .cart-preview {
                flex-direction: column;
                gap: 1rem;
            }
            
            .cart-actions {
                width: 100%;
            }
            
            .btn-checkout {
                flex: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <i class="bi bi-shop"></i>
                <span>POS Kasir - {{ Auth::user()->name }}</span>
            </div>
            <div class="navbar-actions">
                <a href="{{ route('cashier.verification') }}" class="btn-nav btn-verify">
                    <i class="bi bi-check-circle"></i> Verifikasi Order
                </a>
                <a href="{{ route('cashier.reports') }}" class="btn-nav btn-report">
                    <i class="bi bi-file-earmark-text"></i> Laporan Saya
                </a>
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

    <!-- Main Container -->
    <div class="main-container">
        <!-- Search Bar -->
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="barcodeInput" placeholder="Scan barcode atau ketik untuk mencari produk..." autofocus>
                <button onclick="scanBarcode()">
                    <i class="bi bi-search"></i> Scan
                </button>
            </div>
        </div>

        <!-- Category Tabs -->
        <div class="category-tabs">
            <button class="category-tab active" onclick="filterCategory('all')">
                <i class="bi bi-grid"></i> Semua
            </button>
            <button class="category-tab" onclick="filterCategory('Makanan')">
                <i class="bi bi-egg-fried"></i> Makanan
            </button>
            <button class="category-tab" onclick="filterCategory('Minuman')">
                <i class="bi bi-cup-straw"></i> Minuman
            </button>
            <button class="category-tab" onclick="filterCategory('Snack')">
                <i class="bi bi-bag"></i> Snack
            </button>
            <button class="category-tab" onclick="filterCategory('Alat Tulis')">
                <i class="bi bi-pencil"></i> Alat Tulis
            </button>
            <button class="category-tab" onclick="filterCategory('Elektronik')">
                <i class="bi bi-laptop"></i> Elektronik
            </button>
            <button class="category-tab" onclick="filterCategory('Peralatan Rumah Tangga')">
                <i class="bi bi-house"></i> Peralatan RT
            </button>
            <button class="category-tab" onclick="filterCategory('Lainnya')">
                <i class="bi bi-three-dots"></i> Lainnya
            </button>
        </div>

        <!-- Products Grid -->
        <div class="products-grid" id="productsGrid">
            @foreach($variants as $variant)
            <div class="product-card" data-category="{{ $variant->product->category ?? 'Lainnya' }}" onclick="addToCart({{ $variant->id }}, '{{ $variant->product->name }}', '{{ $variant->variant_name }}', {{ $variant->price }}, {{ $variant->discount }}, {{ $variant->stock }}, '{{ $variant->product->image ? asset('storage/' . $variant->product->image) : 'https://via.placeholder.com/200' }}')">
                @if($variant->discount > 0)
                <div class="discount-badge">-{{ $variant->discount }}%</div>
                @endif
                <img src="{{ $variant->product->image ? asset('storage/' . $variant->product->image) : 'https://via.placeholder.com/200' }}" 
                     alt="{{ $variant->product->name }}" 
                     class="product-image">
                <div class="product-name">{{ $variant->product->name }}</div>
                <div class="product-variant">{{ $variant->variant_name }}</div>
                <div class="product-footer">
                    <div>
                        @if($variant->discount > 0)
                        <div style="text-decoration: line-through; color: #94A3B8; font-size: 0.85rem;">
                            Rp {{ number_format($variant->price, 0, ',', '.') }}
                        </div>
                        @endif
                        <div class="product-price">
                            Rp {{ number_format($variant->price * (1 - $variant->discount / 100), 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="product-stock">Stok: {{ $variant->stock }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Floating Cart Bottom Bar -->
    <div class="floating-cart" id="floatingCart" style="display: none;">
        <div class="cart-preview">
            <div class="cart-info">
                <div class="cart-icon-badge">
                    <i class="bi bi-cart3"></i>
                    <span class="cart-badge" id="cartBadge">0</span>
                </div>
                <div class="cart-summary">
                    <div class="cart-items-count" id="cartItemsCount">0 items</div>
                    <div class="cart-total" id="cartTotal">Rp 0</div>
                </div>
            </div>
            <div class="cart-actions">
                <button class="btn-view-cart" onclick="toggleCheckoutModal()">
                    <i class="bi bi-eye"></i> Lihat Keranjang
                </button>
                <button class="btn-checkout" onclick="toggleCheckoutModal()">
                    <i class="bi bi-credit-card"></i> Checkout
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay" onclick="toggleCheckoutModal()"></div>

    <!-- Checkout Modal -->
    <div class="checkout-modal" id="checkoutModal">
        <div class="modal-header">
            <h3><i class="bi bi-cart-check"></i> Checkout</h3>
            <button class="btn-close-modal" onclick="toggleCheckoutModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body">
            <!-- Cart Items List -->
            <div class="cart-items-list" id="cartItemsList"></div>

            <!-- Checkout Form -->
            <div class="checkout-form">
                <div class="form-group">
                    <label>Pilih Pelanggan</label>
                    <select class="form-control" id="customerSelect" onchange="selectCustomer()">
                        <option value="">Umum (Tanpa Data)</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" data-name="{{ $customer->name }}" data-member="{{ $customer->is_member ? 'true' : 'false' }}">
                            {{ $customer->name }} @if($customer->is_member) ⭐ @endif
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama untuk Struk (opsional)</label>
                    <input type="text" class="form-control" id="customerNameInput" placeholder="Nama pelanggan">
                </div>

                <div id="memberBadgeContainer" style="display: none;">
                    <div class="member-badge">
                        ⭐ MEMBER - Diskon 5%
                    </div>
                </div>

                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select class="form-control" id="paymentMethod" onchange="togglePaidAmount()">
                        <option value="tunai">Cash (Tunai)</option>
                        <option value="debit">Debit Card</option>
                        <option value="credit">Credit Card</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>

                <div class="form-group" id="paidAmountGroup">
                    <label>Jumlah Dibayar</label>
                    <input type="number" class="form-control" id="paidAmount" placeholder="0" oninput="calculateChange()">
                    <div id="changeDisplay" style="margin-top: 0.5rem; padding: 0.8rem; background: #D1FAE5; color: #059669; border-radius: 10px; font-weight: 600; display: none;">
                        Kembalian: <span id="changeAmount">Rp 0</span>
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="price-summary">
                    <div class="price-row">
                        <span>Subtotal</span>
                        <span id="summarySubtotal">Rp 0</span>
                    </div>
                    <div class="price-row" id="discountRow" style="display: none;">
                        <span>Diskon Member (5%)</span>
                        <span id="summaryDiscount" style="color: #10b981;">- Rp 0</span>
                    </div>
                    <div class="price-row total">
                        <span>Total Bayar</span>
                        <span id="summaryTotal">Rp 0</span>
                    </div>
                </div>

                <button class="btn-process-payment" onclick="processPayment()">
                    <i class="bi bi-check-circle"></i> Proses Pembayaran
                </button>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <script>
        let cart = [];
        let selectedCustomerId = null;
        let selectedCustomerName = '';
        let isMember = false;
        let subtotal = 0;
        let currentCategory = 'all';

        // Add to cart
        function addToCart(variantId, productName, variantName, price, discount, stock, image) {
            const priceAfterDiscount = price * (1 - discount / 100);
            
            // Check if already in cart
            const existingItem = cart.find(item => item.variantId === variantId);
            
            if (existingItem) {
                if (existingItem.quantity < stock) {
                    existingItem.quantity++;
                    showNotification('Quantity updated!', 'success');
                } else {
                    showNotification('Stok tidak cukup!', 'error');
                    return;
                }
            } else {
                if (stock > 0) {
                    cart.push({
                        variantId,
                        productName,
                        variantName,
                        price: priceAfterDiscount,
                        originalPrice: price,
                        discount,
                        quantity: 1,
                        stock,
                        image
                    });
                    showNotification('Produk ditambahkan ke keranjang!', 'success');
                } else {
                    showNotification('Stok habis!', 'error');
                    return;
                }
            }
            
            updateCart();
        }

        // Update cart display
        function updateCart() {
            const floatingCart = document.getElementById('floatingCart');
            const cartBadge = document.getElementById('cartBadge');
            const cartItemsCount = document.getElementById('cartItemsCount');
            const cartTotal = document.getElementById('cartTotal');
            
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            
            if (totalItems > 0) {
                floatingCart.style.display = 'block';
                cartBadge.textContent = totalItems;
                cartItemsCount.textContent = `${totalItems} item${totalItems > 1 ? 's' : ''}`;
                cartTotal.textContent = `Rp ${formatNumber(subtotal)}`;
            } else {
                floatingCart.style.display = 'none';
            }
            
            updateCheckoutModal();
        }

        // Update checkout modal
        function updateCheckoutModal() {
            const cartItemsList = document.getElementById('cartItemsList');
            const summarySubtotal = document.getElementById('summarySubtotal');
            const summaryDiscount = document.getElementById('summaryDiscount');
            const summaryTotal = document.getElementById('summaryTotal');
            const discountRow = document.getElementById('discountRow');
            
            // Render cart items
            cartItemsList.innerHTML = cart.map(item => `
                <div class="cart-item">
                    <img src="${item.image}" alt="${item.productName}" class="item-image">
                    <div class="item-details">
                        <div class="item-name">${item.productName}</div>
                        <div class="item-variant">${item.variantName}</div>
                        <div class="item-price">Rp ${formatNumber(item.price)}</div>
                    </div>
                    <div class="item-controls">
                        <div class="qty-controls">
                            <button class="qty-btn minus" onclick="updateQuantity(${item.variantId}, -1)">-</button>
                            <div class="qty-display">${item.quantity}</div>
                            <button class="qty-btn plus" onclick="updateQuantity(${item.variantId}, 1)">+</button>
                        </div>
                        <button class="btn-remove" onclick="removeFromCart(${item.variantId})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `).join('');
            
            // Calculate totals
            const discount = isMember ? subtotal * 0.05 : 0;
            const total = subtotal - discount;
            
            summarySubtotal.textContent = `Rp ${formatNumber(subtotal)}`;
            summaryDiscount.textContent = `- Rp ${formatNumber(discount)}`;
            summaryTotal.textContent = `Rp ${formatNumber(total)}`;
            
            if (isMember) {
                discountRow.style.display = 'flex';
            } else {
                discountRow.style.display = 'none';
            }
        }

        // Update quantity
        function updateQuantity(variantId, change) {
            const item = cart.find(i => i.variantId === variantId);
            if (!item) return;
            
            const newQty = item.quantity + change;
            
            if (newQty <= 0) {
                removeFromCart(variantId);
            } else if (newQty <= item.stock) {
                item.quantity = newQty;
                updateCart();
            } else {
                showNotification('Stok tidak cukup!', 'error');
            }
        }

        // Remove from cart
        function removeFromCart(variantId) {
            cart = cart.filter(item => item.variantId !== variantId);
            updateCart();
            showNotification('Item dihapus dari keranjang', 'success');
        }

        // Toggle checkout modal
        function toggleCheckoutModal() {
            const modal = document.getElementById('checkoutModal');
            const overlay = document.getElementById('modalOverlay');
            
            modal.classList.toggle('active');
            overlay.classList.toggle('active');
            
            if (modal.classList.contains('active')) {
                updateCheckoutModal();
            }
        }

        // Select customer
        function selectCustomer() {
            const select = document.getElementById('customerSelect');
            const option = select.options[select.selectedIndex];
            const nameInput = document.getElementById('customerNameInput');
            const memberBadge = document.getElementById('memberBadgeContainer');
            
            selectedCustomerId = select.value || null;
            selectedCustomerName = option.dataset.name || '';
            isMember = option.dataset.member === 'true';
            
            nameInput.value = selectedCustomerName;
            
            if (isMember) {
                memberBadge.style.display = 'block';
            } else {
                memberBadge.style.display = 'none';
            }
            
            updateCheckoutModal();
        }

        // Toggle paid amount
        function togglePaidAmount() {
            const method = document.getElementById('paymentMethod').value;
            const paidAmountGroup = document.getElementById('paidAmountGroup');
            
            if (method === 'tunai') {
                paidAmountGroup.style.display = 'block';
            } else {
                paidAmountGroup.style.display = 'none';
            }
        }

        // Calculate change
        function calculateChange() {
            const discount = isMember ? subtotal * 0.05 : 0;
            const total = subtotal - discount;
            const paid = parseFloat(document.getElementById('paidAmount').value) || 0;
            const change = paid - total;
            
            const changeDisplay = document.getElementById('changeDisplay');
            const changeAmount = document.getElementById('changeAmount');
            
            if (paid > 0) {
                changeDisplay.style.display = 'block';
                changeAmount.textContent = `Rp ${formatNumber(Math.max(0, change))}`;
                
                if (change < 0) {
                    changeDisplay.style.background = '#FEE2E2';
                    changeDisplay.style.color = '#EF4444';
                    changeAmount.textContent = 'Uang kurang!';
                } else {
                    changeDisplay.style.background = '#D1FAE5';
                    changeDisplay.style.color = '#059669';
                }
            } else {
                changeDisplay.style.display = 'none';
            }
        }

        // Process payment
        function processPayment() {
            if (cart.length === 0) {
                showNotification('Keranjang masih kosong!', 'error');
                return;
            }
            
            const paymentMethod = document.getElementById('paymentMethod').value;
            const customerName = document.getElementById('customerNameInput').value;
            const discount = isMember ? subtotal * 0.05 : 0;
            const total = subtotal - discount;
            let paidAmount = total;
            
            if (paymentMethod === 'tunai') {
                paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
                if (paidAmount < total) {
                    showNotification('Jumlah bayar tidak cukup!', 'error');
                    return;
                }
            }
            
            // Prepare data
            const items = cart.map(item => ({
                variant_id: item.variantId,
                quantity: item.quantity
            }));
            
            const data = {
                items: items,
                payment_method: paymentMethod,
                paid_amount: paidAmount
            };
            
            // Send to server
            axios.post('/pos/sales', data, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                const saleId = response.data.sale_id;
                
                showNotification('Transaksi berhasil!', 'success');
                
                // Ask to print receipt
                if (confirm('Apakah Anda ingin mencetak struk?')) {
                    window.open(`/pos/receipt/${saleId}`, '_blank');
                }
                
                // Reset
                cart = [];
                selectedCustomerId = null;
                selectedCustomerName = '';
                isMember = false;
                subtotal = 0;
                
                document.getElementById('customerSelect').value = '';
                document.getElementById('customerNameInput').value = '';
                document.getElementById('memberBadgeContainer').style.display = 'none';
                document.getElementById('paidAmount').value = '';
                document.getElementById('changeDisplay').style.display = 'none';
                
                updateCart();
                toggleCheckoutModal();
            })
            .catch(error => {
                console.error('Error detail:', error);
                const message = error.response?.data?.message || 'Terjadi kesalahan saat proses transaksi';
                showNotification(message, 'error');
            });
        }

        // Filter by category
        function filterCategory(category) {
            currentCategory = category;
            const products = document.querySelectorAll('.product-card');
            const tabs = document.querySelectorAll('.category-tab');
            
            // Update active tab
            tabs.forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            
            // Filter products
            products.forEach(product => {
                const productCategory = product.dataset.category;
                if (category === 'all' || productCategory === category) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }

        // Scan barcode
        function scanBarcode() {
            const barcode = document.getElementById('barcodeInput').value.trim();
            if (!barcode) return;
            
            // Find product by barcode (you need to add barcode data attribute to products)
            // For now, just search by name
            const searchTerm = barcode.toLowerCase();
            const products = document.querySelectorAll('.product-card');
            
            products.forEach(product => {
                const name = product.querySelector('.product-name').textContent.toLowerCase();
                const variant = product.querySelector('.product-variant').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || variant.includes(searchTerm)) {
                    product.click();
                    document.getElementById('barcodeInput').value = '';
                    document.getElementById('barcodeInput').focus();
                    return;
                }
            });
        }

        // Search on enter
        document.getElementById('barcodeInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                scanBarcode();
            }
        });

        // Format number
        function formatNumber(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Show notification
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type} active`;
            
            setTimeout(() => {
                notification.classList.remove('active');
            }, 3000);
        }

        // Close modal on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('checkoutModal');
                if (modal.classList.contains('active')) {
                    toggleCheckoutModal();
                }
            }
        });
    </script>
</body>
</html>
