@extends('layouts.customer')

@section('title', 'Selamat Datang Member!')

@section('content')
<style>
    .welcome-container {
        max-width: 800px;
        margin: 60px auto;
        padding: 20px;
        text-align: center;
    }

    .welcome-card {
        background: white;
        border-radius: 20px;
        padding: 60px 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .celebration-icon {
        font-size: 100px;
        margin-bottom: 30px;
    }

    .welcome-title {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .welcome-message {
        font-size: 20px;
        color: #6b7280;
        margin-bottom: 40px;
        line-height: 1.6;
    }

    .member-badge {
        display: inline-block;
        padding: 15px 30px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 30px;
        font-size: 24px;
        font-weight: 700;
        margin: 30px 0;
    }

    .benefits-box {
        background: #f9fafb;
        border-radius: 15px;
        padding: 30px;
        margin: 30px 0;
        text-align: left;
    }

    .benefits-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
        color: #1f2937;
    }

    .benefit-item {
        padding: 12px 0;
        color: #374151;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .cta-buttons {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 40px;
    }

    .cta-btn {
        padding: 18px;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 700;
        text-decoration: none;
        display: inline-block;
        transition: transform 0.2s;
    }

    .cta-btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-secondary {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
</style>

<div class="welcome-container">
    <div class="welcome-card">
        <div class="celebration-icon">🎉</div>
        <h1 class="welcome-title">Selamat!</h1>
        <p class="welcome-message">
            Anda sekarang adalah member resmi <strong>Sellin Kasir</strong>!<br>
            Mari mulai petualangan belanja yang lebih menguntungkan.
        </p>

        <div class="member-badge">
            ⭐ {{ $user->membership->level->name }} Member
        </div>

        <div class="benefits-box">
            <h3 class="benefits-title">🎁 Keuntungan Anda</h3>
            @foreach(json_decode($user->membership->level->benefits, true) ?? [] as $benefit)
                <div class="benefit-item">
                    <span style="color: #10b981; font-size: 20px;">✓</span>
                    <span>{{ $benefit }}</span>
                </div>
            @endforeach
        </div>

        <div class="cta-buttons">
            <a href="{{ route('customer.shop') }}" class="cta-btn btn-primary">
                🛍️ Mulai Belanja
            </a>
            <a href="{{ route('customer.membership.exclusive') }}" class="cta-btn btn-secondary">
                🔐 Halaman Eksklusif
            </a>
        </div>
    </div>
</div>
@endsection
