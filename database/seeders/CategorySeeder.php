<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $cats = ['Guns', 'Knives', 'Stickers', 'Gloves'];
        foreach ($cats as $name) {
            Category::updateOrCreate([
                'slug' => Str::slug($name),
            ], [
                'name' => $name,
            ]);
        }
    }
}
