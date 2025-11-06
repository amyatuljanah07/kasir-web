<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VirtualCardController extends Controller
{
    public function index()
    {
        $virtualCard = auth()->user()->virtualCard;
        
        // Jika belum ada virtual card, buat otomatis (fallback)
        if (!$virtualCard) {
            $virtualCard = \App\Models\VirtualCard::create([
                'user_id' => auth()->id(),
                'card_number' => \App\Models\VirtualCard::generateCardNumber(),
                'pin' => Hash::make('1234'),
                'balance' => 100000.00,
                'status' => 'active'
            ]);
        }
        
        // Get recent orders
        $orders = auth()->user()->orders()->latest()->take(5)->get();
        
        return view('customer.virtual-card.index', compact('virtualCard', 'orders'));
    }

    public function changePin(Request $request)
    {
        $request->validate([
            'current_pin' => 'required|digits:4',
            'new_pin' => 'required|digits:4|confirmed'
        ]);

        $virtualCard = auth()->user()->virtualCard;

        if (!$virtualCard->validatePin($request->current_pin)) {
            return back()->with('error', 'PIN lama tidak sesuai!');
        }

        $virtualCard->update([
            'pin' => Hash::make($request->new_pin)
        ]);

        return back()->with('success', 'PIN berhasil diubah!');
    }
}
