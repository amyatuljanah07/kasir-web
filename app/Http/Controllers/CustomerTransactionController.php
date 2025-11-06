<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['cashier', 'items.variant.product'])
            ->where('user_id', Auth::id())
            ->latest();

        // Filter by date
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $transactions = $query->paginate(10);

        return view('customer.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Sale::with(['cashier', 'items.variant.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.transactions.show', compact('transaction'));
    }

    public function downloadReceipt($id)
    {
        $transaction = Sale::with(['cashier', 'items.variant.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.transactions.receipt', compact('transaction'));
    }
}
