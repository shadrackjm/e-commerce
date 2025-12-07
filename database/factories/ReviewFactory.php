<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rating = fake()->numberBetween(1, 5);
        
        return [
            'product_id' => Product::factory(),
            'customer_id' => Customer::factory(),
            'order_id' => null,
            'rating' => $rating,
            'title' => fake()->sentence(5),
            'comment' => fake()->paragraph(3),
            'is_verified_purchase' => fake()->boolean(70),
            'is_approved' => fake()->boolean(80),
        ];
    }
}
