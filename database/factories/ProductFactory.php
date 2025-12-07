<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);
        $name = ucwords($name);
        $price = fake()->randomFloat(2, 10, 500);
        $comparePrice = fake()->boolean(30) ? $price * fake()->randomFloat(2, 1.1, 1.5) : null;

        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'brand_id' => fake()->boolean(80) ? (Brand::inRandomOrder()->first()?->id ?? Brand::factory()) : null,
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'short_description' => fake()->sentence(15),
            'description' => '<p>' . fake()->paragraph(10) . '</p><p>' . fake()->paragraph(8) . '</p>',
            'price' => $price,
            'compare_price' => $comparePrice,
            'cost_price' => $price * 0.6,
            'stock_quantity' => fake()->numberBetween(0, 500),
            'low_stock_threshold' => 10,
            'manage_stock' => true,
            'stock_status' => fake()->randomElement(['in_stock', 'in_stock', 'in_stock', 'out_of_stock']),
            'is_active' => fake()->boolean(95),
            'is_featured' => fake()->boolean(20),
            'has_variants' => fake()->boolean(30),
            'weight' => fake()->randomFloat(2, 0.1, 50),
            'meta_title' => $name,
            'meta_description' => fake()->sentence(20),
            'views_count' => fake()->numberBetween(0, 1000),
        ];
    }
}
