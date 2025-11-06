@extends('layouts.customer')

@section('title', 'Leaderboard')

@section('content')
<style>
    .leaderboard-hero {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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

    .leaderboard-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 20px 60px;
    }

    .user-rank-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        text-align: center;
    }

    .user-rank-title {
        font-size: 20px;
        color: #6b7280;
        margin-bottom: 15px;
    }

    .user-rank-value {
        font-size: 64px;
        font-weight: 700;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .leaderboard-table {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }

    .table-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #1f2937;
    }

    .leaderboard-item {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        display: grid;
        grid-template-columns: 60px 1fr 150px 150px;
        align-items: center;
        gap: 20px;
        transition: background 0.3s;
    }

    .leaderboard-item:hover {
        background: #f9fafb;
    }

    .leaderboard-item:last-child {
        border-bottom: none;
    }

    .rank {
        font-size: 24px;
        font-weight: 700;
        text-align: center;
    }

    .rank-1 { color: #fbbf24; }
    .rank-2 { color: #9ca3af; }
    .rank-3 { color: #cd7f32; }

    .rank-icon {
        font-size: 32px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-center;
        font-size: 20px;
        color: white;
        font-weight: 700;
        flex-shrink: 0;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-name {
        font-weight: 700;
        color: #1f2937;
        font-size: 18px;
    }

    .user-level {
        font-size: 14px;
        color: #6b7280;
        margin-top: 4px;
    }

    .user-spending {
        font-weight: 700;
        color: #10b981;
        font-size: 18px;
    }

    .user-points {
        font-weight: 700;
        color: #8b5cf6;
        font-size: 18px;
    }

    .highlight-user {
        background: #fef3c7 !important;
        border-left: 4px solid #f59e0b;
    }

    .vouchers-section {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .vouchers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .voucher-card {
        border: 2px dashed #e5e7eb;
        border-radius: 15px;
        padding: 25px;
        transition: all 0.3s;
    }

    .voucher-card:hover {
        border-color: #667eea;
        background: #f3f4f6;
    }

    .voucher-code {
        font-size: 24px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 10px;
        font-family: 'Courier New', monospace;
    }

    .voucher-name {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .voucher-desc {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .claim-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .claim-btn:hover {
        transform: translateY(-2px);
    }

    .claimed-badge {
        width: 100%;
        padding: 12px;
        background: #10b981;
        color: white;
        border-radius: 8px;
        font-weight: 700;
        text-align: center;
    }

    @media (max-width: 768px) {
        .leaderboard-item {
            grid-template-columns: 50px 1fr;
        }

        .user-spending, .user-points {
            grid-column: 2;
            font-size: 14px;
        }
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

<div class="leaderboard-hero">
    <h1 class="hero-title">🏆 Leaderboard</h1>
    <p class="hero-subtitle">Customer terbaik dengan belanja terbanyak</p>
</div>

<div class="leaderboard-container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if($userRanking)
    <div class="user-rank-card">
        <div class="user-rank-title">🎯 Peringkat Anda</div>
        <div class="user-rank-value">#{{ $userRanking }}</div>
        <div style="color: #6b7280; margin-top: 10px;">
            Total Belanja: <strong>Rp {{ number_format(auth()->user()->membership->total_spending, 0, ',', '.') }}</strong>
        </div>
    </div>
    @endif

    <div class="leaderboard-table">
        <h2 class="table-title">👥 Top Customer</h2>
        
        @forelse($topCustomers as $index => $customer)
            @php
                $isCurrentUser = $customer->id === auth()->id();
                $rank = $index + 1;
            @endphp
            <div class="leaderboard-item {{ $isCurrentUser ? 'highlight-user' : '' }}">
                <div class="rank rank-{{ min($rank, 3) }}">
                    @if($rank === 1)
                        <span class="rank-icon">🥇</span>
                    @elseif($rank === 2)
                        <span class="rank-icon">🥈</span>
                    @elseif($rank === 3)
                        <span class="rank-icon">🥉</span>
                    @else
                        #{{ $rank }}
                    @endif
                </div>

                <div class="user-info">
                    <div class="user-avatar">
                        @if($customer->profile_photo)
                            <img src="{{ asset('storage/' . $customer->profile_photo) }}" alt="{{ $customer->name }}">
                        @else
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="user-name">
                            {{ $customer->name }}
                            @if($isCurrentUser)
                                <span style="color: #f59e0b; font-size: 14px;">(Anda)</span>
                            @endif
                        </div>
                        <div class="user-level">
                            {{ $customer->membership->level->name ?? 'Member' }}
                        </div>
                    </div>
                </div>

                <div class="user-spending">
                    💰 Rp {{ number_format($customer->total_spending, 0, ',', '.') }}
                </div>

                <div class="user-points">
                    ⭐ {{ $customer->points }} pts
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px; color: #6b7280;">
                Belum ada data leaderboard
            </div>
        @endforelse
    </div>

    @if($vouchers->count() > 0)
    <div class="vouchers-section">
        <h2 class="table-title">🎟️ Voucher untuk Top Ranking</h2>
        <div class="vouchers-grid">
            @foreach($vouchers as $voucher)
                <div class="voucher-card">
                    <div class="voucher-code">{{ $voucher->code }}</div>
                    <div class="voucher-name">{{ $voucher->name }}</div>
                    <div class="voucher-desc">
                        {{ $voucher->description }}
                        <br>
                        <strong>
                            Diskon: 
                            @if($voucher->type === 'percentage')
                                {{ $voucher->value }}%
                            @else
                                Rp {{ number_format($voucher->value, 0, ',', '.') }}
                            @endif
                        </strong>
                    </div>

                    @if(auth()->user()->vouchers->contains($voucher->id))
                        <div class="claimed-badge">
                            ✓ Sudah Diklaim
                        </div>
                    @else
                        <form action="{{ route('customer.leaderboard.claim-voucher', $voucher->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="claim-btn">
                                🎁 Klaim Voucher
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
