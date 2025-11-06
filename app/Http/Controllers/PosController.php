<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PosController extends Controller
{
    /**
     * Tampilkan halaman POS dengan katalog barang
     * Menampilkan semua produk dengan varian yang tersedia
     */
    public function index()
    {
        // Ambil semua varian produk yang stoknya > 0 dan belum kadaluarsa (lebih efisien)
        $variants = ProductVariant::with('product')
            ->where('stock', '>', 0)
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>=', Carbon::now());
            })
            ->get();
        
        // Ambil daftar customer untuk dropdown
        $customers = \App\Models\User::where('role_id', 3) // role customer
                     ->where('is_active', true)
                     ->select('id', 'name', 'email', 'is_member')
                     ->orderBy('name')
                     ->get();
        
        return view('pos.index', compact('variants', 'customers'));
    }
    
    /**
     * Scan barcode dan cari barang
     * Validasi stok dan tanggal kadaluarsa
     */
    public function scanBarcode(Request $request)
    {
        $barcode = $request->barcode;
        
        // Cari varian berdasarkan barcode
        $variant = ProductVariant::with('product')
            ->where('barcode', $barcode)
            ->first();
        
        if (!$variant) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }
        
        // Validasi stok
        if ($variant->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok barang habis'
            ], 400);
        }
        
        // Validasi kadaluarsa
        if ($variant->expiry_date && Carbon::parse($variant->expiry_date)->lt(Carbon::now())) {
            return response()->json([
                'success' => false,
                'message' => 'Barang sudah kadaluarsa dan tidak dapat dijual'
            ], 400);
        }
        
        // Hitung harga setelah diskon
        $priceAfterDiscount = $variant->price * (1 - ($variant->discount / 100));
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $variant->id,
                'product_name' => $variant->product->name,
                'variant_name' => $variant->variant_name,
                'price' => $variant->price,
                'discount' => $variant->discount,
                'price_after_discount' => $priceAfterDiscount,
                'stock' => $variant->stock,
            ]
        ]);
    }
    
    /**
     * Register customer baru oleh kasir sebagai member
     * Data: nama, email, no HP, alamat
     * Otomatis jadi member dengan password default: member123
     */
    public function registerCustomer(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
            ]);
            
            $customer = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'password' => \Illuminate\Support\Facades\Hash::make('member123'), // Password default
                'role_id' => 3, // customer
                'is_member' => true, // otomatis member
                'is_active' => true,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Member berhasil didaftarkan!',
                'data' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'is_member' => true,
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    /**
     * Checkout dan simpan transaksi
     * Validasi stok, hitung total, simpan ke database
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.variant_id' => 'required|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:tunai,cash,bank,debit,credit,qris',
            'paid_amount' => 'required|numeric|min:0',
            'customer_id' => 'nullable|exists:users,id',
            'customer_name' => 'nullable|string|max:255',
        ]);
        
        DB::beginTransaction();
        
        try {
            $subtotal = 0;
            $items = [];
            
            // Validasi dan hitung subtotal
            foreach ($request->items as $item) {
                $variant = ProductVariant::find($item['variant_id']);
                
                // Validasi stok
                if ($variant->stock < $item['quantity']) {
                    throw new \Exception("Stok {$variant->variant_name} tidak mencukupi");
                }
                
                // Validasi kadaluarsa
                if ($variant->expiry_date && Carbon::parse($variant->expiry_date)->lt(Carbon::now())) {
                    throw new \Exception("{$variant->variant_name} sudah kadaluarsa");
                }
                
                // Hitung subtotal dengan diskon produk
                $priceAfterDiscount = $variant->price * (1 - ($variant->discount / 100));
                $itemSubtotal = $priceAfterDiscount * $item['quantity'];
                $subtotal += $itemSubtotal;
                
                $items[] = [
                    'variant' => $variant,
                    'quantity' => $item['quantity'],
                    'price' => $priceAfterDiscount,
                    'subtotal' => $itemSubtotal,
                ];
            }
            
            // Cek member discount (5%)
            $memberDiscount = 0;
            $isMember = false;
            if ($request->customer_id) {
                $customer = \App\Models\User::find($request->customer_id);
                if ($customer && $customer->is_member) {
                    $memberDiscount = $subtotal * 0.05; // 5% diskon member
                    $isMember = true;
                }
            }
            
            $finalTotal = $subtotal - $memberDiscount;
            
            // Validasi pembayaran untuk cash/tunai
            if (in_array($request->payment_method, ['cash', 'tunai']) && $request->paid_amount < $finalTotal) {
                throw new \Exception('Jumlah pembayaran kurang dari total');
            }
            
            // Generate barcode transaksi
            $barcode = 'TRX' . date('YmdHis') . rand(100, 999);
            
            // Simpan transaksi
            $sale = Sale::create([
                'user_id' => $request->customer_id, // ID customer (nullable)
                'cashier_id' => auth()->user()->id, // ID kasir yang melakukan transaksi
                'customer_name' => $request->customer_name ?? 'Customer',
                'total' => $finalTotal,
                'discount' => $memberDiscount,
                'payment_method' => $request->payment_method,
                'paid_amount' => $request->paid_amount,
                'change' => in_array($request->payment_method, ['cash', 'tunai']) ? $request->paid_amount - $finalTotal : 0,
                'barcode' => $barcode,
            ]);
            
            // Simpan detail transaksi dan kurangi stok
            foreach ($items as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_variant_id' => $item['variant']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => $item['variant']->discount,
                    'subtotal' => $item['subtotal'],
                ]);
                
                // Kurangi stok
                $item['variant']->decrement('stock', $item['quantity']);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'data' => [
                    'sale_id' => $sale->id,
                    'barcode' => $barcode,
                    'subtotal' => $subtotal,
                    'member_discount' => $memberDiscount,
                    'total' => $finalTotal,
                    'paid_amount' => $request->paid_amount,
                    'change' => $sale->change,
                    'is_member' => $isMember,
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
