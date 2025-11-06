@extends('layouts.admin')

@section('content')
<style>
    .table-container {
        overflow-x: auto;
    }
    
    .compact-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .compact-table th,
    .compact-table td {
        padding: 12px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .compact-table th {
        background: #f9fafb;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        color: #6b7280;
        white-space: nowrap;
    }
    
    .compact-table tbody tr:hover {
        background: #f9fafb;
    }
    
    .customer-cell {
        min-width: 200px;
    }
    
    .amount-cell {
        min-width: 120px;
        font-weight: 700;
        color: #10b981;
    }
    
    .action-cell {
        min-width: 200px;
    }
    
    .btn-approve,
    .btn-reject {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }
    
    .btn-approve {
        background: #10b981;
        color: white;
    }
    
    .btn-approve:hover {
        background: #059669;
    }
    
    .btn-reject {
        background: #ef4444;
        color: white;
    }
    
    .btn-reject:hover {
        background: #dc2626;
    }
</style>

<div class="px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">
            💳 Verifikasi Top-Up
        </h1>
        <p class="text-gray-600 text-sm">Kelola permintaan top-up dari customer</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button onclick="showTab('pending')" id="tab-pending" class="tab-button border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    ⏳ Menunggu 
                    @if($pendingTopups->total() > 0)
                        <span class="ml-2 bg-blue-100 text-blue-800 py-1 px-2 rounded-full text-xs">
                            {{ $pendingTopups->total() }}
                        </span>
                    @endif
                </button>
                <button onclick="showTab('history')" id="tab-history" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    📋 Riwayat
                </button>
            </nav>
        </div>
    </div>

    <!-- Pending Tab -->
    <div id="content-pending" class="tab-content">
        @if($pendingTopups->count() > 0)
            <div class="bg-white rounded-lg shadow">
                <div class="table-container">
                    <table class="compact-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Bukti</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingTopups as $transaction)
                                <tr>
                                    <td class="customer-cell">
                                        <div class="flex items-center gap-3">
                                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; flex-shrink: 0;">
                                                {{ strtoupper(substr($transaction->user->name, 0, 1)) }}
                                            </div>
                                            <div style="min-width: 0;">
                                                <div style="font-weight: 600; color: #1f2937; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $transaction->user->name }}
                                                </div>
                                                <div style="font-size: 12px; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $transaction->user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="amount-cell">
                                        <div style="font-size: 16px; font-weight: 700; color: #10b981; white-space: nowrap;">
                                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; white-space: nowrap;
                                            {{ $transaction->payment_method === 'bank_transfer' ? 'background: #dbeafe; color: #1e40af;' : '' }}
                                            {{ $transaction->payment_method === 'e_wallet' ? 'background: #e9d5ff; color: #6b21a8;' : '' }}
                                            {{ $transaction->payment_method === 'cash' ? 'background: #d1fae5; color: #065f46;' : '' }}">
                                            @if($transaction->payment_method === 'bank_transfer')
                                                Bank Transfer
                                            @elseif($transaction->payment_method === 'e_wallet')
                                                E-Wallet
                                            @else
                                                {{ ucfirst($transaction->payment_method) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if($transaction->proof_of_payment)
                                            <a href="{{ asset('storage/' . $transaction->proof_of_payment) }}" target="_blank" 
                                               style="color: #2563eb; text-decoration: none; font-size: 13px; font-weight: 500; white-space: nowrap;">
                                                📷 Lihat Bukti
                                            </a>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="font-size: 13px; color: #6b7280; white-space: nowrap;">
                                            {{ $transaction->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="action-cell">
                                        <div style="display: flex; gap: 8px; flex-wrap: nowrap;">
                                            <form action="{{ route('admin.topup.approve', $transaction->id) }}" method="POST" onsubmit="return confirm('Approve top-up ini?')" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="btn-approve">
                                                    ✅ Approve
                                                </button>
                                            </form>
                                            <button onclick="showRejectModal({{ $transaction->id }})" class="btn-reject">
                                                ❌ Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $pendingTopups->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="text-6xl mb-4">✅</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Permintaan Pending</h3>
                <p class="text-gray-500">Semua top-up sudah diproses</p>
            </div>
        @endif
    </div>

    <!-- History Tab -->
    <div id="content-history" class="tab-content hidden">
        @if($completedTopups->count() > 0)
            <div class="bg-white rounded-lg shadow">
                <div class="table-container">
                    <table class="compact-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Diverifikasi Oleh</th>
                                <th>Waktu</th>
                                <th>Alasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedTopups as $transaction)
                                <tr>
                                    <td>
                                        <div style="font-weight: 600; color: #1f2937; font-size: 14px;">
                                            {{ $transaction->user->name }}
                                        </div>
                                        <div style="font-size: 12px; color: #6b7280;">
                                            {{ $transaction->user->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 15px; font-weight: 600; color: #374151; white-space: nowrap;">
                                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($transaction->status === 'completed')
                                            <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; background: #d1fae5; color: #065f46; white-space: nowrap;">
                                                ✅ Approved
                                            </span>
                                        @else
                                            <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; background: #fee2e2; color: #991b1b; white-space: nowrap;">
                                                ❌ Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="font-size: 13px; color: #6b7280;">
                                            {{ $transaction->verifier?->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 13px; color: #6b7280; white-space: nowrap;">
                                            {{ $transaction->verified_at?->diffForHumans() ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 13px; color: #6b7280; max-width: 250px; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $transaction->rejection_reason ?? '-' }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $completedTopups->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="text-6xl mb-4">📋</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Riwayat</h3>
                <p class="text-gray-500">Riwayat verifikasi akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 9999;">
    <div style="background: white; border-radius: 16px; padding: 32px; max-width: 500px; width: 90%; margin: 0 auto; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #1f2937;">
            ❌ Tolak Top-Up
        </h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div style="margin-bottom: 24px;">
                <label style="display: block; color: #374151; font-size: 14px; font-weight: 600; margin-bottom: 8px;">
                    Alasan Penolakan <span style="color: #ef4444;">*</span>
                </label>
                <textarea 
                    name="rejection_reason" 
                    rows="4" 
                    required
                    style="width: 100%; padding: 12px; border: 2px solid #d1d5db; border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical;"
                    placeholder="Contoh: Bukti transfer tidak jelas / Nomor rekening tidak sesuai"></textarea>
            </div>
            <div style="display: flex; gap: 12px;">
                <button 
                    type="button" 
                    onclick="closeRejectModal()" 
                    style="flex: 1; background: #e5e7eb; color: #374151; padding: 12px 24px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; font-size: 14px; transition: all 0.2s;">
                    Batal
                </button>
                <button 
                    type="submit" 
                    style="flex: 1; background: #ef4444; color: white; padding: 12px 24px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; font-size: 14px; transition: all 0.2s;">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Tab switching
    function showTab(tab) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-button').forEach(el => {
            el.classList.remove('border-blue-500', 'text-blue-600');
            el.classList.add('border-transparent', 'text-gray-500');
        });

        // Show selected tab
        document.getElementById('content-' + tab).classList.remove('hidden');
        document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tab-' + tab).classList.add('border-blue-500', 'text-blue-600');
    }

    // Reject modal
    function showRejectModal(transactionId) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.action = `/admin/topup/${transactionId}/reject`;
        modal.style.display = 'flex';
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.style.display = 'none';
        document.getElementById('rejectForm').reset();
    }

    // Close modal on ESC or click outside
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRejectModal();
        }
    });

    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectModal();
        }
    });

    // Hover effects for buttons
    document.querySelectorAll('button[onclick*="closeRejectModal"]').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.background = '#d1d5db';
        });
        btn.addEventListener('mouseleave', function() {
            this.style.background = '#e5e7eb';
        });
    });
</script>
@endsection
