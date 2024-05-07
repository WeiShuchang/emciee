<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Product 1',
            'description' => 'Description of Product 1',
            'stock' => 10,
            'price' => 100,
            'arttype_id' => 1, // Assuming you have IDs for bookmarks, drawings, and collage
        ]);

        // Add more products as needed
    }
}
