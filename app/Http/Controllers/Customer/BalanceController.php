<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BalanceTransaction;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    /**
     * Display balance page
     */
    public function index()
    {
        $user = auth()->user();
        $transactions = $user->balanceTransactions()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('customer.balance.index', compact('user', 'transactions'));
    }

    /**
     * Show top-up form
     */
    public function topUp()
    {
        return view('customer.balance.topup');
    }

    /**
     * Process top-up request
     */
    public function processTopUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|in:bank_transfer,e_wallet,cash',
            'reference_number' => 'nullable|string|max:255',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048', // PRODUCTION: Required!
        ]);

        DB::beginTransaction();
        try {
            $user = auth()->user();
            
            // Upload bukti transfer
            $proofPath = null;
            if ($request->hasFile('proof_of_payment')) {
                $proofPath = $request->file('proof_of_payment')->store('payment-proofs', 'public');
            }
            
            // Create pending transaction
            $transaction = BalanceTransaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $request->amount,
                'balance_before' => $user->balance,
                'balance_after' => $user->balance, // Belum berubah, nunggu approve
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'proof_of_payment' => $proofPath, // PRODUCTION: Save proof!
                'description' => 'Top-up saldo via ' . strtoupper($request->payment_method),
                'status' => 'pending', // PRODUCTION: Pending, bukan completed!
            ]);

            DB::commit();

            return redirect()->route('customer.balance.confirmation', $transaction->id)
                ->with('success', 'Permintaan top-up berhasil dibuat. Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show confirmation page
     */
    public function confirmation($id)
    {
        $transaction = BalanceTransaction::where('user_id', auth()->id())
            ->findOrFail($id);
        
        return view('customer.balance.confirmation', compact('transaction'));
    }

    /**
     * Auto approve top-up (for development/demo)
     */
    public function approve($id)
    {
        $transaction = BalanceTransaction::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $user->balance += $transaction->amount;
            $user->save();

            $transaction->status = 'completed';
            $transaction->completed_at = now();
            $transaction->balance_after = $user->balance;
            $transaction->save();

            DB::commit();

            return redirect()->route('customer.balance')
                ->with('success', 'Top-up berhasil! Saldo Anda telah ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
