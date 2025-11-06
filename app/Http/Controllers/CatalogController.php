<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CatalogController extends Controller
{
    // tampil katalog
    public function index()
    {
        $products = Product::with(['variants' => function ($q) {
            $q->where('stock', '>', 0)
              ->where(function ($q2) {
                  $q2->whereNull('expiry_date')
                     ->orWhere('expiry_date', '>', Carbon::today());
              });
        }])->get();

        return view('catalog.index', compact('products'));
    }

    // cari barang by barcode (untuk scanner)
    public function variantByBarcode($barcode)
    {
        $variant = ProductVariant::where('barcode', $barcode)->first();

        if (!$variant) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        if ($variant->expiry_date && $variant->expiry_date <= Carbon::today()) {
            return response()->json(['error' => 'Barang kadaluarsa'], 400);
        }

        return response()->json($variant);
    }
}
