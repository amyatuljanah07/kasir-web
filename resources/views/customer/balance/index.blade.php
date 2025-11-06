@extends('layouts.customer')

@section('title', 'Saldo Saya')

@section('content')
<style>
    .balance-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .balance-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .balance-amount {
        font-size: 48px;
        font-weight: 700;
        margin: 20px 0;
    }

    .balance-label {
        font-size: 18px;
        opacity: 0.9;
    }

    .topup-btn {
        background: white;
        color: #667eea;
        padding: 15px 40px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        transition: transform 0.2s;
    }

    .topup-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .transaction-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .transaction-item {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-type {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .transaction-date {
        font-size: 14px;
        color: #6b7280;
    }

    .transaction-amount {
        font-size: 20px;
        font-weight: 700;
    }

    .credit {
        color: #10b981;
    }

    .debit {
        color: #ef4444;
    }

    .badge-pending {
        background: #fbbf24;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-completed {
        background: #10b981;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-rejected {
        background: #ef4444;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: 600;
    }
</style>

<div class="balance-container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="balance-card">
        <div class="balance-label">💰 Total Saldo</div>
        <div class="balance-amount">Rp {{ number_format($user->balance, 0, ',', '.') }}</div>
        <a href="{{ route('customer.balance.topup') }}" class="topup-btn">
            ➕ Top-up Saldo
        </a>
    </div>

    <div class="transaction-card">
        <h2 style="margin-bottom: 20px; font-weight: 700;">📊 Riwayat Transaksi</h2>
        
        @forelse($transactions as $transaction)
            <div class="transaction-item">
                <div>
                    <div class="transaction-type">
                        {{ $transaction->description }}
                    </div>
                    <div class="transaction-date">
                        {{ $transaction->created_at->format('d M Y, H:i') }}
                        @if($transaction->payment_method)
                            · {{ strtoupper($transaction->payment_method) }}
                        @endif
                    </div>
                </div>
                <div style="text-align: right;">
                    <div class="transaction-amount {{ $transaction->type === 'credit' ? 'credit' : 'debit' }}">
                        {{ $transaction->type === 'credit' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </div>
                    @if($transaction->status === 'pending')
                        <span class="badge-pending">⏳ Pending</span>
                    @elseif($transaction->status === 'completed')
                        <span class="badge-completed">✅ Completed</span>
                    @elseif($transaction->status === 'rejected')
                        <span class="badge-rejected">❌ Rejected</span>
                    @endif
                    @if($transaction->status === 'rejected' && $transaction->rejection_reason)
                        <div style="font-size: 12px; color: #ef4444; margin-top: 5px;">
                            {{ $transaction->rejection_reason }}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px; color: #6b7280;">
                Belum ada transaksi
            </div>
        @endforelse

        <div style="margin-top: 20px;">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
