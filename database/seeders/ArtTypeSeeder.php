<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\ArtType;

class ArtTypeSeeder extends Seeder
{
    public function run()
    {
        ArtType::create(['name' => 'Bookmarks']);
        ArtType::create(['name' => 'Drawings']);
        ArtType::create(['name' => 'Collage']);
    }
}
