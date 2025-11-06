<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\VirtualCard;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isMember = $user->membership && $user->membership->is_active;
        
        // Get popular products (by sales count)
        $popularProducts = Product::popular(8)
            ->with(['variants' => function($query) {
                $query->where('stock', '>', 0);
            }])
            ->when(!$isMember, function($query) {
                // Non-members can't see early access products
                $query->where(function($q) {
                    $q->where('is_early_access', false)
                      ->orWhere(function($q2) {
                          $q2->where('is_early_access', true)
                             ->where('early_access_until', '<', now());
                      });
                });
            })
            ->get();
        
        // Get all products with variants that have stock
        $products = Product::with(['variants' => function($query) {
            $query->where('stock', '>', 0);
        }])
            ->when(!$isMember, function($query) {
                // Non-members can't see early access products
                $query->where(function($q) {
                    $q->where('is_early_access', false)
                      ->orWhere(function($q2) {
                          $q2->where('is_early_access', true)
                             ->where('early_access_until', '<', now());
                      });
                });
            })
            ->get();
        
        $virtualCard = $user->virtualCard;
        $balance = $user->balance;
        $membership = $user->membership;
        
        return view('customer.shop.index', compact('products', 'popularProducts', 'virtualCard', 'balance', 'membership'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'pin' => 'required|digits:4'
        ]);

        $user = auth()->user();
        $virtualCard = $user->virtualCard;

        // Validasi PIN
        if (!$virtualCard->validatePin($request->pin)) {
            return response()->json([
                'success' => false,
                'message' => 'PIN salah! Silakan coba lagi.'
            ], 400);
        }

        // Validasi status kartu
        if ($virtualCard->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Kartu Anda tidak aktif. Hubungi admin.'
            ], 400);
        }

        $cart = $request->cart;
        $total = 0;

        // Hitung total dan validasi stok
        foreach ($cart as $item) {
            $variant = ProductVariant::find($item['variant_id']);
            
            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan.'
                ], 400);
            }

            if ($variant->stock < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok {$variant->product->name} tidak mencukupi."
                ], 400);
            }

            $price = $variant->discount_price ?? $variant->price;
            $total += $price * $item['quantity'];
        }

        // Apply membership discount (NOVA: 5%)
        $discountAmount = 0;
        $membershipDiscount = 0;
        if ($user->membership && $user->membership->is_active) {
            $membershipDiscount = $user->membership->discount_rate ?? 0;
            $discountAmount = $total * ($membershipDiscount / 100);
            $total = $total - $discountAmount;
        }

        // Validasi saldo
        if ($user->balance < $total) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo Anda tidak mencukupi. Saldo Anda: Rp ' . number_format((float)$user->balance, 0, ',', '.')
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Buat order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user->id,
                'total' => $total,
                'discount_amount' => $discountAmount,
                'payment_method' => 'balance',
                'status' => 'paid' // Langsung paid karena saldo terpotong
            ]);

            // Buat order items dan kurangi stok
            foreach ($cart as $item) {
                $variant = ProductVariant::find($item['variant_id']);
                $price = $variant->discount_price ?? $variant->price;
                $subtotal = $price * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'subtotal' => $subtotal
                ]);

                // Kurangi stok
                $variant->decrement('stock', $item['quantity']);
                
                // Increment sales count
                $variant->product->incrementSales($item['quantity']);
            }

            // Kurangi saldo user
            $user->deductBalance($total, 'Pembayaran belanja - Order #' . $order->order_number);
            
            // Update membership spending jika user adalah member
            if ($user->membership) {
                $levelUp = $user->membership->addSpending($total, $user->membership->level->points_multiplier ?? 1);
                
                if ($levelUp) {
                    session()->flash('level_up', 'Selamat! Anda naik ke level ' . $levelUp->name . '!');
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil! Silakan ambil pesanan Anda di kasir.',
                'order_number' => $order->order_number,
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
