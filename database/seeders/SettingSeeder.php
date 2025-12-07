<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'store_name', 'value' => 'My E-Commerce Store', 'type' => 'string', 'group' => 'general'],
            ['key' => 'store_email', 'value' => 'store@example.com', 'type' => 'string', 'group' => 'general'],
            ['key' => 'store_phone', 'value' => '+1234567890', 'type' => 'string', 'group' => 'general'],
            ['key' => 'store_address', 'value' => '123 Main Street, City, Country', 'type' => 'string', 'group' => 'general'],
            
            // Shipping Settings
            ['key' => 'flat_shipping_rate', 'value' => '10', 'type' => 'number', 'group' => 'shipping'],
            ['key' => 'free_shipping_threshold', 'value' => '100', 'type' => 'number', 'group' => 'shipping'],
            
            // Email Settings
            ['key' => 'notification_email', 'value' => 'admin@example.com', 'type' => 'string', 'group' => 'email'],
            ['key' => 'order_confirmation_message', 'value' => 'Thank you for your order! We will process it shortly.', 'type' => 'string', 'group' => 'email'],
            
            // SEO Settings
            ['key' => 'seo_title', 'value' => 'Best Online Store - Quality Products', 'type' => 'string', 'group' => 'seo'],
            ['key' => 'seo_description', 'value' => 'Shop the best products at great prices. Free shipping on orders over $100.', 'type' => 'string', 'group' => 'seo'],
            ['key' => 'seo_keywords', 'value' => 'online shopping, ecommerce, quality products, best deals', 'type' => 'string', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        $this->command->info('Settings created successfully!');
    }
}
