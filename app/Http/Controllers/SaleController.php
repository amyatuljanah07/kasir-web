<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.variant_id' => 'required|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        DB::beginTransaction();

        try {
            $total = 0;

            foreach ($data['items'] as $item) {
                $variant = ProductVariant::lockForUpdate()->find($item['variant_id']);

                if (!$variant || $variant->stock < $item['quantity']) {
                    throw new \Exception('Stok tidak cukup untuk ' . $variant->variant_name);
                }

                if ($variant->expiry_date && $variant->expiry_date <= Carbon::today()) {
                    throw new \Exception('Barang ' . $variant->variant_name . ' sudah kadaluarsa');
                }

                $subtotal = $variant->price * $item['quantity'];
                if ($variant->discount > 0) {
                    $subtotal -= ($variant->discount / 100) * $subtotal;
                }

                $total += $subtotal;
            }

            // Diskon member
            $discount = 0;
            if ($user->is_member && $user->membership) {
                $memberDiscount = ($user->membership->discount_percentage / 100) * $total;
                $discount = $memberDiscount;
                $total -= $memberDiscount;
            }

            // buat transaksi utama
            $sale = Sale::create([
                'user_id' => $user->id,
                'cashier_id' => $user->id, // Simpan cashier_id
                'customer_name' => $user->name, // Simpan customer_name
                'total' => $total,
                'discount' => $discount,
                'payment_method' => $data['payment_method'],
                'paid_amount' => $data['paid_amount'],
                'change' => $data['paid_amount'] - $total,
                'barcode' => 'PAY-' . now()->format('YmdHis') . '-' . rand(1000, 9999),
            ]);

            // simpan item
            foreach ($data['items'] as $item) {
                $variant = ProductVariant::find($item['variant_id']);
                $subtotal = $variant->price * $item['quantity'];
                if ($variant->discount > 0) {
                    $subtotal -= ($variant->discount / 100) * $subtotal;
                }

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $item['quantity'],
                    'price' => $variant->price,
                    'discount' => $variant->discount,
                    'subtotal' => $subtotal,
                ]);

                $variant->decrement('stock', $item['quantity']);
            }

            DB::commit();
            return response()->json(['message' => 'Transaksi berhasil', 'sale_id' => $sale->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Tampilkan struk transaksi
     * Load semua relasi yang diperlukan untuk struk
     */
    public function receipt(Sale $sale)
    {
        try {
            $sale->load('items.variant.product', 'user');
            
            // Generate PDF menggunakan dompdf
            $pdf = Pdf::loadView('pos.receipt', compact('sale'));
            $pdf->setPaper([0, 0, 226.77, 841.89], 'portrait'); // 80mm width thermal paper
            
            return $pdf->stream('struk-' . $sale->id . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencetak struk: ' . $e->getMessage()
            ], 500);
        }
    }
}
