<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Tampil semua barang dengan filter
     * Filter: tersedia, habis stok, kadaluarsa
     */
    public function index(Request $request)
    {
        $query = Product::with('variants');
        
        $products = $query->get();
        
        // Filter berdasarkan status
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'out_of_stock':
                    // Produk dengan semua varian stok = 0
                    $products = $products->filter(function($product) {
                        return $product->variants->sum('stock') == 0;
                    });
                    break;
                    
                case 'expired':
                    // Produk dengan minimal 1 varian kadaluarsa
                    $products = $products->filter(function($product) {
                        return $product->variants->where('expiry_date', '<', now())->count() > 0;
                    });
                    break;
                    
                case 'available':
                    // Produk dengan stok > 0 dan tidak kadaluarsa
                    $products = $products->filter(function($product) {
                        return $product->variants->where('stock', '>', 0)
                            ->where('expiry_date', '>=', now())
                            ->count() > 0;
                    });
                    break;
            }
        }
        
        return view('admin.products.index', compact('products'));
    }

    // form tambah barang
    public function create()
    {
        return view('admin.products.create');
    }

    // simpan barang baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // edit barang
    public function edit(Product $product)
    {
        $product->load('variants');
        return view('admin.products.edit', compact('product'));
    }

    // update barang
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'is_early_access' => 'nullable|boolean',
        ]);

        // Handle checkbox (jika tidak dicentang, tidak ada di request)
        $validated['is_early_access'] = $request->has('is_early_access') ? 1 : 0;

        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // hapus barang
    public function destroy(Product $product)
    {
        try {
            // Cek apakah ada transaksi yang menggunakan variant dari produk ini
            $hasTransactions = DB::table('sale_items')
                ->whereIn('product_variant_id', $product->variants()->pluck('id'))
                ->exists();
            
            if ($hasTransactions) {
                return back()->with('error', 'Produk tidak dapat dihapus karena sudah ada dalam riwayat transaksi. Anda dapat menonaktifkan produk dengan mengubah stok menjadi 0.');
            }
            
            // Hapus gambar jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Hapus variants terlebih dahulu
            $product->variants()->delete();
            
            // Hapus produk
            $product->delete();

            return back()->with('success', 'Produk berhasil dihapus!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}
