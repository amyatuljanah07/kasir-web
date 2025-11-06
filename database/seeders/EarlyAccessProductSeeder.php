<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class EarlyAccessProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Produk Early Access 1: Premium Coffee
        $coffee = Product::create([
            'name' => 'Premium Arabica Coffee',
            'description' => 'Kopi Arabica premium dari pegunungan Gayo, Aceh. Eksklusif untuk member!',
            'category' => 'Beverages',
            'is_early_access' => true,
            'early_access_until' => now()->addDays(30), // Early access selama 30 hari
        ]);

        ProductVariant::create([
            'product_id' => $coffee->id,
            'variant_name' => '250g',
            'cost_price' => 60000,
            'price' => 85000,
            'stock' => 50,
        ]);

        ProductVariant::create([
            'product_id' => $coffee->id,
            'variant_name' => '500g',
            'cost_price' => 110000,
            'price' => 150000,
            'discount' => 15000, // Diskon 10%
            'stock' => 30,
        ]);

        // Produk Early Access 2: Smart Watch
        $watch = Product::create([
            'name' => 'Smart Watch Pro',
            'description' => 'Smartwatch terbaru dengan fitur kesehatan lengkap. Dapatkan lebih dulu sebelum rilis!',
            'category' => 'Electronics',
            'is_early_access' => true,
            'early_access_until' => now()->addDays(45),
        ]);

        ProductVariant::create([
            'product_id' => $watch->id,
            'variant_name' => 'Black',
            'cost_price' => 900000,
            'price' => 1200000,
            'discount' => 180000, // Diskon 15%
            'stock' => 20,
        ]);

        ProductVariant::create([
            'product_id' => $watch->id,
            'variant_name' => 'Silver',
            'cost_price' => 900000,
            'price' => 1200000,
            'stock' => 15,
        ]);

        // Produk Early Access 3: Organic Skincare Set
        $skincare = Product::create([
            'name' => 'Organic Skincare Set',
            'description' => 'Paket perawatan kulit organik eksklusif untuk member. Limited edition!',
            'category' => 'Beauty',
            'is_early_access' => true,
            'early_access_until' => now()->addDays(20),
        ]);

        ProductVariant::create([
            'product_id' => $skincare->id,
            'variant_name' => 'Full Set',
            'cost_price' => 250000,
            'price' => 350000,
            'discount' => 70000, // Diskon 20%
            'stock' => 25,
        ]);

        ProductVariant::create([
            'product_id' => $skincare->id,
            'variant_name' => 'Travel Size',
            'cost_price' => 100000,
            'price' => 150000,
            'stock' => 40,
        ]);

        // Produk Early Access 4: Premium Headphones
        $headphones = Product::create([
            'name' => 'Wireless Noise Cancelling Headphones',
            'description' => 'Headphone premium dengan teknologi noise cancelling terbaru. Pre-order eksklusif member!',
            'category' => 'Electronics',
            'is_early_access' => true,
            'early_access_until' => now()->addDays(60),
        ]);

        ProductVariant::create([
            'product_id' => $headphones->id,
            'variant_name' => 'Midnight Black',
            'cost_price' => 1800000,
            'price' => 2500000,
            'discount' => 625000, // Diskon 25%
            'stock' => 10,
        ]);

        ProductVariant::create([
            'product_id' => $headphones->id,
            'variant_name' => 'Pearl White',
            'cost_price' => 1800000,
            'price' => 2500000,
            'discount' => 625000, // Diskon 25%
            'stock' => 10,
        ]);

        // Produk Early Access 5: Gaming Mouse
        $mouse = Product::create([
            'name' => 'RGB Gaming Mouse Pro',
            'description' => 'Gaming mouse profesional dengan 16000 DPI. Launching eksklusif untuk member!',
            'category' => 'Electronics',
            'is_early_access' => true,
            'early_access_until' => now()->addDays(15),
        ]);

        ProductVariant::create([
            'product_id' => $mouse->id,
            'variant_name' => 'Wired',
            'cost_price' => 320000,
            'price' => 450000,
            'stock' => 35,
        ]);

        ProductVariant::create([
            'product_id' => $mouse->id,
            'variant_name' => 'Wireless',
            'cost_price' => 480000,
            'price' => 650000,
            'discount' => 65000, // Diskon 10%
            'stock' => 25,
        ]);

        // Produk Early Access 6: Organic Green Tea
        $tea = Product::create([
            'name' => 'Premium Organic Green Tea',
            'description' => 'Teh hijau organik premium dari Jepang. Koleksi terbatas untuk member setia!',
            'category' => 'Beverages',
            'is_early_access' => true,
            'early_access_until' => now()->addDays(25),
        ]);

        ProductVariant::create([
            'product_id' => $tea->id,
            'variant_name' => '100g Tin',
            'cost_price' => 85000,
            'price' => 120000,
            'stock' => 40,
        ]);

        ProductVariant::create([
            'product_id' => $tea->id,
            'variant_name' => '250g Premium Box',
            'cost_price' => 200000,
            'price' => 280000,
            'discount' => 42000, // Diskon 15%
            'stock' => 20,
        ]);

        $this->command->info('✅ 6 Produk Early Access berhasil ditambahkan!');
        $this->command->info('📦 Total variant: ' . ProductVariant::whereIn('product_id', [$coffee->id, $watch->id, $skincare->id, $headphones->id, $mouse->id, $tea->id])->count());
    }
}
