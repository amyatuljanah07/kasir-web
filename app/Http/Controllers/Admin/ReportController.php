<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with('user', 'items.variant.product');
        
        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
        
        // Filter berdasarkan customer spesifik
        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }
        
        // Filter berdasarkan kasir/user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter berdasarkan produk spesifik
        if ($request->filled('product_id')) {
            $query->whereHas('items.variant', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }
        
        // Filter berdasarkan metode pembayaran
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        $sales = $query->latest()->get();
        
        // Hitung total keuntungan
        $totalKeuntungan = 0;
        foreach ($sales as $sale) {
            foreach ($sale->items as $item) {
                $totalKeuntungan += $item->subtotal;
            }
        }
        
        // Data untuk dropdown filter
        $users = User::whereIn('role_id', [1, 2])->get(); // admin & pegawai
        $products = Product::orderBy('name')->get();
        
        return view('admin.reports.index', compact('sales', 'totalKeuntungan', 'users', 'products'));
    }
    
    public function exportPdf(Request $request)
    {
        $query = Sale::with('user', 'items.variant.product');
        
        // Terapkan filter yang sama
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
        
        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('product_id')) {
            $query->whereHas('items.variant', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }
        
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        $sales = $query->latest()->get();
        
        // Hitung total keuntungan
        $totalKeuntungan = 0;
        foreach ($sales as $sale) {
            foreach ($sale->items as $item) {
                $totalKeuntungan += $item->subtotal;
            }
        }
        
        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'customer_name' => $request->customer_name,
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'payment_method' => $request->payment_method,
        ];
        
        $pdf = Pdf::loadView('admin.reports.pdf', compact('sales', 'totalKeuntungan', 'filters'))
                  ->setPaper('a4', 'landscape');
        
        $filename = 'laporan-penjualan-' . date('Y-m-d-His') . '.pdf';
        return $pdf->download($filename);
    }
    
    public function userOrders(User $user)
    {
        $sales = Sale::where('user_id', $user->id)
                     ->with('items.variant')
                     ->latest()
                     ->get();
        
        return view('admin.reports.user-orders', compact('user', 'sales'));
    }
}
