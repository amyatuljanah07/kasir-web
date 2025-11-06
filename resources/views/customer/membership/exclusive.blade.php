@extends('layouts.customer')

@section('title', 'Member Exclusive')

@section('content')
<style>
    .exclusive-hero {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        padding: 60px 20px;
        text-align: center;
        color: white;
        margin-bottom: 40px;
    }

    .hero-title {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .hero-subtitle {
        font-size: 20px;
        opacity: 0.9;
    }

    .exclusive-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px 60px;
    }

    .perks-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .perks-grid {
            grid-template-columns: 1fr;
        }
    }

    .perk-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        text-align: center;
        transition: transform 0.3s;
    }

    .perk-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .perk-icon {
        font-size: 60px;
        margin-bottom: 20px;
    }

    .perk-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1f2937;
    }

    .perk-description {
        color: #6b7280;
        font-size: 16px;
        line-height: 1.6;
    }

    .member-stats {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .stat-item {
        padding: 20px;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 700;
        color: #8b5cf6;
        margin-bottom: 8px;
    }

    .stat-label {
        color: #6b7280;
        font-size: 14px;
        font-weight: 600;
    }

    .exclusive-products {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .section-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #1f2937;
    }

    .coming-soon {
        text-align: center;
        padding: 60px;
        color: #6b7280;
        font-size: 18px;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: 1fr;
        }
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        border: 2px solid transparent;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(139, 92, 246, 0.3);
        border-color: #8b5cf6;
    }

    .early-access-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: linear-gradient(135deg, #f59e0b 0%, #eab308 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        z-index: 10;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.5);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .discount-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #ef4444;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        z-index: 10;
    }

    .product-image {
        width: 100%;
        height: 240px;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 80px;
        position: relative;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        padding: 20px;
    }

    .product-name {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-variant {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 12px;
    }

    .product-price {
        font-size: 22px;
        font-weight: 700;
        color: #8b5cf6;
        margin-bottom: 8px;
    }

    .product-original-price {
        font-size: 14px;
        color: #9ca3af;
        text-decoration: line-through;
        margin-bottom: 10px;
    }

    .product-stock {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 15px;
        display: block;
    }

    .btn-add-cart {
        width: 100%;
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(139, 92, 246, 0.4);
    }

    .empty-icon {
        font-size: 80px;
        margin-bottom: 20px;
        opacity: 0.5;
    }
</style>

<div class="exclusive-hero">
    <h1 class="hero-title">🔐 Member Exclusive</h1>
    <p class="hero-subtitle">Area khusus untuk member {{ $level->name }}</p>
</div>

<div class="exclusive-container">
    <div class="member-stats">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ $level->name }}</div>
                <div class="stat-label">Level Anda</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $level->discount_rate }}%</div>
                <div class="stat-label">Diskon</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $user->membership->points }}</div>
                <div class="stat-label">Total Poin</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $level->points_multiplier }}x</div>
                <div class="stat-label">Poin Multiplier</div>
            </div>
        </div>
    </div>

    <div class="perks-grid">
        <div class="perk-card">
            <div class="perk-icon">🎁</div>
            <h3 class="perk-title">Promo Eksklusif</h3>
            <p class="perk-description">
                Dapatkan akses promo khusus member dengan diskon hingga {{ $level->discount_rate }}% untuk setiap pembelian.
            </p>
        </div>

        <div class="perk-card">
            <div class="perk-icon">⚡</div>
            <h3 class="perk-title">Early Access</h3>
            <p class="perk-description">
                Jadilah yang pertama mendapatkan produk baru sebelum diluncurkan ke publik.
            </p>
        </div>

        <div class="perk-card">
            <div class="perk-icon">🎂</div>
            <h3 class="perk-title">Birthday Surprise</h3>
            <p class="perk-description">
                Voucher spesial di hari ulang tahun Anda sebagai apresiasi dari kami.
            </p>
        </div>

        @if($level->slug === 'stellar' || $level->slug === 'galaxy')
        <div class="perk-card">
            <div class="perk-icon">🚚</div>
            <h3 class="perk-title">Free Shipping</h3>
            <p class="perk-description">
                Gratis ongkir untuk event tertentu khusus member {{ $level->name }}.
            </p>
        </div>
        @endif

        @if($level->slug === 'galaxy')
        <div class="perk-card">
            <div class="perk-icon">👑</div>
            <h3 class="perk-title">VIP Support</h3>
            <p class="perk-description">
                Personal shopping assistant untuk membantu pembelian Anda.
            </p>
        </div>

        <div class="perk-card">
            <div class="perk-icon">🌟</div>
            <h3 class="perk-title">Galaxy Events</h3>
            <p class="perk-description">
                Undangan eksklusif untuk event khusus member Galaxy.
            </p>
        </div>
        @endif
    </div>

    <div class="exclusive-products">
        <h2 class="section-title">✨ Produk Eksklusif Member</h2>
        
        @if($exclusiveProducts->count() > 0)
            <div class="products-grid">
                @foreach($exclusiveProducts as $product)
                    @foreach($product->variants as $variant)
                        @if($variant->stock > 0)
                        <div class="product-card" onclick="window.location.href='{{ route('customer.shop') }}'">
                            <div class="early-access-badge">
                                ⚡ EARLY ACCESS
                            </div>
                            
                            @if($variant->discount > 0)
                            <div class="discount-badge">
                                -{{ $variant->discount }}%
                            </div>
                            @endif

                            <div class="product-image">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <span>🎁</span>
                                @endif
                            </div>

                            <div class="product-info">
                                <h3 class="product-name" title="{{ $product->name }}">{{ $product->name }}</h3>
                                <p class="product-variant">{{ $variant->variant_name }}</p>
                                
                                <div class="product-price">
                                    Rp {{ number_format($variant->price * (1 - $variant->discount / 100), 0, ',', '.') }}
                                </div>
                                
                                @if($variant->discount > 0)
                                <div class="product-original-price">
                                    Rp {{ number_format($variant->price, 0, ',', '.') }}
                                </div>
                                @endif

                                <span class="product-stock">📦 Stok: {{ $variant->stock }}</span>

                                <button class="btn-add-cart" onclick="event.stopPropagation(); window.location.href='{{ route('customer.shop') }}'">
                                    <i class="bi bi-bag-plus"></i>
                                    Belanja Sekarang
                                </button>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        @else
            <div class="coming-soon">
                <div class="empty-icon">🚀</div>
                <div style="font-size: 24px; font-weight: 700; margin-bottom: 10px;">Coming Soon!</div>
                <p>Produk eksklusif untuk member segera hadir.</p>
                <p>Pantau terus halaman ini untuk update terbaru!</p>
                <a href="{{ route('customer.shop') }}" style="display: inline-block; margin-top: 30px; padding: 15px 40px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 700;">
                    🛍️ Belanja Sekarang
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
