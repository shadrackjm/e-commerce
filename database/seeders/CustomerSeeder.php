<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Address;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test customer
        $testCustomer = Customer::create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create default address for test customer
        Address::factory()->default()->create([
            'customer_id' => $testCustomer->id,
        ]);

        // Create additional address
        Address::factory()->create([
            'customer_id' => $testCustomer->id,
        ]);

        // Create 50 more customers
        $this->command->info('Creating customers...');
        $bar = $this->command->getOutput()->createProgressBar(50);

        for ($i = 0; $i < 50; $i++) {
            $customer = Customer::factory()->create();

            // Create 1-3 addresses per customer
            Address::factory()->default()->create([
                'customer_id' => $customer->id,
            ]);

            if (rand(0, 100) > 50) {
                Address::factory()->create([
                    'customer_id' => $customer->id,
                ]);
            }

            // Create 0-3 reviews per customer
            $reviewCount = rand(0, 3);
            for ($j = 0; $j < $reviewCount; $j++) {
                Review::factory()->create([
                    'customer_id' => $customer->id,
                    'product_id' => Product::inRandomOrder()->first()->id,
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('Customers created successfully!');
    }
}
