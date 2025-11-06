<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['user', 'cashier', 'items'])->latest()->get();
        $totalKeuntungan = $sales->sum(function ($s) {
            return $s->total;
        });

        return view('admin.reports.index', compact('sales', 'totalKeuntungan'));
    }

    public function userOrders(User $user)
    {
        $sales = $user->sales()->with('items.variant.product')->get();
        return view('admin.reports.user_orders', compact('user', 'sales'));
    }
}
