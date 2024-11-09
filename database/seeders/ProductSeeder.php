<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Initialize Faker
        $faker = Faker::create();

        // Get categories and suppliers
        $categories = Category::pluck('id')->toArray();
        $suppliers = Supplier::pluck('id')->toArray();

        // Log categories and suppliers to ensure they're fetched correctly
        Log::info('Categories: ' . implode(', ', $categories));
        Log::info('Suppliers: ' . implode(', ', $suppliers));

        // Check if categories and suppliers exist
        if (empty($categories) || empty($suppliers)) {
            Log::error('No categories or suppliers found in the database!');
            return;
        }

        // Generate 50 random products
        foreach (range(1, 50) as $index) {
            $imageUrl = 'https://picsum.photos/200/300?random=' . $index; // Random image from Lorem Picsum

            $productData = [
                'name' => $faker->word,
                'description' => $faker->paragraph,
                'category_id' => $faker->randomElement($categories),
                'supplier_id' => $faker->randomElement($suppliers),
                'price' => $faker->randomFloat(2, 10, 500),
                'discounted_price' => $faker->randomFloat(2, 5, 400),
                'stock_quantity' => $faker->numberBetween(0, 100),
                'ethnic_culture' => $faker->word,
                'seasonal_demand' => $faker->boolean,
                'recommended' => $faker->boolean,
                'ai_demand_score' => $faker->randomFloat(2, 0, 1),
                'cultural_relevance_score' => $faker->randomFloat(2, 0, 1),
                'min_order_quantity' => $faker->numberBetween(1, 10),
                'unit' => 'piece',
                'sku' => $faker->unique()->word,
                'status' => $faker->randomElement(['available', 'out_of_stock', 'discontinued']),
                'image' => $imageUrl, // Store random image URL
            ];

            // Log the data to see if it's being generated
            Log::info('Inserting product: ' . json_encode($productData));

            try {
                // Create the product
                Product::create($productData);
                Log::info('Product created successfully: ' . $productData['name']);
            } catch (\Exception $e) {
                // Log the error if the product creation fails
                Log::error('Error creating product: ' . $productData['name'] . ' | Error: ' . $e->getMessage());
            }
        }
    }
}
