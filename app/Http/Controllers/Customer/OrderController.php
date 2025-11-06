<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['items.variant.product', 'verifier'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.variant.product', 'verifier']);

        return view('customer.orders.show', compact('order'));
    }

    public function receipt(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.variant.product', 'user']);

        return view('customer.orders.receipt', compact('order'));
    }
}
