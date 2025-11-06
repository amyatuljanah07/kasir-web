<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product 1: Sabun Mandi
        $product1 = \App\Models\Product::create([
            'name' => 'Sabun Mandi',
            'description' => 'Sabun wangi dengan berbagai varian ukuran',
            'image' => null
        ]);

        \App\Models\ProductVariant::create([
            'product_id' => $product1->id,
            'variant_name' => '250ml',
            'barcode' => 'BC-SABUN-250',
            'stock' => 50,
            'price' => 20000,
            'discount' => 0,
            'cost_price' => 12000,
            'expiry_date' => now()->addMonths(6)->toDateString()
        ]);

        \App\Models\ProductVariant::create([
            'product_id' => $product1->id,
            'variant_name' => '500ml',
            'barcode' => 'BC-SABUN-500',
            'stock' => 30,
            'price' => 35000,
            'discount' => 2000,
            'cost_price' => 20000,
            'expiry_date' => now()->addMonths(8)->toDateString()
        ]);

        // Product 2: Shampo
        $product2 = \App\Models\Product::create([
            'name' => 'Shampo Anti Ketombe',
            'description' => 'Shampo khusus mengatasi ketombe',
            'image' => null
        ]);

        \App\Models\ProductVariant::create([
            'product_id' => $product2->id,
            'variant_name' => '200ml',
            'barcode' => 'BC-SHAMPO-200',
            'stock' => 40,
            'price' => 25000,
            'discount' => 0,
            'cost_price' => 15000,
            'expiry_date' => now()->addMonths(12)->toDateString()
        ]);

        // Product 3: Pasta Gigi
        $product3 = \App\Models\Product::create([
            'name' => 'Pasta Gigi',
            'description' => 'Pasta gigi untuk gigi putih bersih',
            'image' => null
        ]);

        \App\Models\ProductVariant::create([
            'product_id' => $product3->id,
            'variant_name' => '150g',
            'barcode' => 'BC-PASTA-150',
            'stock' => 60,
            'price' => 15000,
            'discount' => 1000,
            'cost_price' => 9000,
            'expiry_date' => now()->addMonths(18)->toDateString()
        ]);
    }
}
