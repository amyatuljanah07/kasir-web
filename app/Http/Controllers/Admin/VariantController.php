<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    /**
     * Simpan varian baru
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'variant_name' => 'required|string|max:255',
            'barcode' => 'nullable|string|unique:product_variants,barcode',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'expiry_date' => 'nullable|date',
        ]);

        $validated['product_id'] = $product->id;
        $validated['discount'] = $validated['discount'] ?? 0;
        
        // Convert empty barcode to null
        if (empty($validated['barcode'])) {
            $validated['barcode'] = null;
        }

        ProductVariant::create($validated);

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Varian berhasil ditambahkan!');
    }

    /**
     * Update varian
     */
    public function update(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'variant_name' => 'required|string|max:255',
            'barcode' => 'nullable|string|unique:product_variants,barcode,' . $variant->id,
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'expiry_date' => 'nullable|date',
        ]);

        $validated['discount'] = $validated['discount'] ?? 0;
        
        // Convert empty barcode to null
        if (empty($validated['barcode'])) {
            $validated['barcode'] = null;
        }

        $variant->update($validated);

        return redirect()->route('admin.products.edit', $variant->product_id)
            ->with('success', 'Varian berhasil diperbarui!');
    }

    /**
     * Hapus varian
     */
    public function destroy(ProductVariant $variant)
    {
        $productId = $variant->product_id;
        $variant->delete();

        return redirect()->route('admin.products.edit', $productId)
            ->with('success', 'Varian berhasil dihapus!');
    }
}
