<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CashierReportController extends Controller
{
    public function index(Request $request)
    {
        $cashierId = Auth::id();
        
        // Default: Hari ini
        $startDate = $request->start_date ?? Carbon::today()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::today()->format('Y-m-d');
        
        // Query hanya transaksi kasir yang login
        $query = Sale::with(['user', 'items.variant.product'])
            ->where('cashier_id', $cashierId)
            ->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        
        // Filter payment method
        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }
        
        $sales = $query->latest()->get();
        
        // Hitung metrik
        $totalTransaksi = $sales->count();
        $totalPenjualan = $sales->sum('total');
        $totalDiscount = $sales->sum('discount');
        
        // Group by payment method
        $paymentSummary = $sales->groupBy('payment_method')->map(function($group) {
            return [
                'count' => $group->count(),
                'total' => $group->sum('total')
            ];
        });
        
        // Hitung keuntungan
        $totalKeuntungan = $this->calculateProfit($sales);
        
        return view('cashier.reports.index', compact(
            'sales', 
            'totalTransaksi', 
            'totalPenjualan',
            'totalDiscount',
            'totalKeuntungan',
            'paymentSummary',
            'startDate',
            'endDate'
        ));
    }
    
    private function calculateProfit($sales)
    {
        $totalProfit = 0;
        
        foreach ($sales as $sale) {
            foreach ($sale->items as $item) {
                $sellingPrice = $item->price;
                $purchasePrice = $item->variant->purchase_price ?? 0;
                $profit = ($sellingPrice - $purchasePrice) * $item->quantity;
                $totalProfit += $profit;
            }
        }
        
        return $totalProfit;
    }
    
    public function exportPdf(Request $request)
    {
        $cashierId = Auth::id();
        $cashierName = Auth::user()->name;
        
        $startDate = $request->start_date ?? Carbon::today()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::today()->format('Y-m-d');
        
        $query = Sale::with(['user', 'items.variant.product'])
            ->where('cashier_id', $cashierId)
            ->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        
        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }
        
        $sales = $query->latest()->get();
        
        $totalTransaksi = $sales->count();
        $totalPenjualan = $sales->sum('total');
        $totalDiscount = $sales->sum('discount');
        $totalKeuntungan = $this->calculateProfit($sales);
        
        $paymentSummary = $sales->groupBy('payment_method')->map(function($group) {
            return [
                'count' => $group->count(),
                'total' => $group->sum('total')
            ];
        });
        
        $pdf = Pdf::loadView('cashier.reports.pdf', compact(
            'sales',
            'totalTransaksi',
            'totalPenjualan',
            'totalDiscount',
            'totalKeuntungan',
            'paymentSummary',
            'startDate',
            'endDate',
            'cashierName'
        ));
        
        $filename = "tutup-kasir-{$startDate}.pdf";
        
        return $pdf->download($filename);
    }
}
