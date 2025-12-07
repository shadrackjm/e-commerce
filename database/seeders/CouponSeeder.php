<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10,
                'minimum_order_value' => 50,
                'expires_at' => now()->addMonths(3),
            ],
            [
                'code' => 'SAVE20',
                'type' => 'fixed',
                'value' => 20,
                'minimum_order_value' => 100,
                'expires_at' => now()->addMonths(2),
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'fixed',
                'value' => 10,
                'minimum_order_value' => null,
                'usage_limit' => 100,
                'expires_at' => now()->addMonth(),
            ],
            [
                'code' => 'SUMMER25',
                'type' => 'percentage',
                'value' => 25,
                'minimum_order_value' => 200,
                'maximum_discount' => 50,
                'expires_at' => now()->addMonths(3),
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create([
                'code' => $coupon['code'],
                'type' => $coupon['type'],
                'value' => $coupon['value'],
                'minimum_order_value' => $coupon['minimum_order_value'] ?? null,
                'maximum_discount' => $coupon['maximum_discount'] ?? null,
                'usage_limit' => $coupon['usage_limit'] ?? null,
                'usage_limit_per_customer' => 1,
                'starts_at' => now(),
                'expires_at' => $coupon['expires_at'],
                'is_active' => true,
            ]);
        }

        // Create 10 more random coupons
        Coupon::factory()->count(10)->create();

        $this->command->info('Coupons created successfully!');
    }
}
