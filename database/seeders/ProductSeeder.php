<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Golden',
            'description' => 'Golden Drawing',
            'stock' => 10,
            'price' => 100,
            'arttype_id' => 1, // Assuming you have IDs for bookmarks, drawings, and collage
        ]);

        Product::create([
            'name' => 'Princess Bubblegum',
            'description' => 'Princess Bubblegum Drawing',
            'stock' => 10,
            'price' => 100,
            'arttype_id' => 1, // Assuming you have IDs for bookmarks, drawings, and collage
        ]);

        Product::create([
            'name' => 'Miku Drawing',
            'description' => 'Princess Bubblegum Drawing',
            'stock' => 10,
            'price' => 60,
            'arttype_id' => 1, // Assuming you have IDs for bookmarks, drawings, and collage
        ]);

        Product::create([
            'name' => 'Bookmark 1',
            'description' => 'Bookmark 1 Description',
            'stock' => 10,
            'price' => 60,
            'arttype_id' => 0, // Assuming you have IDs for bookmarks, drawings, and collage
        ]);

        Product::create([
            'name' => 'Bookmark 2',
            'description' => 'Bookmark 2 Description',
            'stock' => 10,
            'price' => 60,
            'arttype_id' => 0, // Assuming you have IDs for bookmarks, drawings, and collage
        ]);

    }
}
