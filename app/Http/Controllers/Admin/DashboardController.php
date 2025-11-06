<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan metrik penjualan dan grafik
     */
    public function index()
    {
        // ========== METRIK PENJUALAN ==========
        
        // Total penjualan hari ini
        $salesToday = Sale::whereDate('created_at', Carbon::today())
            ->sum('total');
        
        // Total penjualan minggu ini
        $salesThisWeek = Sale::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->sum('total');
        
        // Total penjualan bulan ini
        $salesThisMonth = Sale::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');
        
        // ========== KEUNTUNGAN BERSIH ==========
        
        // Hitung keuntungan dari sale_items (harga jual - harga modal)
        $profitToday = $this->calculateProfit(Carbon::today(), Carbon::today());
        $profitThisWeek = $this->calculateProfit(
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        );
        $profitThisMonth = $this->calculateProfit(
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        );
        
        // ========== STATISTIK UMUM ==========
        
        // Total transaksi hari ini
        $transactionsToday = Sale::whereDate('created_at', Carbon::today())->count();
        
        // Total produk
        $totalProducts = Product::count();
        
        // Produk stok menipis (< 10) - ambil data produk untuk ditampilkan di tabel
        $lowStockProducts = Product::with('variants')
            ->get()
            ->filter(function($product) {
                return $product->variants->sum('stock') < 10;
            });
        
        // Total user berdasarkan role
        $totalUsers = User::count();
        $totalCashiers = User::whereHas('role', function($q) {
            $q->where('name', 'pegawai');
        })->count();
        $totalCustomers = User::whereHas('role', function($q) {
            $q->where('name', 'customer');
        })->count();
        
        // Hitung penjualan hari ini
        $todaySales = Sale::whereDate('created_at', Carbon::today())->sum('total');
        
        // ========== DATA GRAFIK PENJUALAN ==========
        
        // Penjualan per hari (7 hari terakhir)
        $salesByDay = Sale::whereBetween('created_at', [
            Carbon::now()->subDays(6)->startOfDay(),
            Carbon::now()->endOfDay()
        ])
        ->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
        // Format data untuk Chart.js
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::parse($date)->format('d M');
            
            $sale = $salesByDay->firstWhere('date', $date);
            $chartData[] = $sale ? $sale->total : 0;
        }
        
        // ========== PRODUK TERLARIS ==========
        
        // Top 5 produk terlaris bulan ini
        $topProducts = DB::table('sale_items')
            ->join('product_variants', 'sale_items.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereMonth('sales.created_at', Carbon::now()->month)
            ->whereYear('sales.created_at', Carbon::now()->year)
            ->select(
                'products.name',
                DB::raw('SUM(sale_items.quantity) as total_sold'),
                DB::raw('SUM(sale_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
        
        // ========== TRANSAKSI TERBARU ==========
        
        $recentTransactions = Sale::with('user')
            ->latest()
            ->limit(10)
            ->get();
        
        return view('admin.dashboard.index', compact(
            'salesToday',
            'salesThisWeek',
            'salesThisMonth',
            'profitToday',
            'profitThisWeek',
            'profitThisMonth',
            'transactionsToday',
            'totalProducts',
            'lowStockProducts',
            'totalUsers',
            'totalCashiers',
            'totalCustomers',
            'todaySales',
            'chartLabels',
            'chartData',
            'topProducts',
            'recentTransactions'
        ));
    }
    
    /**
     * Menghitung keuntungan bersih dalam periode tertentu
     * Keuntungan = (Harga Jual - Harga Modal) * Quantity
     */
    private function calculateProfit($startDate, $endDate)
    {
        $profit = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('product_variants', 'sale_items.product_variant_id', '=', 'product_variants.id')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->select(
                DB::raw('SUM((sale_items.price - product_variants.cost_price) * sale_items.quantity) as profit')
            )
            ->value('profit');
        
        return $profit ?? 0;
    }
}
