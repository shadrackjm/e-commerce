<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Electronics',
            'Fashion & Apparel',
            'Home & Garden',
            'Sports & Outdoors',
            'Books & Media',
            'Beauty & Personal Care',
            'Toys & Games',
            'Automotive',
            'Health & Wellness',
            'Office Supplies',
            'Pet Supplies',
            'Food & Beverages',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 100),
            'meta_title' => $name . ' - Shop Online',
            'meta_description' => fake()->sentence(20),
        ];
    }
}
