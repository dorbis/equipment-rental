<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Celtniecības aprīkojums',
            'Dārza tehnika',
            'Instrumenti',
            'Transporta aprīkojums',
            'Pakalpojumi',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category,
            ]);
        }
    }
}