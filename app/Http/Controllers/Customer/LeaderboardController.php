<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Membership;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    /**
     * Display leaderboard
     */
    public function index()
    {
        // Get top customers by spending
        $topCustomers = User::whereHas('membership')
            ->with(['membership.level'])
            ->join('memberships', 'users.id', '=', 'memberships.user_id')
            ->select('users.*', 'memberships.total_spending', 'memberships.points')
            ->where('memberships.is_active', true)
            ->orderBy('memberships.total_spending', 'desc')
            ->limit(50)
            ->get();

        // Get current user ranking
        $currentUser = auth()->user();
        $userRanking = null;
        
        if ($currentUser->membership) {
            $userRanking = User::join('memberships', 'users.id', '=', 'memberships.user_id')
                ->where('memberships.is_active', true)
                ->where('memberships.total_spending', '>', $currentUser->membership->total_spending)
                ->count() + 1;
        }

        // Get available vouchers for top members
        $vouchers = Voucher::where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->get();

        return view('customer.leaderboard.index', compact('topCustomers', 'userRanking', 'vouchers'));
    }

    /**
     * Claim voucher for top ranking
     */
    public function claimVoucher(Request $request, $voucherId)
    {
        $user = auth()->user();

        if (!$user->membership) {
            return back()->with('error', 'Hanya member yang bisa klaim voucher!');
        }

        $voucher = Voucher::findOrFail($voucherId);

        // Check if voucher is valid
        if (!$voucher->isValid()) {
            return back()->with('error', 'Voucher tidak valid atau sudah habis masa berlakunya.');
        }

        // Check if user already claimed this voucher
        $alreadyClaimed = $user->vouchers()->where('voucher_id', $voucherId)->exists();
        
        if ($alreadyClaimed) {
            return back()->with('error', 'Anda sudah mengklaim voucher ini!');
        }

        // Check usage limit per user
        $userUsageCount = $user->vouchers()->where('voucher_id', $voucherId)->count();
        if ($userUsageCount >= $voucher->usage_per_user) {
            return back()->with('error', 'Anda sudah mencapai batas penggunaan voucher ini!');
        }

        // Attach voucher to user
        $user->vouchers()->attach($voucherId, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Voucher berhasil diklaim! Gunakan kode: ' . $voucher->code);
    }
}
