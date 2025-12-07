<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $brands = Brand::all();

        // Create 100 products
        $this->command->info('Creating products...');
        $bar = $this->command->getOutput()->createProgressBar(100);

        for ($i = 0; $i < 100; $i++) {
            $product = Product::factory()->create([
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
            ]);

            // Create 2-4 images per product
            for ($j = 0; $j < rand(2, 4); $j++) {
                ProductImage::factory()->create([
                    'product_id' => $product->id,
                    'is_primary' => $j === 0,
                    'sort_order' => $j,
                ]);
            }

            // Create variants for 30% of products
            if ($product->has_variants) {
                $colors = ['Red', 'Blue', 'Black', 'White', 'Green'];
                $sizes = ['S', 'M', 'L', 'XL'];

                foreach ($colors as $colorIndex => $color) {
                    foreach ($sizes as $sizeIndex => $size) {
                        if (rand(0, 100) > 50) { // Randomly skip some combinations
                            ProductVariant::factory()->create([
                                'product_id' => $product->id,
                                'name' => "$color - $size",
                                'options' => json_encode(['color' => $color, 'size' => $size]),
                                'price' => $product->price + rand(0, 20),
                                'sort_order' => ($colorIndex * count($sizes)) + $sizeIndex,
                            ]);
                        }
                    }
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('Products created successfully!');
    }
}
