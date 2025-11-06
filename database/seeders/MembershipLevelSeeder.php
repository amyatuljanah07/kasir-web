<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('membership_levels')->insert([
            [
                'name' => 'Nova',
                'slug' => 'nova',
                'min_spending' => 0,
                'discount_rate' => 5.00,
                'points_multiplier' => 1,
                'benefits' => json_encode([
                    'Diskon 5% untuk setiap pembelian',
                    'Akses ke katalog produk eksklusif',
                    'Notifikasi produk baru',
                    'Poin reward 1x'
                ]),
                'badge_color' => '#10B981',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Stellar',
                'slug' => 'stellar',
                'min_spending' => 1000000,
                'discount_rate' => 10.00,
                'points_multiplier' => 2,
                'benefits' => json_encode([
                    'Diskon 10% untuk setiap pembelian',
                    'Akses early bird untuk produk baru',
                    'Voucher ulang tahun spesial',
                    'Poin reward 2x',
                    'Free shipping (khusus event)'
                ]),
                'badge_color' => '#3B82F6',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Galaxy',
                'slug' => 'galaxy',
                'min_spending' => 5000000,
                'discount_rate' => 15.00,
                'points_multiplier' => 3,
                'benefits' => json_encode([
                    'Diskon 15% untuk setiap pembelian',
                    'Akses VIP produk limited edition',
                    'Personal shopping assistant',
                    'Poin reward 3x',
                    'Free shipping unlimited',
                    'Event eksklusif member Galaxy',
                    'Voucher spesial setiap bulan'
                ]),
                'badge_color' => '#8B5CF6',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
