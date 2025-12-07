<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Latest gadgets and electronic devices'],
            ['name' => 'Fashion & Apparel', 'description' => 'Trendy clothing and accessories'],
            ['name' => 'Home & Garden', 'description' => 'Everything for your home and garden'],
            ['name' => 'Sports & Outdoors', 'description' => 'Gear for sports and outdoor activities'],
            ['name' => 'Books & Media', 'description' => 'Books, movies, music and more'],
            ['name' => 'Beauty & Personal Care', 'description' => 'Beauty products and personal care items'],
            ['name' => 'Toys & Games', 'description' => 'Fun toys and games for all ages'],
            ['name' => 'Automotive', 'description' => 'Car parts and automotive accessories'],
            ['name' => 'Health & Wellness', 'description' => 'Products for health and wellness'],
            ['name' => 'Pet Supplies', 'description' => 'Everything your pet needs'],
        ];

        foreach ($categories as $index => $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => \Illuminate\Support\Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
                'sort_order' => $index,
                'meta_title' => $category['name'] . ' - Shop Online',
                'meta_description' => $category['description'],
            ]);
        }

        $this->command->info('Categories created successfully!');
    }
}
