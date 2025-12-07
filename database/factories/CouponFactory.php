<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['fixed', 'percentage']);
        $value = $type === 'percentage' ? fake()->numberBetween(5, 50) : fake()->numberBetween(5, 100);

        return [
            'code' => strtoupper(Str::random(8)),
            'type' => $type,
            'value' => $value,
            'minimum_order_value' => fake()->boolean(50) ? fake()->numberBetween(50, 200) : null,
            'maximum_discount' => $type === 'percentage' ? fake()->numberBetween(20, 100) : null,
            'usage_limit' => fake()->boolean(70) ? fake()->numberBetween(10, 100) : null,
            'usage_limit_per_customer' => fake()->boolean(80) ? fake()->numberBetween(1, 5) : null,
            'starts_at' => now()->subDays(fake()->numberBetween(0, 30)),
            'expires_at' => now()->addDays(fake()->numberBetween(30, 90)),
            'is_active' => true,
        ];
    }
}
