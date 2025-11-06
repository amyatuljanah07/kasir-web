@extends('layouts.customer')

@section('title', 'Belanja')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #f3f4f6;
    }

    .shop-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .shop-header {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-left h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .header-left p {
        font-size: 16px;
        color: #6b7280;
    }

    .balance-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 30px;
        border-radius: 16px;
        color: white;
        min-width: 280px;
    }

    .balance-label {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .balance-amount {
        font-size: 28px;
        font-weight: 700;
    }

    .cart-summary-sticky {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 -5px 30px rgba(0,0,0,0.15);
        padding: 20px;
        z-index: 90;
        display: none;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .cart-summary-sticky.active {
        display: flex;
    }

    .cart-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .cart-count {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 700;
    }

    .cart-details h3 {
        font-size: 16px;
        color: #1f2937;
        margin-bottom: 3px;
    }

    .cart-total {
        font-size: 24px;
        font-weight: 700;
        color: #667eea;
    }

    .btn-checkout-sticky {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-checkout-sticky:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 100px;
    }

    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
        position: relative;
    }

    .product-discount-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #ef4444;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .product-info {
        padding: 20px;
    }

    .product-name {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .product-variant {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 12px;
    }

    .product-price-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .product-price {
        font-size: 24px;
        font-weight: 700;
        color: #667eea;
    }

    .product-price-old {
        font-size: 16px;
        color: #9ca3af;
        text-decoration: line-through;
    }

    .product-stock {
        display: inline-block;
        padding: 6px 12px;
        background: #dbeafe;
        color: #1e40af;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .product-actions {
        display: flex;
        gap: 10px;
    }

    .btn-add-cart {
        flex: 1;
        padding: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-add-cart:disabled {
        background: #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
        transform: none;
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
    }

    /* Checkout Modal */
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
        padding: 0;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .modal-header {
        padding: 30px;
        border-bottom: 2px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #6b7280;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .btn-close:hover {
        background: #f3f4f6;
    }

    .modal-body {
        padding: 30px;
    }

    .order-summary {
        background: #f9fafb;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .order-summary h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 15px;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-info h5 {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 3px;
    }

    .item-info p {
        font-size: 13px;
        color: #6b7280;
    }

    .item-price {
        font-size: 16px;
        font-weight: 700;
        color: #667eea;
    }

    .total-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 16px;
        margin-bottom: 25px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 18px;
        font-weight: 600;
    }

    .total-amount {
        font-size: 32px;
        font-weight: 700;
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
        padding: 14px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        text-align: center;
        letter-spacing: 5px;
        font-weight: 600;
    }

    .form-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        flex: 1;
        padding: 16px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #6b7280;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
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

    .alert-info {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #93c5fd;
    }

    @media (max-width: 768px) {
        .shop-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .balance-card {
            width: 100%;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
        }

        .cart-summary-sticky {
            flex-direction: column;
            padding: 15px;
        }

        .btn-checkout-sticky {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="shop-container">
    <!-- Header with Balance -->
    <div class="shop-header">
        <div class="header-left">
            <h1>🛒 Belanja Sekarang</h1>
            <p>Pilih produk, tambahkan ke keranjang, dan bayar dengan Virtual Card</p>
        </div>
        <div class="balance-card">
            <div class="balance-label">� Saldo Anda</div>
            <div class="balance-amount">Rp {{ number_format($balance, 0, ',', '.') }}</div>
        </div>
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

    <!-- Popular Products Section -->
    @if($popularProducts->count() > 0)
    <div style="margin-bottom: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 style="font-size: 28px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
                🔥 Produk Populer
            </h2>
        </div>
        
        <div class="products-grid">
            @foreach($popularProducts as $product)
                @foreach($product->variants as $variant)
                    @if($variant->stock > 0)
                    <div class="product-card" onclick="addToCart({{ $variant->id }}, '{{ $product->name }}', '{{ $variant->variant_name }}', {{ $variant->discount_price ?? $variant->price }}, {{ $variant->price }}, {{ $variant->stock }}, {{ $variant->discount_percent ?? 0 }})" style="position: relative;">
                        <!-- Early Access Badge -->
                        @if($product->isEarlyAccess())
                        <div style="position: absolute; top: 10px; left: 10px; background: linear-gradient(135deg, #f59e0b 0%, #eab308 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 10; box-shadow: 0 2px 10px rgba(245, 158, 11, 0.5);">
                            ⚡ EARLY ACCESS
                        </div>
                        @else
                        <!-- Popular Badge -->
                        <div style="position: absolute; top: 10px; left: 10px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 10; box-shadow: 0 2px 10px rgba(245, 158, 11, 0.3);">
                            🔥 POPULER
                        </div>
                        @endif
                        
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span>📦</span>
                            @endif
                            
                            @if($variant->discount_percent)
                            <div class="product-discount-badge">-{{ $variant->discount_percent }}%</div>
                            @endif
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <p class="product-variant">{{ $variant->variant_name }}</p>
                            
                            @if($product->sales_count > 0)
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 8px;">
                                ⭐ {{ $product->sales_count }} terjual
                            </div>
                            @endif
                            
                            <div class="product-price-row">
                                <span class="product-price">Rp {{ number_format($variant->discount_price ?? $variant->price, 0, ',', '.') }}</span>
                                @if($variant->discount_price)
                                <span class="product-price-old">Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            
                            <span class="product-stock">📦 Stok: {{ $variant->stock }}</span>
                            
                            <div class="product-actions">
                                <button class="btn-add-cart" onclick="event.stopPropagation(); addToCart({{ $variant->id }}, '{{ $product->name }}', '{{ $variant->variant_name }}', {{ $variant->discount_price ?? $variant->price }}, {{ $variant->price }}, {{ $variant->stock }}, {{ $variant->discount_percent ?? 0 }})">
                                    <i class="bi bi-cart-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- All Products Section -->
    <div style="margin-bottom: 25px;">
        <h2 style="font-size: 28px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            🛍️ Semua Produk
        </h2>
    </div>
    @endif

    <!-- Products Grid -->
    <div class="products-grid">
        @forelse($products as $product)
            @foreach($product->variants as $variant)
            <div class="product-card" onclick="addToCart({{ $variant->id }}, '{{ $product->name }}', '{{ $variant->variant_name }}', {{ $variant->discount_price ?? $variant->price }}, {{ $variant->price }}, {{ $variant->stock }}, {{ $variant->discount_percent ?? 0 }})" style="position: relative;">
                <!-- Early Access Badge -->
                @if($product->isEarlyAccess())
                <div style="position: absolute; top: 10px; left: 10px; background: linear-gradient(135deg, #f59e0b 0%, #eab308 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 10; box-shadow: 0 2px 10px rgba(245, 158, 11, 0.5);">
                    ⚡ EARLY ACCESS
                </div>
                @endif
                
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span>📦</span>
                    @endif
                    
                    @if($variant->discount_percent)
                    <div class="product-discount-badge">-{{ $variant->discount_percent }}%</div>
                    @endif
                </div>
                
                <div class="product-info">
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <p class="product-variant">{{ $variant->variant_name }}</p>
                    
                    <div class="product-price-row">
                        <span class="product-price">Rp {{ number_format($variant->discount_price ?? $variant->price, 0, ',', '.') }}</span>
                        @if($variant->discount_price)
                        <span class="product-price-old">Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    
                    <span class="product-stock">📦 Stok: {{ $variant->stock }}</span>
                    
                    <div class="product-actions">
                        <button class="btn-add-cart" onclick="event.stopPropagation(); addToCart({{ $variant->id }}, '{{ $product->name }}', '{{ $variant->variant_name }}', {{ $variant->discount_price ?? $variant->price }}, {{ $variant->price }}, {{ $variant->stock }}, {{ $variant->discount_percent ?? 0 }})">
                            <i class="bi bi-cart-plus"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @empty
            <div class="empty-state" style="grid-column: 1/-1;">
                <i class="bi bi-inbox"></i>
                <h3>Belum Ada Produk</h3>
                <p>Produk akan segera ditambahkan</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Sticky Cart Summary -->
<div class="cart-summary-sticky" id="cartSummary">
    <div class="cart-info">
        <div class="cart-count" id="cartCount">0</div>
        <div class="cart-details">
            <h3>Keranjang Belanja</h3>
            <div class="cart-total" id="cartTotal">Rp 0</div>
        </div>
    </div>
    <button class="btn-checkout-sticky" onclick="openCheckoutModal()">
        <i class="bi bi-credit-card"></i>
        Checkout Sekarang
    </button>
</div>

<!-- Checkout Modal -->
<div class="modal" id="checkoutModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>🛒 Checkout Pesanan</h3>
            <button class="btn-close" onclick="closeCheckoutModal()">
                <i class="bi bi-x"></i>
            </button>
        </div>
        
        <div class="modal-body">
            <div class="order-summary">
                <h4>📦 Ringkasan Pesanan</h4>
                <div id="orderItems"></div>
            </div>

            <div class="total-section">
                @if($membership && $membership->is_active && $membership->discount_rate > 0)
                <div class="total-row" style="color: #6b7280; font-size: 14px;">
                    <span>Subtotal</span>
                    <span id="subtotalAmount">Rp 0</span>
                </div>
                <div class="total-row" style="color: #10b981; font-size: 14px; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px;">
                    <span>
                        🎁 Diskon Member {{ $membership->level->name }} ({{ number_format($membership->discount_rate, 2) }}%)
                    </span>
                    <span id="discountAmount">- Rp 0</span>
                </div>
                @endif
                <div class="total-row">
                    <span>Total Pembayaran</span>
                    <span class="total-amount" id="totalAmount">Rp 0</span>
                </div>
            </div>

            <div class="payment-method-info" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 15px; border-radius: 12px; margin-bottom: 20px; color: white;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <i class="bi bi-credit-card" style="font-size: 24px;"></i>
                    <div>
                        <div style="font-size: 12px; opacity: 0.9;">💳 Metode Pembayaran</div>
                        <div style="font-size: 18px; font-weight: 700;">Kartu Virtual</div>
                    </div>
                </div>
                <div style="font-size: 13px; opacity: 0.95; margin-top: 8px;">
                    <i class="bi bi-info-circle"></i> Saldo akan terpotong otomatis dari Kartu Virtual Anda
                </div>
            </div>

            <form id="checkoutForm">
                <div class="form-group">
                    <label for="pin">🔒 Masukkan PIN Virtual Card</label>
                    <input type="password" id="pin" name="pin" maxlength="4" placeholder="****" required autocomplete="off">
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" onclick="closeCheckoutModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-shield-check"></i> Bayar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let cart = [];
    const userBalance = {{ $balance }};

    function addToCart(variantId, productName, variantName, price, originalPrice, stock, discount) {
        // Cek apakah sudah ada di cart
        const existingItem = cart.find(item => item.variant_id === variantId);
        
        if (existingItem) {
            if (existingItem.quantity >= stock) {
                showAlert('Stok tidak mencukupi!', 'error');
                return;
            }
            existingItem.quantity++;
        } else {
            cart.push({
                variant_id: variantId,
                product_name: productName,
                variant_name: variantName,
                price: price,
                original_price: originalPrice,
                quantity: 1,
                stock: stock,
                discount: discount
            });
        }

        updateCartUI();
        showAlert(`${productName} ditambahkan ke keranjang!`, 'success');
    }

    function updateCartUI() {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        document.getElementById('cartCount').textContent = totalItems;
        document.getElementById('cartTotal').textContent = `Rp ${formatNumber(totalPrice)}`;

        // Show/hide cart summary
        if (totalItems > 0) {
            document.getElementById('cartSummary').classList.add('active');
        } else {
            document.getElementById('cartSummary').classList.remove('active');
        }
    }

    function openCheckoutModal() {
        if (cart.length === 0) {
            showAlert('Keranjang masih kosong!', 'error');
            return;
        }

        // Render order items
        let orderItemsHtml = '';
        let total = 0;

        cart.forEach(item => {
            const subtotal = item.price * item.quantity;
            total += subtotal;

            orderItemsHtml += `
                <div class="order-item">
                    <div class="item-info">
                        <h5>${item.product_name}</h5>
                        <p>${item.variant_name} × ${item.quantity}</p>
                    </div>
                    <div class="item-price">Rp ${formatNumber(subtotal)}</div>
                </div>
            `;
        });

        document.getElementById('orderItems').innerHTML = orderItemsHtml;

        // Apply membership discount if applicable
        @if($membership && $membership->is_active && $membership->discount_rate > 0)
        const discountRate = {{ $membership->discount_rate }};
        const subtotal = total;
        const discountAmount = total * (discountRate / 100);
        total = total - discountAmount;

        document.getElementById('subtotalAmount').textContent = `Rp ${formatNumber(subtotal)}`;
        document.getElementById('discountAmount').textContent = `- Rp ${formatNumber(discountAmount)}`;
        @endif

        document.getElementById('totalAmount').textContent = `Rp ${formatNumber(total)}`;

        // Check balance
        if (total > userBalance) {
            showAlert(`Saldo tidak mencukupi! Saldo Anda: Rp ${formatNumber(userBalance)}`, 'error');
            return;
        }

        document.getElementById('checkoutModal').classList.add('show');
        document.getElementById('pin').focus();
    }

    function closeCheckoutModal() {
        document.getElementById('checkoutModal').classList.remove('show');
        document.getElementById('checkoutForm').reset();
    }

    // Handle checkout form submission
    document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const pin = document.getElementById('pin').value;

        if (pin.length !== 4) {
            showAlert('PIN harus 4 digit!', 'error');
            return;
        }

        const submitBtn = e.target.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';

        try {
            const response = await fetch('{{ route("customer.shop.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    cart: cart,
                    pin: pin
                })
            });

            const data = await response.json();

            if (data.success) {
                showAlert(data.message, 'success');
                
                // Reset cart
                cart = [];
                updateCartUI();
                closeCheckoutModal();

                // Redirect to orders page after 2 seconds
                setTimeout(() => {
                    window.location.href = '{{ route("customer.orders") }}';
                }, 2000);
            } else {
                showAlert(data.message, 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-shield-check"></i> Bayar Sekarang';
            }
        } catch (error) {
            showAlert('Terjadi kesalahan. Silakan coba lagi.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-shield-check"></i> Bayar Sekarang';
        }
    });

    // Only allow numbers in PIN input
    document.getElementById('pin').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Close modal when clicking outside
    document.getElementById('checkoutModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCheckoutModal();
        }
    });

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '300px';
        alertDiv.style.animation = 'slideIn 0.3s ease';

        const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'x-circle' : 'info-circle';
        alertDiv.innerHTML = `<i class="bi bi-${icon}"></i> ${message}`;

        document.body.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => alertDiv.remove(), 300);
        }, 3000);
    }
</script>

<style>
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
