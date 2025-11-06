@extends('layouts.customer')

@section('title', 'Top-up Saldo')

@section('content')
<style>
    .topup-container {
        max-width: 600px;
        margin: 60px auto;
        padding: 20px;
    }

    .topup-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .topup-title {
        font-size: 32px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
        color: #1f2937;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 15px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
    }

    .amount-presets {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-top: 10px;
    }

    .preset-btn {
        padding: 12px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        background: white;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    .preset-btn:hover {
        border-color: #667eea;
        background: #f3f4f6;
    }

    .preset-btn.active {
        border-color: #667eea;
        background: #667eea;
        color: white;
    }

    .submit-btn {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .payment-method-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 10px;
    }

    .payment-option {
        padding: 20px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .payment-option:hover {
        border-color: #667eea;
        background: #f3f4f6;
    }

    .payment-option.selected {
        border-color: #667eea;
        background: #ede9fe;
    }

    .payment-option input[type="radio"] {
        display: none;
    }

    .payment-icon {
        font-size: 32px;
        margin-bottom: 8px;
    }

    .payment-name {
        font-weight: 600;
        font-size: 14px;
        color: #374151;
    }

    /* Bank Info Styles */
    .bank-info-section, .ewallet-info-section, .cash-info-section {
        display: none;
        margin-top: 20px;
        border-radius: 16px;
        padding: 25px;
        animation: slideDown 0.3s ease;
    }

    .bank-info-section.show, .ewallet-info-section.show, .cash-info-section.show {
        display: block;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bank-info-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .bank-info-title, .ewallet-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .bank-account {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
    }

    .bank-account:last-child { margin-bottom: 0; }

    .bank-name {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .account-number {
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 2px;
        margin: 10px 0;
        font-family: 'Courier New', monospace;
    }

    .account-name {
        font-size: 13px;
        opacity: 0.9;
        margin-bottom: 10px;
    }

    .copy-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        cursor: pointer;
        border: none;
    }

    .copy-btn:hover { background: rgba(255, 255, 255, 0.3); }

    .ewallet-info-section { background: #dbeafe; }
    .ewallet-title { color: #1e40af; }

    .ewallet-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: white;
        border-radius: 12px;
        margin-bottom: 12px;
    }

    .ewallet-item:last-child { margin-bottom: 0; }
    .ewallet-logo { font-size: 36px; }
    .ewallet-details { flex: 1; }
    .ewallet-name { font-weight: 700; color: #1f2937; margin-bottom: 3px; font-size: 16px; }
    .ewallet-number { color: #6b7280; font-size: 14px; font-family: 'Courier New', monospace; }

    .cash-info-section {
        background: #d1fae5;
        border-left: 4px solid #10b981;
    }

    .cash-info-section h4 {
        font-size: 16px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 10px;
    }

    .cash-info-section p {
        color: #047857;
        font-size: 14px;
        line-height: 1.6;
    }
</style>

<div class="topup-container">
    <div class="topup-card">
        <h1 class="topup-title">💰 Top-up Saldo</h1>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('customer.balance.process-topup') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Nominal Top-up</label>
                <input type="number" name="amount" id="amount" class="form-control" 
                       placeholder="Masukkan nominal" min="10000" step="1000" required>
                
                <div class="amount-presets">
                    <button type="button" class="preset-btn" data-amount="50000">Rp 50.000</button>
                    <button type="button" class="preset-btn" data-amount="100000">Rp 100.000</button>
                    <button type="button" class="preset-btn" data-amount="200000">Rp 200.000</button>
                    <button type="button" class="preset-btn" data-amount="500000">Rp 500.000</button>
                    <button type="button" class="preset-btn" data-amount="1000000">Rp 1.000.000</button>
                    <button type="button" class="preset-btn" data-amount="2000000">Rp 2.000.000</button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Metode Pembayaran</label>
                <div class="payment-method-grid">
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="bank_transfer" required>
                        <div class="payment-icon">🏦</div>
                        <div class="payment-name">Transfer Bank</div>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="e_wallet" required>
                        <div class="payment-icon">📱</div>
                        <div class="payment-name">E-Wallet</div>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cash" required>
                        <div class="payment-icon">💵</div>
                        <div class="payment-name">Cash</div>
                    </label>
                </div>
            </div>

            <!-- Bank Transfer Info -->
            <div class="bank-info-section" id="bankInfo">
                <div class="bank-info-title">🏦 Transfer ke Rekening Berikut:</div>
                
                <div class="bank-account">
                    <div class="bank-name">🔵 BCA (Bank Central Asia)</div>
                    <div class="account-number">1234567890</div>
                    <div class="account-name">a/n PT SELLIN KASIR DIGITAL</div>
                    <button type="button" class="copy-btn" onclick="copyToClipboard('1234567890', this)">
                        📋 Copy Nomor Rekening
                    </button>
                </div>

                <div class="bank-account">
                    <div class="bank-name">🔴 Mandiri</div>
                    <div class="account-number">9876543210</div>
                    <div class="account-name">a/n PT SELLIN KASIR DIGITAL</div>
                    <button type="button" class="copy-btn" onclick="copyToClipboard('9876543210', this)">
                        📋 Copy Nomor Rekening
                    </button>
                </div>

                <div class="bank-account">
                    <div class="bank-name">🟢 BNI (Bank Negara Indonesia)</div>
                    <div class="account-number">5555666677</div>
                    <div class="account-name">a/n PT SELLIN KASIR DIGITAL</div>
                    <button type="button" class="copy-btn" onclick="copyToClipboard('5555666677', this)">
                        📋 Copy Nomor Rekening
                    </button>
                </div>
            </div>

            <!-- E-Wallet Info -->
            <div class="ewallet-info-section" id="ewalletInfo">
                <div class="ewallet-title">📱 Transfer ke E-Wallet Berikut:</div>
                
                <div class="ewallet-item">
                    <div class="ewallet-logo">🟢</div>
                    <div class="ewallet-details">
                        <div class="ewallet-name">GoPay</div>
                        <div class="ewallet-number">0812-3456-7890</div>
                    </div>
                    <button type="button" class="copy-btn" style="background: #00AA13; border: none;" onclick="copyToClipboard('081234567890', this)">
                        Copy
                    </button>
                </div>

                <div class="ewallet-item">
                    <div class="ewallet-logo">🔵</div>
                    <div class="ewallet-details">
                        <div class="ewallet-name">OVO</div>
                        <div class="ewallet-number">0812-3456-7890</div>
                    </div>
                    <button type="button" class="copy-btn" style="background: #4C3494; border: none;" onclick="copyToClipboard('081234567890', this)">
                        Copy
                    </button>
                </div>

                <div class="ewallet-item">
                    <div class="ewallet-logo">🔴</div>
                    <div class="ewallet-details">
                        <div class="ewallet-name">DANA</div>
                        <div class="ewallet-number">0812-3456-7890</div>
                    </div>
                    <button type="button" class="copy-btn" style="background: #118EEA; border: none;" onclick="copyToClipboard('081234567890', this)">
                        Copy
                    </button>
                </div>
            </div>

            <!-- Cash Info -->
            <div class="cash-info-section" id="cashInfo">
                <h4>💵 Pembayaran Tunai</h4>
                <p>
                    Silakan datang ke kasir terdekat untuk melakukan pembayaran tunai. 
                    Setelah pembayaran, kasir akan langsung mengaktifkan saldo Anda.
                </p>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor Referensi (Opsional)</label>
                <input type="text" name="reference_number" class="form-control" 
                       placeholder="Nomor transfer/bukti pembayaran">
            </div>

            <div class="form-group">
                <label class="form-label">📸 Upload Bukti Transfer *</label>
                <input type="file" name="proof_of_payment" id="proofUpload" class="form-control" 
                       accept="image/*" required style="padding: 10px;">
                <small style="color: #6b7280; display: block; margin-top: 8px;">
                    Format: JPG, PNG, JPEG • Maksimal 2MB
                </small>
                <div id="imagePreview" style="margin-top: 15px; display: none;">
                    <img id="preview" src="" style="max-width: 100%; max-height: 300px; border-radius: 10px; border: 2px solid #e5e7eb;">
                </div>
            </div>

            <button type="submit" class="submit-btn">
                ✅ Kirim Permintaan Top-up
            </button>
        </form>
    </div>
</div>

<script>
    // Preset amount buttons
    document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const amount = this.dataset.amount;
            document.getElementById('amount').value = amount;
            
            document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Payment method selection
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            
            // Show/hide payment info sections
            const method = radio.value;
            document.getElementById('bankInfo').classList.remove('show');
            document.getElementById('ewalletInfo').classList.remove('show');
            document.getElementById('cashInfo').classList.remove('show');
            
            if (method === 'bank_transfer') {
                document.getElementById('bankInfo').classList.add('show');
            } else if (method === 'e_wallet') {
                document.getElementById('ewalletInfo').classList.add('show');
            } else if (method === 'cash') {
                document.getElementById('cashInfo').classList.add('show');
            }
        });
    });

    // Copy to clipboard function
    function copyToClipboard(text, button) {
        navigator.clipboard.writeText(text).then(function() {
            const originalText = button.innerHTML;
            button.innerHTML = '✓ Berhasil Dicopy!';
            button.style.opacity = '0.8';
            
            setTimeout(function() {
                button.innerHTML = originalText;
                button.style.opacity = '1';
            }, 2000);
        }).catch(function(err) {
            alert('Gagal copy: ' + err);
        });
    }

    // Preview image before upload
    document.getElementById('proofUpload')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate size
            if (file.size > 2048 * 1024) {
                alert('❌ Ukuran file terlalu besar! Maksimal 2MB.');
                this.value = '';
                return;
            }

            // Preview
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('preview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
