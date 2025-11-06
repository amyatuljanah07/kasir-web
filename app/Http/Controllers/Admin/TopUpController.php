<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BalanceTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    /**
     * Display pending top-up requests
     */
    public function index()
    {
        $pendingTopups = BalanceTransaction::where('type', 'credit')
            ->where('status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $completedTopups = BalanceTransaction::where('type', 'credit')
            ->whereIn('status', ['completed', 'rejected'])
            ->with(['user', 'verifier'])
            ->orderBy('verified_at', 'desc')
            ->paginate(10);

        return view('admin.topup.index', compact('pendingTopups', 'completedTopups'));
    }

    /**
     * Show detail top-up
     */
    public function show($id)
    {
        $transaction = BalanceTransaction::with('user')->findOrFail($id);
        
        return view('admin.topup.show', compact('transaction'));
    }

    /**
     * Approve top-up request
     */
    public function approve($id)
    {
        $transaction = BalanceTransaction::findOrFail($id);
        
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses!');
        }

        DB::beginTransaction();
        try {
            $user = $transaction->user;
            
            // Update user balance
            $user->balance += $transaction->amount;
            $user->save();
            
            // Update transaction
            $transaction->update([
                'status' => 'completed',
                'balance_after' => $user->balance,
                'completed_at' => now(),
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
            
            DB::commit();

            // TODO: Send notification to customer
            // Mail::to($user->email)->send(new TopupApproved($transaction));

            return back()->with('success', '✅ Top-up berhasil diapprove! Saldo customer telah ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reject top-up request
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $transaction = BalanceTransaction::findOrFail($id);
        
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses!');
        }

        DB::beginTransaction();
        try {
            $transaction->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            DB::commit();

            // TODO: Send notification to customer
            // Mail::to($transaction->user->email)->send(new TopupRejected($transaction));

            return back()->with('success', '❌ Top-up berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
