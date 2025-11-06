@extends('layouts.customer')

@section('title', 'Membership Program')

@section('content')
<style>
    .membership-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

    .membership-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px 60px;
    }

    .levels-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .levels-grid {
            grid-template-columns: 1fr;
        }
    }

    .level-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        text-align: center;
        transition: transform 0.3s;
        position: relative;
        overflow: hidden;
    }

    .level-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .level-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
    }

    .level-card.nova::before { background: #10b981; }
    .level-card.stellar::before { background: #3b82f6; }
    .level-card.galaxy::before { background: #8b5cf6; }

    .level-icon {
        font-size: 80px;
        margin-bottom: 20px;
    }

    .level-name {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #1f2937;
    }

    .level-requirement {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .level-discount {
        font-size: 48px;
        font-weight: 700;
        margin: 20px 0;
    }

    .level-discount.nova { color: #10b981; }
    .level-discount.stellar { color: #3b82f6; }
    .level-discount.galaxy { color: #8b5cf6; }

    .benefits-list {
        text-align: left;
        margin: 20px 0;
    }

    .benefit-item {
        padding: 10px 0;
        color: #374151;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .join-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        transition: transform 0.2s;
    }

    .join-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .current-badge {
        background: gold;
        color: #1f2937;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        display: inline-block;
        margin-top: 15px;
    }

    .progress-section {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }

    .progress-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #1f2937;
    }

    .progress-bar-container {
        background: #e5e7eb;
        height: 30px;
        border-radius: 15px;
        overflow: hidden;
        margin: 20px 0;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: width 0.5s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
    }

    .alert {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }
</style>

<div class="membership-hero">
    <h1 class="hero-title">🌟 Membership Program</h1>
    <p class="hero-subtitle">Naik level, dapat lebih banyak keuntungan!</p>
</div>

<div class="membership-container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if($userMembership)
    <div class="progress-section">
        <h2 class="progress-title">📊 Progress Membership Anda</h2>
        <div>
            <strong>Level Saat Ini:</strong> {{ $userMembership->level->name }}
        </div>
        <div style="margin-top: 10px;">
            <strong>Total Belanja:</strong> Rp {{ number_format($userMembership->total_spending, 0, ',', '.') }}
        </div>
        <div style="margin-top: 10px;">
            <strong>Poin:</strong> {{ $userMembership->points }} pts
        </div>

        @php
            $nextLevel = \App\Models\MembershipLevel::where('min_spending', '>', $userMembership->total_spending)
                ->orderBy('min_spending', 'asc')
                ->first();
        @endphp

        @if($nextLevel)
            @php
                $remaining = $nextLevel->min_spending - $userMembership->total_spending;
                $progress = ($userMembership->total_spending / $nextLevel->min_spending) * 100;
            @endphp
            <div style="margin-top: 20px;">
                <strong>Progress ke {{ $nextLevel->name }}:</strong>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: {{ min($progress, 100) }}%">
                        {{ number_format($progress, 1) }}%
                    </div>
                </div>
                <div style="text-align: center; color: #6b7280; margin-top: 10px;">
                    Belanja lagi Rp {{ number_format($remaining, 0, ',', '.') }} untuk naik ke {{ $nextLevel->name }}!
                </div>
            </div>
        @else
            <div style="margin-top: 20px; text-align: center; color: #10b981; font-weight: 700; font-size: 20px;">
                🎉 Anda sudah di level tertinggi! 🎉
            </div>
        @endif
    </div>
    @endif

    <div class="levels-grid">
        @foreach($levels as $level)
        <div class="level-card {{ strtolower($level->slug) }}">
            <div class="level-icon">
                @if($level->slug === 'nova')
                    ⭐
                @elseif($level->slug === 'stellar')
                    🌟
                @else
                    🌌
                @endif
            </div>
            <h3 class="level-name">{{ $level->name }}</h3>
            <p class="level-requirement">
                Min. Belanja: <br>
                <strong>Rp {{ number_format($level->min_spending, 0, ',', '.') }}</strong>
            </p>
            <div class="level-discount {{ strtolower($level->slug) }}">
                {{ $level->discount_rate }}% OFF
            </div>

            <div class="benefits-list">
                @foreach(json_decode($level->benefits, true) ?? [] as $benefit)
                    <div class="benefit-item">
                        <span>✓</span>
                        <span>{{ $benefit }}</span>
                    </div>
                @endforeach
            </div>

            @if($userMembership && $userMembership->level->id === $level->id)
                <span class="current-badge">⭐ Level Anda Saat Ini</span>
            @endif
        </div>
        @endforeach
    </div>

    @if(!$userMembership)
    <div style="text-align: center; padding: 40px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <h2 style="font-size: 32px; margin-bottom: 20px;">Bergabung Sekarang!</h2>
        <p style="color: #6b7280; margin-bottom: 30px; font-size: 18px;">
            Mulai dari level Nova dan dapatkan diskon serta keuntungan menarik!
        </p>
        <form action="{{ route('customer.membership.join') }}" method="POST">
            @csrf
            <button type="submit" class="join-btn" style="max-width: 300px;">
                🚀 Gabung Jadi Member
            </button>
        </form>
    </div>
    @else
    <div style="text-align: center; padding: 40px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <h2 style="font-size: 32px; margin-bottom: 20px;">Member Exclusive Content</h2>
        <p style="color: #6b7280; margin-bottom: 30px; font-size: 18px;">
            Akses halaman khusus member dengan promo dan produk eksklusif!
        </p>
        <a href="{{ route('customer.membership.exclusive') }}" class="join-btn" style="max-width: 300px;">
            🔐 Lihat Halaman Eksklusif
        </a>
    </div>
    @endif
</div>
@endsection
