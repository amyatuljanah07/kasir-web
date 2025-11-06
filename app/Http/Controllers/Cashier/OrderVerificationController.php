<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderVerificationController extends Controller
{
    public function index()
    {
        // Tampilkan order dengan status 'paid' (menunggu pickup)
        $pendingOrders = Order::with(['user', 'items.variant.product'])
            ->where('status', 'paid')
            ->latest()
            ->get();

        // Order yang sudah diverifikasi hari ini
        $verifiedToday = Order::with(['user', 'items.variant.product', 'verifier'])
            ->where('status', 'verified')
            ->whereDate('verified_at', today())
            ->latest()
            ->get();

        return view('cashier.verification.index', compact('pendingOrders', 'verifiedToday'));
    }

    public function verify(Request $request, Order $order)
    {
        $request->validate([
            'order_number' => 'required|string'
        ]);

        // Validasi order number
        if ($order->order_number !== $request->order_number) {
            return back()->with('error', 'Kode order tidak sesuai!');
        }

        // Validasi status
        if ($order->status !== 'paid') {
            return back()->with('error', 'Order ini tidak bisa diverifikasi!');
        }

        // Update status ke verified
        $order->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now()
        ]);

        return back()->with('success', "Order {$order->order_number} berhasil diverifikasi!");
    }

    public function complete(Order $order)
    {
        // Validasi status
        if ($order->status !== 'verified') {
            return back()->with('error', 'Order harus diverifikasi terlebih dahulu!');
        }

        // Update status ke completed
        $order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', "Order {$order->order_number} selesai!");
    }

    public function printReceipt(Order $order)
    {
        // Pastikan order sudah diverifikasi
        if (!in_array($order->status, ['verified', 'completed'])) {
            return back()->with('error', 'Hanya pesanan yang sudah diverifikasi yang bisa dicetak struknya!');
        }

        $order->load(['items.variant.product', 'user', 'verifier']);

        return view('cashier.verification.receipt', compact('order'));
    }
}
