@extends('layouts.customer')

@section('title', 'Konfirmasi Top-up')

@section('content')
<style>
    .confirmation-container {
        max-width: 600px;
        margin: 60px auto;
        padding: 20px;
    }

    .confirmation-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        text-align: center;
    }

    .success-icon {
        font-size: 80px;
        margin-bottom: 20px;
    }

    .confirmation-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #1f2937;
    }

    .confirmation-desc {
        color: #6b7280;
        margin-bottom: 30px;
        font-size: 16px;
        line-height: 1.6;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-label {
        color: #6b7280;
        font-weight: 600;
    }

    .detail-value {
        color: #1f2937;
        font-weight: 700;
    }

    .back-btn {
        display: inline-block;
        margin-top: 30px;
        padding: 15px 40px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        transition: transform 0.2s;
    }

    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .warning-box {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        border-radius: 12px;
        padding: 20px;
        margin: 25px 0;
        text-align: left;
    }

    .warning-box h4 {
        font-size: 16px;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .warning-box p {
        color: #78350f;
        font-size: 14px;
        line-height: 1.6;
        margin: 0;
    }
</style>

<div class="confirmation-container">
    <div class="confirmation-card">
        <div class="success-icon">⏳</div>
        <h1 class="confirmation-title">Permintaan Top-up Diterima</h1>
        <p class="confirmation-desc">
            Permintaan top-up Anda sedang dalam proses verifikasi oleh admin. Mohon tunggu 5-15 menit untuk persetujuan.
        </p>

        <div style="text-align: left; margin: 30px 0;">
            <div class="detail-row">
                <span class="detail-label">Nominal</span>
                <span class="detail-value">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Metode Pembayaran</span>
                <span class="detail-value">
                    @if($transaction->payment_method == 'bank_transfer')
                        Transfer Bank
                    @elseif($transaction->payment_method == 'e_wallet')
                        E-Wallet
                    @else
                        {{ ucfirst($transaction->payment_method) }}
                    @endif
                </span>
            </div>
            @if($transaction->reference_number)
            <div class="detail-row">
                <span class="detail-label">No. Referensi</span>
                <span class="detail-value">{{ $transaction->reference_number }}</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value" style="color: #fbbf24;">⏳ MENUNGGU VERIFIKASI</span>
            </div>
            @if($transaction->proof_of_payment)
            <div class="detail-row">
                <span class="detail-label">Bukti Transfer</span>
                <a href="{{ asset('storage/' . $transaction->proof_of_payment) }}" target="_blank" style="color: #667eea; font-weight: 700;">
                    📄 Lihat Bukti Transfer
                </a>
            </div>
            @endif
        </div>

        <div class="warning-box">
            <h4>
                <span>⏳</span> Menunggu Verifikasi Admin
            </h4>
            <p>
                Tim kami akan memverifikasi bukti transfer Anda dalam waktu 5-15 menit. 
                Anda akan mendapat notifikasi setelah top-up disetujui dan saldo telah masuk ke akun Anda.
                <br><br>
                <strong>Cek status di halaman "Saldo Saya"</strong>
            </p>
        </div>

        <a href="{{ route('customer.balance') }}" class="back-btn">
            ← Lihat Status Verifikasi
        </a>
    </div>
</div>
@endsection
