<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\MembershipLevel;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    /**
     * Display membership page
     */
    public function index()
    {
        $levels = MembershipLevel::orderBy('order')->get();
        $userMembership = auth()->user()->membership;
        
        return view('customer.membership.index', compact('levels', 'userMembership'));
    }

    /**
     * Join as member
     */
    public function join(Request $request)
    {
        $user = auth()->user();

        // Check if already a member
        if ($user->membership) {
            return back()->with('error', 'Anda sudah terdaftar sebagai member!');
        }

        DB::beginTransaction();
        try {
            // Get the first level (Nova)
            $firstLevel = MembershipLevel::orderBy('order')->first();

            // Create membership
            $membership = Membership::create([
                'user_id' => $user->id,
                'membership_level_id' => $firstLevel->id,
                'start_date' => now(),
                'end_date' => null, // No end date for now
                'discount_rate' => $firstLevel->discount_rate,
                'total_spending' => 0,
                'points' => 0,
                'is_active' => true,
            ]);

            // Update user is_member flag
            $user->is_member = true;
            $user->save();

            DB::commit();

            return redirect()->route('customer.membership.welcome')
                ->with('success', 'Selamat! Anda sekarang adalah member ' . $firstLevel->name . '!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Welcome page after joining
     */
    public function welcome()
    {
        $user = auth()->user()->load('membership.level');
        
        if (!$user->membership) {
            return redirect()->route('customer.membership');
        }

        return view('customer.membership.welcome', compact('user'));
    }

    /**
     * Member exclusive page
     */
    public function exclusive()
    {
        $user = auth()->user()->load('membership.level');

        if (!$user->membership || !$user->membership->is_active) {
            return redirect()->route('customer.membership')
                ->with('error', 'Halaman ini hanya untuk member. Yuk join sekarang!');
        }

        // Get early access products
        $exclusiveProducts = \App\Models\Product::where('is_early_access', true)
            ->where(function($query) {
                $query->whereNull('early_access_until')
                    ->orWhere('early_access_until', '>=', now());
            })
            ->with(['variants' => function($query) {
                $query->where('stock', '>', 0);
            }])
            ->get();

        $level = $user->membership->level;
        
        return view('customer.membership.exclusive', compact('user', 'level', 'exclusiveProducts'));
    }
}
